<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers");
header("Access-Control-Allow-Headers: Authorization");
header("Access-Control-Allow-Headers: X-Requested-With");

// on vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ok on inclut les fichiers de configuration et d'accès aux données
    include_once('../settings/pdo.php');
    include_once('../modules/jwt.php');

    // on verifie si c'est un token
    if(isset($_SERVER['Authorization'])) {
        $token = trim($_SERVER['Authorization']);
    } elseif(isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $token = trim($_SERVER['HTTP_AUTHORIZATION']);
    } elseif(function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        if(isset($requestHeaders['Authorization'])) {
            $token = trim($requestHeaders['Authorization']);
        }
    }

    if(!isset($token) || !preg_match('/Bearer\s(\S+)/', $token)) {
        //
        http_response_code(400);
        echo json_encode(['message' => 'TOKEN Introuvable']);
        exit;
    }

    // On va extraire le token
    $token = str_replace('Bearer ', '', $token);

    require_once 'configApi.php';
    require_once 'jwt.php';

    // on verifie le format du token
    $validStringToken = validStringToken($token);
    if(!$validStringToken) {
        // refus
        http_response_code(400);
        echo json_encode(['message' => 'TOKEN invalide']);
        exit;
    }

    // on verifie la signature valide
    $validToken = checkToken($token);
    if(!$validToken) {
        // refus
        http_response_code(403);
        echo json_encode(['message' => 'TOKEN invalide']);
        exit;
    }

    // on verifie l'expiration du token
    $expired = expireToken($token);
    if($expired) {
        // refus
        http_response_code(403);
        echo json_encode(['message' => 'TOKEN expire']);
        exit;
    }


    echo json_encode(getPayload($token));

} else {
    // ko
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
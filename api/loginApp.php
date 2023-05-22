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
    include_once('../settings/configApi.php');
    include_once('../modules/jwt.php');
    include_once('../modules/login.php');

    // on récupère les informations du fichier reçu
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->email) && !empty($data->password)) {
        // réception des données
        // on filtre les caractères
        // fonction : updateOrderStatusById(PDO $pdo, string $newStatus, string $orderId)
        $userEmail = htmlspecialchars(strip_tags($data->email));
        $userPass = htmlspecialchars(strip_tags($data->password));

    // on lance la connexion de l'utilisateur
    $connect =  verifyUserToLog($pdo, $userEmail, $userPass);
    if($connect) {
        $userId = $connect['id'];
        $userRole = getUserRoles($pdo, $userId);
        $role = $userRole['roleName'];
        
        // on gère les valeurs :
        $type = HEADER_TYPE;
        $algo = HEADER_ALGO;

        // on crée le header
        $header = [
        'typ' => $type,
        'alg' => $algo
        ];

        // on crée le contenu (payload)
        $payload = [
            'id' => $userId
        ];

        // on obtien le token :
        // generateToken($header, $payload, $validity default = TOKEN_KEYS_VALIDITY)
        $token = generateToken($header, $payload);
        $activateToken = createToken($pdo, $token, $userId, $role);

        if($activateToken) {
            // code réponse 200
            http_response_code(200);
            // Encodage du fichier de réponse
            echo json_encode(["token" => "$token"]);
        }

    } else {
        // refus
        http_response_code(403);
        echo json_encode(['message' => 'email ou mot de passe invalide']);
        exit;
    }

    // on lui donne un token avec la transaction :
    // on efface l'ancien token et on en donne un nouveau à l'utilisateur
    } else {
        // ko
        http_response_code(403);
        echo json_encode(["message" => "Message vide"]);
    }

} else {
    // ko
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
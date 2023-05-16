<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers");
header("Access-Control-Allow-Headers: Authorization");
header("Access-Control-Allow-Headers: X-Requested-With");

// on vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    // ok on inclut les fichiers de configuration et d'accès aux données
    include_once('../settings/pdo.php');
    include_once('../modules/orders.php');

    // on récupère les informations du fichier reçu
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->orderPublicId)) {
        // réception des données
        // on filtre les caractères
        // fonction : deleteOrderByPublicId(PDO $pdo, string $orderId)
        $orderId = htmlspecialchars(strip_tags($data->orderPublicId));
        $deletedOrder = deleteOrderByPublicId($pdo, $orderId);

        if($deletedOrder) {
            // la suppression de commande est faite
            // code réponse 200
            http_response_code(200);
            // Encodage du fichier de réponse
            echo json_encode(["message" => "commande supprimee $orderId"]);
        } else {
            // la création de commande a échoué
            // code réponse 503
            http_response_code(503);
            // Encodage du fichier de réponse
            echo json_encode(["message" => "erreur impossible de supprimer la commande"]);
        }
    }


} else {
    // ko
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
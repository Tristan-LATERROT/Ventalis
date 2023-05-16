<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers");
header("Access-Control-Allow-Headers: Authorization");
header("Access-Control-Allow-Headers: X-Requested-With");

// on vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // ok on inclut les fichiers de configuration et d'accès aux données
    include_once('../settings/pdo.php');
    include_once('../modules/orders.php');

    // on déclare le statut de filtre
    $status = 'CREEE';
    // on récupère les données
    $orders = getOrdersByStatus($pdo, $status);

    if($orders) {
        // on initialise un tableau associatif
        $tableOrders = [];
        $tableOrders['orders'] = [];

        // on va parcourir les commandes
        foreach($orders as $row) {
            extract($row);

            $cde = [
                "orderId" => $row['orderId'],
                "orderPublicId" => $row['orderPublicId'],
                "orderCustomerId" => $row['orderCustomerId'],
                "orderTotalPrice" => $row['orderTotalPrice'],
                "orderStatusCode" => $row['orderStatusCode'],
                "orderTimestamp" => $row['orderTimestamp']
            ];

            $tableOrders['orders'][] = $cde;

        }

        // code réponse 200
        http_response_code(200);
        // Encodage du fichier de réponse
        echo json_encode($tableOrders);

    }

} else {
    // ko
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>
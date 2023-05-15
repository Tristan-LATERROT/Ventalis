<?php

// création des commandes pour y ajouter des lignes de commandes
function createOrder(PDO $pdo, string $customerId, string $totalPrice) {
    $sql = "INSERT INTO orders (orderId, orderPublicId, orderCustomerId, orderTotalPrice, orderStatusCode, orderTimestamp) VALUES (null, :PublicId, :customerId, :totalPrice, :statusCode, now())";
    $query = $pdo->prepare($sql);
    // generation de l'id de la commande
    $orderPublicId = 'CDE-'.uniqid();
    // code statut de création de commande
    $statusCode = 'CREEE';
    $query->bindParam(':PublicId', $orderPublicId, PDO::PARAM_STR);
    $query->bindParam(':customerId', $customerId, PDO::PARAM_STR);
    $query->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
    $query->bindParam(':statusCode', $statusCode, PDO::PARAM_STR);
    $query->execute();
    return $orderPublicId;
}

// création des lignes de commandes
function createOrderLine(PDO $pdo, string $linePublicId, string $lineOrderPublicId, int $lineIndex, int $lineItemId, int $lineItemBatchQty, $lineSubTotalPrice) {
    $sql = "INSERT INTO order_lines
    (orderLineId, orderLinePublicId, orderLineOrderPublicId, orderLineIndex, orderLineItemId, orderLineItemBatchQty, orderLineSubTotalPrice)
    VALUES 
    (null, :oLinePublicId, :oLineOrderPublicId, :oLineIndex, :oLineItemId, :oLineItemBatchQty, :oLineSubTotalPrice);";
    $query = $pdo->prepare($sql);
    $query->bindParam(':oLinePublicId', $linePublicId, PDO::PARAM_STR);
    $query->bindParam(':oLineOrderPublicId', $lineOrderPublicId, PDO::PARAM_STR);
    $query->bindParam(':oLineIndex', $lineIndex, PDO::PARAM_INT);
    $query->bindParam(':oLineItemId', $lineItemId, PDO::PARAM_INT);
    $query->bindParam(':oLineItemBatchQty', $lineItemBatchQty, PDO::PARAM_INT);
    $query->bindParam(':oLineSubTotalPrice', $lineSubTotalPrice, PDO::PARAM_STR);
    return $query->execute();
}
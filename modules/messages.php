<?php
function createMessage(PDO $pdo, string $sender, string $receiver, string $message) {
    $sql = "INSERT INTO messages (msgId, msgFromId, msgToId, msg, msgTimestamp) VALUES (NULL, :fromId, :toId, :msg, now());";
    $query = $pdo->prepare($sql);
    $query->bindParam(':fromId', $sender, PDO::PARAM_STR);
    $query->bindParam(':toId', $receiver, PDO::PARAM_STR);
    $query->bindParam(':msg', $message, PDO::PARAM_STR);
    return $query->execute();
}

function readMessages(PDO $pdo, string $sender, string $receiver) {
    $sql = "SELECT * FROM messages 
    WHERE msgFromId = :sender AND msgToId = :receiver 
    OR msgFromId = :receiver AND msgToId = :sender";
    $query = $pdo->prepare($sql);
    $query->bindParam(':sender', $sender, PDO::PARAM_STR);
    $query->bindParam(':receiver', $receiver, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
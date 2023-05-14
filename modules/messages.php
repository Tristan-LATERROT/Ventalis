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

function createMessageContact(PDO $pdo, string $companyName, string $firstName, string $lastName, string $msgObject, string $message, string $email) {
    $status = 'RECEIVED';
    $sql = "INSERT INTO messages_contact (msgContactId, msgContactFirstName, msgContactLastName, msgContactCompanyName, msgContactEmail, msgContactObject, msgContactMessage, msgContactStatus, msgContactTimestamp) 
    VALUES (NULL, :msgContactFirstName, :msgContactLastName, :msgContactCompanyName, :msgContactEmail, :msgContactObject, :msgContactMessage, :msgContactStatus, now());";
    $query = $pdo->prepare($sql);
    $query->bindParam(':msgContactFirstName', $firstName, PDO::PARAM_STR);
    $query->bindParam(':msgContactLastName', $lastName, PDO::PARAM_STR);
    $query->bindParam(':msgContactCompanyName', $companyName, PDO::PARAM_STR);
    $query->bindParam(':msgContactEmail', $email, PDO::PARAM_STR);
    $query->bindParam(':msgContactObject', $msgObject, PDO::PARAM_STR);
    $query->bindParam(':msgContactMessage', $message, PDO::PARAM_STR);
    $query->bindParam(':msgContactStatus', $status, PDO::PARAM_STR);
    return $query->execute();
}

function sendEmailMessagecontact(PDO $pdo, string $email, string $msgObject, string $msg) {
    // contenu du mail
    $subject = 'Demande de contact';
    $message = "Objet du message : $msgObject - Votre message : $msg";
    $headers = 'Content-Type: text/plain; charset="UTF-8"';

    if (mail($_POST['email'], $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
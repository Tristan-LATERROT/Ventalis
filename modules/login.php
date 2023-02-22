<?php

function verifyUserToLog(PDO $pdo, string $email, string $password) {
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

if($user && password_verify($_POST['pwd'], $user['password'])) {
    return $user;
} else {
    return false;
}
}
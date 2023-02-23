<?php

function updateNewPwd(PDO $pdo, string $newPass, string $email) {
    $newPass = $_POST['pwdNew'];
    $email = $_SESSION['user'];
    $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
    // flag pour signifier la modification de mdp dans la table
    $flag = null;

        $query = $pdo->prepare("UPDATE users SET password = :hashedPwd, resetPwd = :flag WHERE email = :email");
        $query->bindValue(':hashedPwd', $hashedPassword , PDO::PARAM_STR);
        $query->bindValue(':flag', $flag , PDO::PARAM_NULL);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        return true;

}

function verifyUserForUpdate(PDO $pdo, string $email, string $password) {
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

if($user && password_verify($_POST['pwdOld'], $user['password'])) {
    return $user;
} else {
    return false;
}
}
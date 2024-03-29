<?php

function resetForgotPwd(PDO $pdo, string $email) {
    $password = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // flag pour demander une modification de mdp à la prochaine connexion
    $flag = 'Y';
    // contenu du mail
    $subject = 'Mot de passe oublié';
    $message = "Bonjour, voici votre nouveau mot de passe, il vous sera demandé de le modifier à votre prochaine connexion : $password";
    $headers = 'Content-Type: text/plain; charset="UTF-8"';

    if (mail($_POST['email'], $subject, $message, $headers)) {
        $query = $pdo->prepare("UPDATE users SET password = :hashedPwd, resetPwd = :flag WHERE email = :email");
        $query->bindValue(':hashedPwd', $hashedPassword , PDO::PARAM_STR);
        $query->bindValue(':flag', $flag , PDO::PARAM_STR);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->execute();
        return true;
    } else {
        return false;
    }
}

function resetPwdRequiredByEmail(PDO $pdo, string $email) {
    // flag pour demander une modification de mdp à la prochaine connexion
    $flag = 'Y';
    // update du champ resetPwd
    $query = $pdo->prepare("UPDATE users SET resetPwd = :flag WHERE email = :email");
        $query->bindValue(':flag', $flag , PDO::PARAM_STR);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->execute();
    if($query) {
        return true;
    } else {
        return false;
    }
}

function resetPwdRequiredById(PDO $pdo, string $id) {
    // flag pour demander une modification de mdp à la prochaine connexion
    $flag = 'Y';
    // update du champ resetPwd
    $query = $pdo->prepare("UPDATE users SET resetPwd = :flag WHERE id = :id");
        $query->bindValue(':flag', $flag , PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
    if($query) {
        return true;
    } else {
        return false;
    }
}
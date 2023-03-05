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

function getUserRoles(PDO $pdo, string $id) {
    $userRoles = [];
    $rolesQuery = $pdo->prepare("SELECT roleName FROM users_roles INNER JOIN roles ON roles.id = users_roles.roleId WHERE userId = :id");
    $rolesQuery->bindParam(':id', $id, PDO::PARAM_STR);
    if($rolesQuery->execute()){
        while($role = $rolesQuery->fetch(PDO::FETCH_ASSOC)) {
            $userRoles = $role;
        }
        var_dump($userRoles);

    }

    if($userRoles) {
        return $userRoles;
    } else {
        return false;
    }
}
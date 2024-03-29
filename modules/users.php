<?php
// CRUD users

function getUsers(PDO $pdo) {
    $sql = 'SELECT * FROM users';
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetchall(PDO::FETCH_ASSOC);
}

function getUserById(PDO $pdo, string $id) {
    $sql = 'SELECT * FROM users WHERE id = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch();
}

function getUserByEmail(PDO $pdo, string $email) {
    $sql = 'SELECT * FROM users WHERE email = :email;';
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch();
}

function getIdByEmail(PDO $pdo, string $email) {
    $sql = 'SELECT id FROM users WHERE email = :email';
    $query = $pdo->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $userId = $query->fetch(PDO::FETCH_ASSOC);
    return $userId;
}

function getSalesAdvisorId(PDO $pdo, string $email) {
    $sql = 'SELECT salesAdvisor FROM users WHERE email = :email';
    $query = $pdo->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $salesId = $query->fetch(PDO::FETCH_ASSOC);
    return $salesId;
}

function createRole(PDO $pdo, string $id, int $roleId) {
    $sql = 'INSERT INTO users_roles (userRoleId, userId, roleId) VALUES (NULL, :id, :roleId)';
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':roleId', $roleId, PDO::PARAM_INT);
    return $query->execute();
}

function initSalesAdvisor(PDO $pdo, string $id) {
    $sql = 'UPDATE users 
            SET salesAdvisor = :id 
            WHERE id = :id';
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    return $query->execute();
}
?>


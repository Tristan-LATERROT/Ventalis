<?php

function createUser(PDO $pdo, string $email, string $password, string $firstName, string $lastName, string $companyName, string $salesAdvisor) {
        $sql = "INSERT INTO users (id, email, password, firstName, lastName, companyName, salesAdvisor) VALUES (:id, :email, :password, :firstName, :lastName, :companyName, :salesAdvisor)";
        $query = $pdo->prepare($sql);
        // generation de l'id
        $id = uniqid();
        // hash du pwd
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':companyName', $companyName, PDO::PARAM_STR);
        $query->bindParam(':salesAdvisor', $salesAdvisor, PDO::PARAM_STR);
        
        return $query->execute();
}

function checkPwd(string $password) {
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specials  = preg_match('@[^a-zA-Z_0-9]@', $password);
    
    if(!$uppercase || !$lowercase || !$number || !$specials || strlen($password) <= 8) {
      return false;
    } else {
        return true;
    }
}

function getSalesAdvisor(PDO $pdo) {
  $sql = "SELECT salesAdvisor, COUNT(salesAdvisor) FROM users 
          WHERE salesAdvisor IS NOT null AND salesAdvisor != ''
          GROUP BY salesAdvisor ORDER BY COUNT(salesAdvisor) ASC";
  $query = $pdo->prepare($sql);
  $query->execute();
  $advisorId = $query->fetch();

  return $advisorId;
}
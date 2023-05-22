<?php
function generateToken(array $header, array $payload, int $validity = TOKEN_DEFAULT_VALIDITY) {
    
    if($validity > 0) {
        $now = new DateTime();
        $expiration = $now->getTimestamp() + $validity;
        $payload['iat'] = $now->getTimestamp();
        $payload['exp'] = $expiration;
    }

    // On encode en base 64
    $base64Header = base64_encode(json_encode($header));
    $base64Payload = base64_encode(json_encode($payload)); 
    $secretKey = base64_encode(TOKEN_SECRET_KEY);

    // On vient corriger les données en base64 pour URL
    $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
    $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);
    $secretKey = str_replace(['+', '/', '='], ['-', '_', ''], $secretKey);

    // on génère la signature
    $signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, $secretKey, true);
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // on créé le token
    $token = $base64Header.'.'.$base64Payload.'.'.$signature;
    
    return $token;
}

function createToken(PDO $pdo, string $token, string $userId, string $userRole) {
    // ecriture du token en base
    try {
        //on lance la transaction
        $pdo->beginTransaction();

        //les requêtes :
        // requête de supression
        $query = $pdo->prepare('DELETE FROM users_tokens WHERE tokenUserId = :userId;');
        $query->bindValue(':userId', $userId, PDO::PARAM_STR);
        $query->execute();
        // requête d'insertion
        $sql = 'INSERT INTO users_tokens (tokenId, tokenUserId, tokenUserRole, tokenValue, tokenTimestamp) 
        VALUES (null, :userId, :userRole, :token, now());';
        $query = $pdo->prepare($sql);
        $query->bindValue(':userId', $userId, PDO::PARAM_STR);
        $query->bindValue(':userRole', $userRole, PDO::PARAM_STR);
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();

        //si tout est ok on valide la transaction
        $pdo->commit();

        return true;

    } catch(Exception $e) {
        //si ko on annule la transation
        $pdo->rollback();
        //on affiche un message d'erreur
        echo 'Erreur : '.$e->getMessage().'<br />';
    }
}


function checkToken(string $token) {
    // on récupère les data
    $header = getHeader($token);
    $payload = getPayload($token);

    // On génère un nouveau token avec ces infos pour vérifier le token
    $verifyToken = generateToken($header, $payload, 0);

    return $token === $verifyToken;

}

function getHeader(string $token) {
    // démontage du token
    $array = explode('.', $token);
    // on décode le header
    $header = json_decode(base64_decode($array[0]), true);
    return $header;
}

function getPayload(string $token) {
    // démontage du token
    $array = explode('.', $token);
    // on décode le header
    $payload = json_decode(base64_decode($array[1]), true);
    return $payload;
}

function expireToken(string $token) {
    $payload = getPayload($token);
    $now = new DateTime();
    return $payload['exp'] < $now->getTimestamp();
}

function validStringToken(string $token) {
    return preg_match(
        //
        '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
        $token
    ) === 1;
}
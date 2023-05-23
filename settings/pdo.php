<?php
$dbname = 'db_ventalis';
$host ='localhost';
$username ='monuser';
$pwd ='pass';

try {
    $pdo = new PDO('mysqldbname='.$dbname.';host='.$host, $username, $pwd);
}
catch(Exception $e) {
    exit('Erreur  ' . $e-getMessage());
}
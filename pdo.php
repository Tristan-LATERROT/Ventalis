<?php
$dbname = 'db_ventalis';
$host ='localhost';
$username ='monuser';
$pwd ='pass';

try {
    $pdo = new PDO('mysql:dbname='.$dbname.';host='.$host, $username, $pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(Exception $e) {
    exit('Erreur : ' . $e->getMessage());
}
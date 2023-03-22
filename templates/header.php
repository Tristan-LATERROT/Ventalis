<?php
require_once('settings/session.php');
// gestions obligation update password :
$testResetPwd = 'Y';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8" />
    <meta name="ventalis marketing ecofriendly" content="Le partenaire de votre communication" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png"/>

    <!-- CDN Bootstrap -->
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    
    <!-- Site CSS -->
    <link rel="stylesheet" href="assets/css/site.css">
</head>

<body>

<!-- Navbar -->
<?php
// var_dump($_SESSION);
if(isset($_SESSION["user"])) {
    require_once 'navbarUser.php';
} else {
    require_once 'navbar.php';
}
?>
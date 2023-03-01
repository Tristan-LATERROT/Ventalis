<?php
// Rerouter un visiteur non connecté
if (!isset($_SESSION["user"])) {
    // redirection du visiteur
    header("location: connexion.php");
    exit;
}
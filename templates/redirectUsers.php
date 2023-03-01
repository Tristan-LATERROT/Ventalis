<?php
// Rerouter un utilisateur connecté
if (isset($_SESSION["user"])) {
    // Rerouter un utilisateur qui doit modifier son mdp
    if ($_SESSION['updatePwdRequired'] == $testResetPwd) {
        echo 'merci de changer votre mot de passe';
        // redirection du user
        header('location: mdpModification.php');
        exit;
    }
}

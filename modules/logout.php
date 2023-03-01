<?php
// supprimer la session
session_destroy();
unset($_SESSION);
// rerouter sur page de connexion
header("Location: connexion.php");
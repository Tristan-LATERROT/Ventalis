<?php
// supprimer la session
session_destroy();
unset($_SESSION);
// rerouter sur page d'accueil
header("Location: index.php");
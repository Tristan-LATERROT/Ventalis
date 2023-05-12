<?php
if(isset($_SESSION["user"])) {
    if (in_array('R_USER', $_SESSION['roles'])) { 
    ?>
    <a class="btn btn-outline-dark mt-auto" href="panier.php"><i class="bi bi-cart3"></i> Ajouter</a>
    <?php 
    }
}
?>
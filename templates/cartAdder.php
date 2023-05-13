<?php
if(isset($_SESSION["user"])) {
    if (in_array('R_USER', $_SESSION['roles'])) { 
    ?>
    <a class="btn btn-outline-dark mt-auto" href="panierAjouter.php?productId=<?= $row['itemId'] ?>"><i class="bi bi-cart3"></i> Ajouter</a>
    <?php 
    }
}
?>
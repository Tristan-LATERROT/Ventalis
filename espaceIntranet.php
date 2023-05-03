<?php
// page intranet /!\
$title = 'INTRANET';
$page = 'espaceIntranet';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Espace Intranet</h2>
        <a href="categorieCreer.php" class="nav-item btn btn-outline-success me-md-2">Créer une catégorie produit</a>
        <a href="categoriesAdmin.php" class="nav-item btn btn-outline-danger me-md-2">Gérer les catégories produit</a>
        <a href="produitCreer.php" class="nav-item btn btn-outline-success me-md-2">Créer un produit</a>
        <a href="produitsAdmin.php" class="nav-item btn btn-outline-danger me-md-2">Gérer les produits</a>
        <a href="customersAdmin.php" class="nav-item btn btn-outline-success me-md-2">Voir mes clients</a>
        <a class="btn btn-success" href="messagesListe.php">Messagerie</a>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
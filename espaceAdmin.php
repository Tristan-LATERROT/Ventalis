<?php
$title = 'ESPACE-ADMIN';
$page = 'espaceAdmin';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Espace Administrateur</h2>
        <a href="" class="nav-item btn btn-outline-success me-md-2">Créer un utilisteur</a>
        <a href="" class="nav-item btn btn-outline-danger me-md-2">Gérer les utilisteurs</a>
        <a href="" class="nav-item btn btn-outline-danger me-md-2">Faire modifier son mot de passe à un utilisateur</a>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
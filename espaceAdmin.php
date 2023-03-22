<?php
// page admin /!\
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
        <a href="userCreer.php" class="nav-item btn btn-outline-success me-md-2">Créer un utilisteur employé</a>
        <a href="usersAdmin.php?list=<?= $list='staff'?>" class="nav-item btn btn-outline-danger me-md-2">Gérer les utilisateurs employés</a>
        <a href="usersAdmin.php?list=<?= $list='all'?>" class="nav-item btn btn-outline-danger me-md-2">Gérer tous les utilisteurs</a>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
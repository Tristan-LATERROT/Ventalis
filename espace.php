<?php
$title = 'MON-ESPACE';
$page = 'espace';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Mon espace</h2>
        <a href="mdpModification.php" class="nav-item btn btn-outline-danger me-md-2">Modifier mon mot de passe</a>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
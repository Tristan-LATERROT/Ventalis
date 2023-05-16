<?php
$title = 'MON-ESPACE';
$page = 'espace';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
require_once('modules/users.php');
require_once('settings/pdo.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

if(isset($_SESSION['user'])) {
    // récupérer le conseiller de vente
    $userEmail = $_SESSION['user'];
    $salesId = getSalesAdvisorId($pdo, $userEmail);
    $salesAdvisor = getUserById($pdo, $salesId['salesAdvisor']);
} else {
    // ne devrais pas arriver avec le redirect
    $errors[] = 'Vous ne pouvez pas accéder à votre espace sans vous connecter';
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Mon espace</h2>

        <?php foreach ($errors as $error) { ?>
            <div class="alert alert-danger">
                <?=$error; ?>
            </div>
        <?php } ?>

        <?php foreach ($messages as $message) { ?>
            <div class="alert alert-success">
                <?=$message; ?>
            </div>
        <?php } ?>

        <a href="mdpModification.php" class="nav-item btn btn-outline-danger me-md-2">
            <i class="bi bi-key-fill"></i> Modifier mon mot de passe
        </a>

        <?php
		if (in_array('R_USER', $_SESSION['roles'])) {
			// si l'utilisateur possède ce rôle on affiche les fonctionnalités :
		?>
            <a href="commandesVoir.php" class="nav-item btn btn-outline-success me-md-2">
                <i class="bi bi-box-fill"></i> Voir mes commandes
            </a>
            <a href="messagesConseiller.php?id=<?= $salesId['salesAdvisor'] ?>" class="nav-item btn btn-outline-success me-md-2">
            <i class="bi bi-chat-left-dots-fill"></i> Contacter mon conseiller de vente
            </a>

            <div class="d-flex flex-row m-5">
                <div>
                    <img src="assets/img/avatar-man-cartoon.jpg" class="rounded-circle mr-1" alt="sales-advisor" width="40" height="40">
                </div>
                <div>
                    <p>Votre conseiller VENTALIS <?= $salesAdvisor['firstName'].' '.$salesAdvisor['lastName'] ?> est à votre service</p>
                    <p>N'hésitez pas à le contacter pour toute demande d'information</p>
                </div>
            </div>
        <?php
        }
        ?>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
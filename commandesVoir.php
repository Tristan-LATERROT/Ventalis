<?php
$title = 'MES-COMMANDES';
$page = 'commandesVoir';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
require_once('modules/users.php');
require_once('modules/orders.php');
require_once('settings/pdo.php');
require_once('settings/config.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

// récupérer le conseiller de vente
// $userEmail = $_SESSION['user'];
// $salesId = getSalesAdvisorId($pdo, $userEmail);
// $salesAdvisor = getUserById($pdo, $salesId['salesAdvisor']);

if(isset($_SESSION['user'])) {
    $customerEmail = $_SESSION['user'];
    $customerId = getUserByEmail($pdo, $customerEmail);
    $orders = getOrdersByCustomerId($pdo, $customerId['id']);
} else {
    // ne devrais pas arriver avec le redirect
    $errors[] = 'Vous ne pouvez pas accéder à vos commandes sans vous connecter';
}


?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Mes commandes</h2>
</div>

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

<!-- Affichage du panier -->
<table class="table">
    <thead>
        <th>Commande</th>
        <th>Prix total HT</th>
        <th>Date de la commande</th>
        <th>Status</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php
        if ($orders) {
            //liste les commandes
            foreach($orders as $row) {
            ?>
            <tr>
                <td><?= $row['orderPublicId'] ?></td>
                <td><?= $row['orderTotalPrice'] ?> €</td>
                <td><?= $row['orderTimestamp'] ?></td>
                <td><?= $row['orderStatusCode'] ?></td>
                <td>
                    <a class="btn btn-outline-dark mt-auto" href="commandesVoirDetails.php?orderId=<?= $row['orderPublicId'] ?>">
                        <i class="bi bi-eye"></i> Voir details
                    </a>
                </td>
            </tr>
            <?php
            }
        } else {
            // si pas de commande pour ce client
            $errors[] = 'Vous n\'avez aucune commande';
        }
        ?>
    </tbody>
</table>

<a href="espace.php" class="nav-item btn btn-outline-success me-md-2">
    <i class="bi bi-person-workspace"></i> Retour vers mon espace
</a>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
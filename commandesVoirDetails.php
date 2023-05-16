<?php
$title = 'MES-COMMANDES';
$page = 'commandesVoir';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
require_once('modules/users.php');
require_once('modules/orders.php');
require_once('modules/product.php');
require_once('settings/pdo.php');
require_once('settings/config.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

// Initialiser la variable total à 0
$total = 0 ;

if(isset($_SESSION['user'])) {
    // si session user on lance le GET
    // contrôle la variable GET si id existe et n'est pas vide dans l'URL
    if(isset($_GET['orderId']) && !empty($_GET['orderId'])) {
        // on vient nettoyer la valeur de id
        $orderId = strip_tags($_GET['orderId']);
        // Si ok on affiche tous les lignes de la commande
        $orderLines = getOrderLinesByOrderId($pdo, $orderId);

        // on vérifie si une commande existe avec cet id
        if(!$orderLines) {
            $errors[] = 'cette id de commande n\'existe pas';
        }
    } else {
        // on vérifie si l'URL est valide'
        $errors[] = 'URL invalide';
    }

} else {
    // ne devrais pas arriver avec le redirect
    $errors[] = 'Vous ne pouvez pas accéder à vos commandes sans vous connecter';
}


?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Commande <?= $orderId ?></h2>
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
        <th>Ligne de commande</th>
        <th>n° de ligne</th>
        <th>Produit</th>
        <th>Quantité de lot(s)</th>
        <th>Nombre total produits</th>
        <th>Sous total de la ligne</th>
    </thead>
    <tbody>
        <?php
        if ($orderLines) {
            //liste les commandes
            foreach($orderLines as $row) {
            // on calcul le total des lignes de la commande
            $total = $total + $row['orderLineSubTotalPrice'];
            // On récupère le produit de la ligne pour afficher ses informations
            $productId = $row['orderLineItemId'];
            $product = getProductById($pdo, $productId);
            ?>
            <tr>
                <td><?= $row['orderLinePublicId'] ?></td>
                <td><?= $row['orderLineIndex'] ?></td>
                <td data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $product['itemDescription'] ?>">
                    <img class="mr-1" width="40" height="40" src="<?= getProductImage($product['itemMainPicture']); ?>" alt="..." />
                    <?= $product['itemLabel'] ?>
                </td>
                <td><?= $row['orderLineItemBatchQty'] ?></td>
                <td><?= $product['itemQty'] * $row['orderLineItemBatchQty'] ?></td>
                <td><?= $row['orderLineSubTotalPrice'] ?> €</td>
            </tr>
            <?php
            }
        }
        ?>
    </tbody>
    <tr class="total">
        <th>Total de la commande : <?=$total?> €</th>
    </tr>
</table>

<a href="commandesVoir.php" class="nav-item btn btn-outline-success me-md-2">
    <i class="bi bi-box-fill"></i> Retour vers mes commandes
</a>
<a href="espace.php" class="nav-item btn btn-outline-success me-md-2">
    <i class="bi bi-person-workspace"></i> Retour vers mon espace
</a>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
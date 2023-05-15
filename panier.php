<?php
$title = 'MON-PANIER';
$page = 'panier';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
require_once('modules/product.php');
require_once('settings/pdo.php');
require_once('settings/config.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

// si la variable delete existe
if(isset($_GET['remove'])){
// supprimer les produits de la ligne
$productRemove = $_GET['remove'] ;
unset($_SESSION['panier'][$productRemove]);
}

//si pas de session panier on va creer la session
if(!isset($_SESSION['panier'])){
    //création du panier
    $_SESSION['panier'] = array();
}

// Initialiser la variable total à 0
$total = 0 ;
// récupérer les clés du tableau session pour lister les produits
$ids = array_keys($_SESSION['panier']);
if(!empty($ids)){
    //s'il y a des clés 
	$products = getProductsByIdRange($pdo, $ids);
} else {
    //s'il n'y a aucune clé dans le tableau
    $errors[] = 'Votre panier est vide';
    $messages[] = 'Consultez notre catalogue pour ajouter des produits au panier';
    // ne pas lancer la boucle d'affichage des produits
    $products = false;
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Mon panier</h2>
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
	<th>produit</th>
    <th>Libellé du produit</th>
    <th>Catégorie</th>
    <th>Prix d'un lot HT</th>
    <th>Nombre de lots</th>
    <th>Nombre total produits</th>
    <th>Prix total HT</th>
    <th>Actions</th>
</thead>
<tbody>
    <?php
    if ($products) {
    //lise des produit avec une boucle foreach s'il y a des produits au panier
    	foreach($products as $row) {
		//calculer le total ( prix du lot * quantité) 
        //aditionner a chaque tour de boucle
        $total = $total + $row['itemBatchPrice'] * $_SESSION['panier'][$row['itemId']] ;
        ?>
        <tr>
			<td data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $row['itemDescription'] ?>">
				<img class="mr-1" width="40" height="40" src="<?= getProductImage($row['itemMainPicture']); ?>" alt="..." />
			</td>
            <td><?= $row['itemLabel'] ?></td>
            <td><?= $row['itemCategoryCode'] ?></td>
            <td><?= $row['itemBatchPrice'] ?> €</td>
            <td><?=$_SESSION['panier'][$row['itemId']] // Quantité?></td>
            <td><?= $row['itemQty'] * $_SESSION['panier'][$row['itemId']] ?></td>
            <td><?= $row['itemBatchPrice'] * $_SESSION['panier'][$row['itemId']] ?> €</td>
			<td>
                <a class="btn btn-success" href="panierAjouter.php?productId=<?= $row['itemId'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ajouter"><i class="bi bi-cart-plus-fill"></i></a>
				<a class="btn btn-warning" href="panierRetirer.php?productId=<?= $row['itemId'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Retirer"><i class="bi bi-cart-dash-fill"></i></a>
                <a class="btn btn-danger" href="panier.php?remove=<?=$row['itemId']?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer le produit du panier"><i class="bi bi-trash3-fill"></i></a>
            </td>
        </tr>
        <?php
    	}
    }
    ?>
</tbody>
			<tr class="total">
                <th>Total : <?=$total?> €</th>
            </tr>
</table>

<a class="btn btn-success" href="catalogue.php">
<i class="bi bi-cart-plus-fill"></i> Continuer mes achats
</a>
<a class="btn btn-success" href="commande.php">
	<i class="bi bi-cart-check-fill"></i> Commander les produits
</a>


</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>

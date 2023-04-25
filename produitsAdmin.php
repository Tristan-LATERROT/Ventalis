<?php
// page intranet /!\
$title = 'GESTION-CATEGORIES';
$page = 'produitsAdmin';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// On vient lister les catégories en bdd
        $sql = 'SELECT * FROM items';
        $query = $pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchall(PDO::FETCH_ASSOC);

?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Liste des produits</h2>
</div>

<?php foreach ($messages as $message) { ?>
    <div class="alert alert-success">
        <?=$message; ?>
    </div>
<?php } ?>

<?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger">
        <?=$error; ?>
    </div>
<?php } ?>

<!-- Affichage des users -->
<table class="table">
<thead>
    <th>ID</th>
    <th>Code produit</th>
    <th>Libellé du produit</th>
    <th>Description produit</th>
    <th>Qté minimum de commande</th>
    <th>Catégorie</th>
    <th>Code TVA</th>
    <th>Image principale</th>
    <th>Actions</th>
</thead>
<tbody>
    <?php
    foreach($results as $row){
        ?>
        <tr>
            <td><?= $row['itemId'] ?></td>
            <td><?= $row['itemCode'] ?></td>
            <td><?= $row['itemLabel'] ?></td>
            <td><?= $row['itemDescription'] ?></td>
            <td><?= $row['itemMinQty'] ?></td>
            <td><?= $row['itemCategoryCode'] ?></td>
            <td><?= $row['itemVatCode'] ?></td>
            <td><?= $row['itemMainPicture'] ?></td>
            <td>
                <a class="btn btn-warning" href="produitEdition.php?id=<?= $row['itemId'] ?>">Modifier</a>
                <a class="btn btn-danger" href="produitSupprimer.php?id=<?= $row['itemId'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
<div class="p-2 container">
<a class="btn btn-outline-success" href="espaceIntranet.php">Retour à l'Intranet</a>
</div>
</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
<?php
// page intranet /!\
$title = 'GESTION-CATEGORIES';
$page = 'categoriesAdmin';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// On vient lister les catégories en bdd
        $sql = 'SELECT * FROM categories';
        $query = $pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchall(PDO::FETCH_ASSOC);

?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Liste des catégories produit</h2>
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
    <th>Code de la catégorie</th>
    <th>Nom de la catégorie</th>
    <th>Actions</th>
</thead>
<tbody>
    <?php
    foreach($results as $row){
        ?>
        <tr>
            <td><?= $row['categoryId'] ?></td>
            <td><?= $row['categoryCode'] ?></td>
            <td><?= $row['categoryName'] ?></td>
            <td>
                <a class="btn btn-warning" href="categorieEdition.php?id=<?= $row['categoryId'] ?>">Modifier</a>
                <a class="btn btn-danger" href="categorieSupprimer.php?id=<?= $row['categoryId'] ?>">Supprimer</a>
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
<?php
// page intranet /!\
$title = 'CREER-CATEGORIE-PRODUIT';
$page = 'categorieCreer';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

if (isset($_POST['createCategory'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['categoryCode'], $_POST['categoryName'])
    && !empty($_POST['categoryCode']) 
    && !empty($_POST['categoryName'])) 
    {
        //formulaire complet
        // On contrôle les données du formulaire
        $code =strip_tags($_POST['categoryCode']);
        $name =strip_tags($_POST['categoryName']);

        // création de la catégorie
        $sql='INSERT INTO categories (categoryCode, categoryName) VALUES
        (:code, :name);';

        $query = $pdo->prepare($sql);
        $query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute();

        // message de validation de l'action
        $messages[] = 'Catégorie produit ajoutée';

    } else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour créer la catégorie';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Créer une catégorie produit</h2>
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

<div class="container-sm">
    <form action="" method="POST">

        <div class="row">
                <div class="mb-3 col-auto">
                    <input name="categoryCode" type="text" class="form-control" placeholder="code catégorie" aria-label="category-code">
                </div>
                <div class="mb-3 col-auto">
                    <input name="categoryName" type="text" class="form-control" placeholder="nom de la catégorie" aria-label="category-code">
                </div>
        </div>

        <button type="submit" name="createCategory" class="btn btn-success">Créer la catégorie produit</button>

    </form>

    <div class="p-5 container">
        <a class="btn btn-outline-success" href="espaceIntranet.php">Retour à l'Intranet</a>
    </div>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
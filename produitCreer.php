<?php
// page intranet /!\
$title = 'CREER-CATEGORIE-PRODUIT';
$page = 'produitCreer';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

if (isset($_POST['createProduct'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['productCode']) && !empty($_POST['productCode'])
    && isset($_POST['productLabel']) && !empty($_POST['productLabel']) 
    && isset($_POST['productDescription']) && !empty($_POST['productDescription'])
    && isset($_POST['productMinQty']) && !empty($_POST['productMinQty'])
    && isset($_POST['productCategoryCode']) && !empty($_POST['productCategoryCode'])
    && isset($_POST['productVatCode']) && !empty($_POST['productVatCode'])
    && isset($_POST['productMainPicture']) && !empty($_POST['productMainPicture'])
    ) {
        //formulaire complet
        // On contrôle les données du formulaire
        $code =strip_tags($_POST['productCode']);
        $label =strip_tags($_POST['productLabel']);
        $description =strip_tags($_POST['productDescription']);
        $minQty =strip_tags($_POST['productMinQty']);
        $categoryCode =strip_tags($_POST['productCategoryCode']);
        $vatCode =strip_tags($_POST['productVatCode']);
        $mainPicture =strip_tags($_POST['productMainPicture']);

        // création de la catégorie
        $sql='INSERT INTO items 
            (itemCode, itemLabel, itemDescription, itemMinQty, itemCategoryCode, itemVatCode, itemMainPicture) 
            VALUES
            (:code, :label, :description, :minQty, :categoryCode, :vatCode, :mainPicture);';

        $query = $pdo->prepare($sql);
        $query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':label', $label, PDO::PARAM_STR);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':minQty', $minQty, PDO::PARAM_INT);
        $query->bindValue(':categoryCode', $categoryCode, PDO::PARAM_STR);
        $query->bindValue(':vatCode', $vatCode, PDO::PARAM_INT);
        $query->bindValue(':mainPicture', $mainPicture, PDO::PARAM_STR);
        $query->execute();

        // message de validation de l'action
        $messages[] = 'Produit ajouté';

        } else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour créer la catégorie';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Créer un produit</h2>
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
                    <input name="productCode" type="text" class="form-control" placeholder="code produit" aria-label="item-code">
                </div>
                <div class="mb-3 col-auto">
                    <input name="productLabel" type="text" class="form-control" placeholder="libellé du produit" aria-label="item-label">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <input name="productDescription" type="text" class="form-control" placeholder="description du produit" aria-label="item-description">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <input name="productMinQty" type="number" value="1000" class="form-control" placeholder="minimum de commande" aria-label="item-min-qty">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <input name="productCategoryCode" type="text" class="form-control" placeholder="code de la catégorie produit" aria-label="item-code">
                </div>
                <div class="mb-3 col-auto">
                    <input name="productVatCode" type="number" class="form-control" placeholder="code TVA du produit" aria-label="item-label">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <input name="productMainPicture" type="text" class="form-control" placeholder="image du produit" aria-label="item-min-qty">
                </div>
        </div>

        <button type="submit" name="createProduct" class="btn btn-success">Créer le produit</button>

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
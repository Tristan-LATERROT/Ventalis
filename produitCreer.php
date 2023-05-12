<?php
// page intranet /!\
$title = 'CREER-CATEGORIE-PRODUIT';
$page = 'produitCreer';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('settings/config.php');
require_once('modules/product.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];
$categories = getCategories($pdo);

if (isset($_POST['createProduct'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['productCode']) && !empty($_POST['productCode'])
    && isset($_POST['productLabel']) && !empty($_POST['productLabel']) 
    && isset($_POST['productDescription']) && !empty($_POST['productDescription'])
    && isset($_POST['productQty']) && !empty($_POST['productQty'])
    && isset($_POST['productCategoryCode']) && !empty($_POST['productCategoryCode'])
    && isset($_POST['productVatCode']) && !empty($_POST['productVatCode'])
    && isset($_POST['productBatchPrice']) && !empty($_POST['productBatchPrice'])
    && isset($_POST['productMainPicture'])
    ) {
        //formulaire complet
        // On contrôle les données du formulaire
        $code =strip_tags($_POST['productCode']);
        $label =strip_tags($_POST['productLabel']);
        $description =strip_tags($_POST['productDescription']);
        $qty =strip_tags($_POST['productQty']);
        $categoryCode =strip_tags($_POST['productCategoryCode']);
        $vatCode =strip_tags($_POST['productVatCode']);
        $mainPicture =strip_tags($_POST['productMainPicture']);
        $batchPrice =strip_tags($_POST['productBatchPrice']);
        // On contrôle le nom du fichier photo
        if(empty($_POST['productMainPicture'])) {
            // mainPicture par default
            $mainPicture = null;
        }

        $newProduct = createProduct($pdo, $code, $label, $description, $qty, $categoryCode, $vatCode, $mainPicture, $batchPrice);
        if($newProduct) {
            // message de validation de l'action
            $messages[] = 'Produit ajouté';
        }

        } else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour créer le produit';
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
                    <label for="code">Code produit :</label>
                    <input id="code" name="productCode" type="text" class="form-control" placeholder="code unique du produit" aria-label="item-code">
                </div>
                <div class="mb-3 col-auto">
                    <label for="label">Libellé produit :</label>
                    <input id="label" name="productLabel" type="text" class="form-control" placeholder="libellé du produit" aria-label="item-label">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="description">Description produit :</label>
                    <input id="description" name="productDescription" type="text" size="150" class="form-control" placeholder="description du produit" aria-label="item-description">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="qty">Minimum de commande :</label>
                    <input id="qty" name="productQty" type="number" value="<?= _BATCH_DEFAULT_QTY_ ?>" class="form-control" placeholder="minimum de commande" aria-label="item-min-qty">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="category">Code catégorie :</label>
                    <select id="category" name="productCategoryCode" class="form-control" placeholder="code de la catégorie produit" aria-label="item-code">
                        <option value="">--Choisir une catégorie produit--</option>
                        <?php foreach($categories as $row) { ?>
                            <option value="<?= $row['categoryCode'] ?>"><?= $row['categoryName'] ?></option>
                        <?php } ?>
                    </select>
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="vat">Code TVA :</label>
                    <input id="vat" name="productVatCode" type="number" class="form-control" placeholder="code TVA du produit" aria-label="item-label">
                </div>
                <div class="mb-3 col-auto">
                    <label for="price">Prix unitaire :</label>
                    <input id="price" name="productBatchPrice" type="text" class="form-control" placeholder="prix unitaire HT" aria-label="item-label">
                </div>
        </div>

        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="picture">Image principale :</label>
                    <input id="picture" name="productMainPicture" type="text" class="form-control" placeholder="image du produit" aria-label="item-min-qty">
                </div>
        </div>

        <button type="submit" name="createProduct" class="btn btn-success">
        <i class="bi bi-plus-square"></i> Créer le produit
        </button>

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
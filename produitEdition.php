<?php
// page intranet /!\

/* 
En cours de modif voir tous les champs à modifier
*/

// en cours de modif pour categories
$title = 'VOIR-UTILISATEUR';
$page = 'userDetails';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('settings/config.php');
require_once('modules/product.php');

// gestions erreurs :
$errors = [];
$messages = [];

// Contrôle de POST que les champs sont set et ne sont pas vides
if($_POST){
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
        // si OK
        // On contrôle les données du formulaire
        $id =strip_tags($_POST['productId']);
        $code =strip_tags($_POST['productCode']);
        $label =strip_tags($_POST['productLabel']);
        $description =strip_tags($_POST['productDescription']);
        $qty =strip_tags($_POST['productQty']);
        $categoryCode =strip_tags($_POST['productCategoryCode']);
        $vatCode =strip_tags($_POST['productVatCode']);
        $batchPrice =strip_tags($_POST['productBatchPrice']);
        $mainPicture =strip_tags($_POST['productMainPicture']);
        // On contrôle le nom du fichier photo
        if(empty($_POST['productMainPicture'])) {
            // mainPicture par default
            $mainPicture = null;
        }

        $updateProduct = updateProduct($pdo, $id, $code, $label, $description, $qty, $categoryCode, $vatCode, $mainPicture, $batchPrice);
        if($updateProduct) {
            // message de validation de l'action
            $messages[] = 'Produit modifié';
        }

    } else {
        // si KO
        $errors[] = "Le formulaire est incomplet";

    }
}

// contrôle la variable GET si id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer la valeur de id
    $getId = strip_tags($_GET['id']);
    // Si ok on affiche tous le user
        $sql = 'SELECT * FROM items WHERE itemId = :id;';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $getId, PDO::PARAM_STR);
        $query->execute();
        $product = $query->fetch();

    // on vérifie si le produit existe
    if(!$product) {
        $errors[] = 'cette id n\'existe pas';
    }
    

} else {
    // on vérifie si l'URL est valide'
    $errors[] = 'URL invalide';
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
    <h1>Modifier un produit</h1>
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

<!-- Affichage du user -->
        <div class="row">
            <section class="col-12">
            <h2>Produit :</h2>

            <form method="POST">
                <input type="hidden" name="productId" value="<?=$product['itemId']?>">
                
            <div class="row">
                <div class="mb-3 col-auto">
                    <label for="code">Code produit :</label>
                    <input id="code" name="productCode" type="text" class="form-control" value="<?=$product['itemCode']?>" aria-label="item-code">
                </div>
                <div class="mb-3 col-auto">
                    <label for="label">Libellé produit :</label>
                    <input id="label" name="productLabel" type="text" class="form-control" size="75" value="<?=$product['itemLabel']?>" aria-label="item-label">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-auto">
                    <label for="description">Description produit :</label>
                    <input id="description" name="productDescription" type="text" class="form-control" size="150" value="<?=$product['itemDescription']?>" aria-label="item-description">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-auto">
                <label for="qty">Quantité du lot :</label>
                    <input id="qty" name="productQty" type="number" class="form-control" value="<?=$product['itemQty']?>" aria-label="item-qty">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-auto">
                    <label for="category">Code catégorie :</label>
                    <input id="category" name="productCategoryCode" type="text" class="form-control" value="<?=$product['itemCategoryCode']?>" aria-label="item-code">
                </div>
                <div class="mb-3 col-auto">
                    <label for="price">Prix unitaire :</label>
                    <input id="price" name="productBatchPrice" type="text" class="form-control" value="<?=$product['itemBatchPrice']?>" aria-label="item-label">
                </div>
                <div class="mb-3 col-auto">
                    <label for="vat">Code TVA :</label>
                    <input id="vat" name="productVatCode" type="number" class="form-control" value="<?=$product['itemVatCode']?>" aria-label="item-label">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-auto">
                    <label for="picture">Image principale :</label>
                    <input id="picture" name="productMainPicture" type="text" class="form-control" size="75" value="<?=$product['itemMainPicture']?>" aria-label="item-min-qty">
                </div>
            </div>
                
                <button class="btn btn-warning">
                <i class="bi bi-pencil-fill"></i> Modifier le produit
                </button>
            </form>

            <div class="p-2 container">
                <a class="btn btn-outline-success" href="espaceIntranet.php">Retour à l'Intranet</a>
            </div>

            </section>
        </div>

</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
<?php
$title = 'VENTALIS-HOME';
$page = 'catalogue';
require_once('templates/header.php');
require_once('templates/redirectUsers.php');
require_once('settings/pdo.php');
require_once('settings/config.php');
// affichage de la navbar des catégories de produits
require_once('templates/navbarCategories.php');
require_once('modules/product.php');

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle la variable GET si la catégorie existe et n'est pas vide dans l'URL
if(isset($_GET['productId']) && !empty($_GET['productId'])) {
    // on vient nettoyer la valeur de category
    $productId = strip_tags($_GET['productId']);
    // Si ok on affiche tous le produits de cette catégorie
    $product = getProductById($pdo, $productId);
    if ($product) {
        $category = getCategory($pdo, $product['itemCategoryCode']);
        $products = getProductsSorted($pdo, _LIST_PRODUCTS_SORTED_LIMIT_, $product['itemCategoryCode']);
    }
    // on vérifie si le produit existe
    if(!$product) {
        $errors[] = 'ce produit n\'existe pas';
    }
    

} else {
    // KO
}
?>

<!-- Main -->
<main class="site-content">

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

    <!-- Product section-->
    <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <img class="card-img-top mb-5 mb-md-0" src="<?= getProductImage($product['itemMainPicture']); ?>" alt="..." />
                    </div>
                    <div class="col-md-6">
                        <div class="small mb-1"><?= $category['categoryName']?></div>
                        <h1 class="display-5 fw-bolder"><?= $product['itemLabel']?></h1>
                        <div class="fs-5 mb-5">
                            <span><?= $product['itemBatchPrice'].' €*' ?></span>
                            <p> <?= '*pour un lot de '.$product['itemQty'].' produits' ?></p>
                        </div>
                        <div class="small mb-1"><?= $product['itemCode']?></div>
                        <p class="lead"><?= $product['itemDescription']?></p>
                        <div class="d-flex">
                            <label for="inputQty">Nombre de lots à ajouter au panier : </label>
                            <input class="form-control text-center me-3" id="inputQty" type="number" value="1" />
                        </div>
                        <div class="d-flex">
                        <a class="btn btn-outline-dark mt-5" href="panierAjouter.php?productId=<?= $product['itemId'] ?>"><i class="bi bi-cart3"></i> Ajouter au panier</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

        <!-- Related category items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Autres produits de la même catégorie</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                    <?php
                    foreach($products as $row) {
                    ?>

                    <!-- Product start-->
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?= getProductImage($row['itemMainPicture']); ?>" alt="..." data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $row['itemDescription'] ?>"/>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $row['itemLabel'] ?></h5>
                                    <!-- Product pricing-->
                                    <h6><?= $row['itemBatchPrice'].' €*' ?></h6>
                                    <p> <?= '*pour un lot de '.$row['itemQty'].' produits' ?></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto" href="catalogueDetails.php?productId=<?= $row['itemId'] ?>"><i class="bi bi-eye"></i> Voir</a>
                                        <?php include('templates/cartAdder.php') ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product end -->

                    <?php
                    }
                    ?>

                </div>
            </div>
        </section>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
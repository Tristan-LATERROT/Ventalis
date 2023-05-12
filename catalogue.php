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

// Header catalogue :
$catalogueHeaderTitle = 'Les produits eco responsables pour votre communication';
$catalogueHeaderMsg = 'Le catalogue de nos produits';

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle la variable GET si la catégorie existe et n'est pas vide dans l'URL
if(isset($_GET['category']) && !empty($_GET['category'])) {
    // on vient nettoyer la valeur de category
    $getCategory = strip_tags($_GET['category']);
    // Si ok on affiche tous le produits de cette catégorie
    $products = getProductsSorted($pdo, _LIST_PRODUCTS_SORTED_LIMIT_, $getCategory);
    $category = getCategory($pdo, $getCategory);
    $catalogueHeaderMsg = $catalogueHeaderMsg.' '.$category['categoryName'];

    // on vérifie si la catégorie existe
    if(!$products) {
        $errors[] = 'cette catégorie n\'existe pas';
    }
    

} else {
    // on affiche tous les produits
    $products = getProducts($pdo, _LIST_PRODUCTS_LIMIT_);
}
?>

<!-- Main -->
<main class="site-content">

<!-- Categories navbar -->

<!-- Header page -->
<header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder"><?= $catalogueHeaderTitle ?></h1>
                    <p class="lead fw-normal text-white-50 mb-0"><?= $catalogueHeaderMsg ?></p>
                </div>
            </div>
</header>

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

<!-- Section-->
<section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
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
                                        <a class="btn btn-outline-dark mt-auto" href="#"><i class="bi bi-eye"></i> Voir</a>
                                        <a class="btn btn-outline-dark mt-auto" href="#"><i class="bi bi-cart3"></i> Ajouter</a>
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
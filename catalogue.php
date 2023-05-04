<?php
$title = 'VENTALIS-HOME';
$page = 'catalogue';
require_once('templates/header.php');
require_once('templates/redirectUsers.php');
?>

<!-- Main -->
<main class="site-content">

<!-- Header page -->
<header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Les produit eco responsables pour votre communication</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Le catalogue de nos produits</p>
                </div>
            </div>
</header>

<!-- Section-->
<section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <!-- Product start-->
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="uploads/products/mug-blanc.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <p>Un mug blanc en ceramic pour le bureau. Le grand classic !</p>
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Mug blanc</h5>
                                    <!-- Product pricing-->
                                    1,99 €
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

                    <!-- Product start-->
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="uploads/products/bloc-notes-carton-recycle.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Bloc notes carton</h5>
                                    <!-- Product pricing-->
                                    1,99 €
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

                    <!-- Product start-->
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="uploads/products/Carnet-notes-A5-noir.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">Carnet notes A5 noir</h5>
                                    <!-- Product pricing-->
                                    1,99 €
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

                </div>
            </div>
</section>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
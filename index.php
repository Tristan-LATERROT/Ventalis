<?php
$title = 'VENTALIS-HOME';
$page = 'index';
require_once('templates/header.php');
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
    <div class="row p-3 text-light" id="firstRowHomePage">
		<h2>Le design et le marketing eco responsable</h2>
				<div class="row">
					<div class="col-xl-3 col-lg-5 col-md-6">
						<img 
							src="assets/img/product-1.png" 
							alt="usbkey-logo"
							class="img-fluid d-block"
							height="400"
						>
					</div>
					<div class="col-xl-6 col-lg-5 col-md-6 text-align-center">
						<h2>Nos objets publicitaires :</h2>
						<p class="h3">Découvrez les objets personnalisables de Ventalis, <br>
						comme vecteur de votre communication</p>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-12 mx-auto">
					<a href="" class="nav-item btn btn-success me-md-2">commandez vos articles personnalisés</a>
					</div>
    			</div>
				
				<div class="row">
					<div class="col-xl-3 col-lg-5 col-md-6">
						<img 
							src="assets/img/product-2.png" 
							alt="usbkey-logo"
							class="img-fluid d-block"
							height="400"
						>
					</div>
					<div class="col-xl-6 col-lg-5 col-md-6 text-align-center">
						<h2>Notre entreprise et sa démarche écologique :</h2>
						<p class="h3">Découvrez l'entreprise <br>
						et ses actions et projets en faveur de l'écologie</p>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-12 mx-auto">
					<a href="" class="nav-item btn btn-success me-md-2">Découvrir l'entreprise et ses valeurs</a>
					</div>
    			</div> 
    </div>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
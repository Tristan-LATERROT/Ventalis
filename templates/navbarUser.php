	<!-- Navbar responsive -->
	<nav class="navbar sticky-top navbar-light bg-light navbar-expand-lg">
		<div class="container-fluid">
		<a href="index.php" class="navbar-brand">
			<img 
				src="assets/img/Ventalis-logo.PNG" 
				alt="Paradox-logo" 
				class="d-inline-block"
				width="60"
				height="60" 
			/>
			<span class="visuallyHiden">/-On vous accompagne-/</span>
		</a>

		<button 
			class="navbar-toggler" 
			type="button" 
			data-bs-toggle="collapse" 
			data-bs-target="#navbar" 
			aria-controls="navbar" 
			aria-expanded="false" 
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

				<!-- Navbar items -->
				<div class="collapse navbar-collapse" id="navbar">
					<ul class="navbar-nav ms-auto text-center">
						<li class="nav-item">
							<a 
							href="index.php" 
							class="nav-link <?php if($page =='index') {echo 'active" aria-current="page';} ?>">
							Accueil
							</a>
						</li>
						<li class="nav-item">
							<a 
							href="presentation.php" 
							class="nav-link <?php if($page =='presentation') {echo 'active" aria-current="page';} ?>">
							Présentation
							</a>
						</li>
						<li class="nav-item">
							<a 
							href="catalogue.php" 
							class="nav-link <?php if($page =='catalogue') {echo 'active" aria-current="page';} ?>">
							Catalogue
							</a>
						</li>
						<li class="nav-item">
							<a 
							href="contact.php" 
							class="nav-link <?php if($page =='contact') {echo 'active" aria-current="page';} ?>">
							Contact
							</a>
						</li>
					</ul>

					<div class="mx-auto">

					<img 
							class=""
							src="assets/img/user-icon.png" 
							alt="User-icon" 
							class="d-inline-block"
							width="30"
							height="30" 
						/>
					<span class="nav-item"><?=$_SESSION['user'];?></span>
					
					<?php
					if (in_array('R_ADMIN', $_SESSION['roles'])) {
						// si l'utilisateur possède ce rôle
					?>
					<a href="espaceAdmin.php" class="nav-item btn btn-outline-success me-md-2">Espace Admin</a>
					<?php
						}
					?>

					<?php
					if (in_array('R_SALES', $_SESSION['roles'])) {
						// si l'utilisateur possède ce rôle
					?>
					<a href="espaceIntranet.php" class="nav-item btn btn-outline-success me-md-2">Intranet</a>
					<?php
						}
					?>

					<?php
					if (in_array('R_USER', $_SESSION['roles'])) {
						// si l'utilisateur possède ce rôle
					?>
					<a class="btn btn-outline-dark mt-auto" href="panier.php">
						<i class="bi bi-cart3"></i> Panier
						<?php
						//si session panier on va afficher les produits dans le badge
						if(isset($_SESSION['panier'])){ // calcul du badge
						?>
    						<span class="badge bg-dark text-white ms-1 rounded-pill">
								<?=array_sum($_SESSION['panier'])?>
							</span>
						<?php
						} else { // badge à zero
						?>
							<span class="badge bg-dark text-white ms-1 rounded-pill">
								0
							</span>
						<?php
						}
						?>
					</a>
					<?php
						}
					?>
					
					<a href="espace.php" class="nav-item btn btn-outline-success me-md-2">Mon espace</a>
					<a href="deconnexion.php" class="nav-item btn btn-outline-danger me-md-2">Se déconnecter</a>
					</div>
				</div>

	</div>
	</nav>
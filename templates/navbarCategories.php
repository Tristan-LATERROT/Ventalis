	<?php
    // On récupère les catégories
    $sql = 'SELECT * FROM categories';
    $query = $pdo->prepare($sql);
    $query->execute();
    $categories = $query->fetchall(PDO::FETCH_ASSOC);
    ?>

    <!-- Navbar categories -->
	<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
		<div class="container-fluid">
		<!-- Navbar items -->
		<div class="" id="navbarCat">
			<ul class="navbar-nav ms-auto text-center">
                <?php
                foreach($categories as $row){
                ?>
				<li class="nav-item">
					<a 
					href="catalogue.php?category=<?= $row['categoryCode'] ?>" 
					class="nav-link">
					<?= $row['categoryName'] ?>
					</a>
				</li>
                <?php
                }
                ?>
				<li class="nav-item">
					<a 
					href="catalogue.php" 
					class="nav-link">
					Voir tous les produits
					</a>
				</li>
			</ul>
		</div>
		</div>
	</nav>
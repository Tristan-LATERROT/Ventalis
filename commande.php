<?php
$title = 'COMMANDE';
$page = 'commande';
require_once('templates/header.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');
require_once('modules/product.php');
require_once('modules/orders.php');
require_once('modules/users.php');
require_once('settings/pdo.php');
require_once('settings/config.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

// affichage des message de la commande prise en compte
$orderSuccess = false;

//si il existe une session panier et une session user
if(isset($_SESSION['panier']) && isset($_SESSION['user'])){

    // Initialiser la variable total à 0
    $totalPrice = 0;
    $ecoProject = 0;

    // on récupère l'id du client par son email
    $user = getUserByEmail($pdo, $_SESSION['user']);
    $customerId = $user['id'];

    // récupérer les clés du tableau session pour lister les produits
    $ids = array_keys($_SESSION['panier']);
    
    if(!empty($ids)){
        //s'il y a des clés produit dans le panier 
        $products = getProductsByIdRange($pdo, $ids);

        if ($products) {
            //lise des produit avec une boucle foreach s'il y a des produits au panier
                foreach($products as $row) {
                //calculer le total ( prix du lot * quantité) 
                //aditionner a chaque tour de boucle
                $totalPrice = $totalPrice + $row['itemBatchPrice'] * $_SESSION['panier'][$row['itemId']] ;
                }

                //calculer la partie allouée aux projets écologiques ( total * 20%)
                $ecoProject = $totalPrice * 0.20;

                // création de la commande
                // création id de la commande dans la fonction et return de cet id
                $order = createOrder($pdo, $customerId, $totalPrice);

                // fonction à créer
                // $orderLine = createOrderLine($pdo, $linePublicId, $lineOrderPublicId, $lineIndex, $lineItemId, $lineItemBatchQty, $lineSubTotalPrice);

                if($order) {
                    // init des variables :
                    $lineOrderPublicId = $order;
                    $lineIndex = 1;
                    $lineSubTotalPrice = 0;

                    foreach($products as $row) {
                        $linePublicId = $lineOrderPublicId.'-'.$lineIndex;  
                        $lineItemId = $row['itemId']; 
                        $lineItemBatchQty = $_SESSION['panier'][$row['itemId']];
                        //calculer le total de la ligne ( prix du lot * quantité) 
                        $lineSubTotalPrice = $lineSubTotalPrice + $row['itemBatchPrice'] * $_SESSION['panier'][$row['itemId']];
                        // création des lignes de commande pour chaque ligne du panier
                        $orderLine = createOrderLine($pdo, $linePublicId, $lineOrderPublicId, $lineIndex, $lineItemId, $lineItemBatchQty, $lineSubTotalPrice);
                        // On incrémente l'index à chaque tour de boucle
                        $lineIndex ++;
                        // on réinitialise la variable à zero pour le prochain tour de boucle
                        $lineSubTotalPrice = 0;
                    }

                    // on va afficher les messages de la commande
                    $messages[] = 'Votre commande '.$order.' d\'un total de '.$totalPrice.' € a été passée avec succès';
                    $orderSuccess = true;
                    // on vide le panier
                    unset($_SESSION['panier']);
                } else {
                    $errors[] = 'Une erreur s\'est produite lors de votre commande. Merci de refaire la commande à partir de votre panier';
                }

        } else {
            // il n'y a pas de produits trouvé
            $errors[] = 'Impossible de commander certains produits';
        }

    } else {
        //s'il n'y a aucune clé dans le tableau
        $errors[] = 'Impossible de passer une commande car votre panier est vide';
        // ne pas lancer la boucle d'affichage des produits
        $products = false;
    }

} else {
    $errors[] = 'Impossible de passer une commande car votre panier est vide';
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

<?php if($orderSuccess) { ?>
    <div class="container-fluid text-dark"> 
	    <p>Merci de faire vos achats avec VENTALIS !</p>
        <p>Bravo 20 % du montant de votre commande, soit <?= $ecoProject ?> € va servir à financer des projets écologiques.</p>   
	    <p>Votre conseiller de vente est à votre disposition.</p>
        <p>Vous pouvez consulter les détails de votre commande directement dans votre espace.</p>
    </div>
<?php } ?>

    <div class="container-fluid text-dark">
        <a class="btn btn-success" href="catalogue.php">
        <i class="bi bi-cart-plus-fill"></i> Continuer mes achats
        </a>
        <a class="btn btn-success" href="espace.php">
        <i class="bi bi-person-workspace"></i> Aller dans mon espace
        </a>
    </div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
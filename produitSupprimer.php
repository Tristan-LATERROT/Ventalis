<?php
// page intranet /!\
$title = 'SUPP-CATEGORIE';
$page = 'produitSupprimer';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle de la variable GET que id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM items WHERE itemId = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $product = $query->fetch();

    // on vérifie si la catégorie existe
    if(!$product) {
        $errors[] = 'cet ID n\'existe pas';
    }

    // on supprime le produit
    $sql = 'DELETE FROM items WHERE itemId = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $messages[] = 'Produit supprimé';
    

} else {
    // on vérifie si l'URL est valide'
    $errors[] = 'URL invalide';
}
?>

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

<a class="btn btn-success" href="espaceIntranet.php">Retour à l'Intranet</a>

<?php
require_once('templates/footer.php');
?>
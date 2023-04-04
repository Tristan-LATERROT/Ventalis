<?php
// page intranet /!\

// en cours de modif pour categories
$title = 'VOIR-UTILISATEUR';
$page = 'userDetails';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// Contrôle de POST que les champs sont set et ne sont pas vides
if($_POST){
    if(isset($_POST['catId']) && !empty($_POST['catId'])
    && isset($_POST['catCode']) && !empty($_POST['catCode'])
    && isset($_POST['catName']) && !empty($_POST['catName'])
    ) {
        // si OK
        // On contrôle les données du formulaire
        $id =strip_tags($_POST['catId']);
        $code =strip_tags($_POST['catCode']);
        $name =strip_tags($_POST['catName']);

        $sql='UPDATE categories 
        SET categoryCode=:code, categoryName=:name 
        WHERE categoryId=:id;';

        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->bindValue(':code', $code, PDO::PARAM_STR);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute();

        // message de validation de l'action
        $messages[] = 'catégorie produit modifiée';
    } else {
        // si KO
        $errors[] = "Le formulaire est incomplet";

    }
}

// contrôle la variable GET si list existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer la valeur de id
    $getId = strip_tags($_GET['id']);
    // Si ok on affiche tous le user
        $sql = 'SELECT * FROM categories WHERE categoryId = :id;';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $getId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch();

    // on vérifie si le produit existe
    if(!$result) {
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
    <h1>Modifier la catégorie</h1>
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
            <h2>Catégorie <?= $result['categoryName'] ?></h2>
            <form method="POST">
                <div class="form-group">
                    <label for="code">Code catégorie :</label>
                    <input class="form-control" type="text" id="code" name="catCode" value="<?=$result['categoryCode']?>">
                </div>
                <div class="form-group">
                    <label for="name">Nom de la catégorie :</label>
                    <input class="form-control" type="text" id="name" name="catName" value="<?=$result['categoryName']?>">
                </div>
                <input type="hidden" name="catId" value="<?=$result['categoryId']?>">
                <button class="btn btn-warning">
                    Modifier la catégorie
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
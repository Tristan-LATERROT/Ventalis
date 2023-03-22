<?php
// page admin /!\
$title = 'VOIR-UTILISATEUR';
$page = 'userDetails';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// Contrôle de POST que les champs sont set et ne sont pas vides
if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['email']) && !empty($_POST['email'])
    && isset($_POST['firstName']) && !empty($_POST['firstName'])
    && isset($_POST['lastName']) && !empty($_POST['lastName'])
    && isset($_POST['companyName']) && !empty($_POST['companyName'])
    && isset($_POST['salesAdvisor'])
    ) {
        // si OK
        // On contrôle les données du formulaire
        $id =strip_tags($_POST['id']);
        $email =strip_tags($_POST['email']);
        $firstName =strip_tags($_POST['firstName']);
        $lastName =strip_tags($_POST['lastName']);
        $companyName =strip_tags($_POST['companyName']);
        $salesAdvisor =strip_tags($_POST['salesAdvisor']);
        

        $sql='UPDATE users 
        SET email=:email, firstName=:firstName, lastName=:lastName, companyName=:companyName, salesAdvisor=:salesAdvisor 
        WHERE id=:id;';

        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindValue(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindValue(':companyName', $companyName, PDO::PARAM_STR);
        $query->bindValue(':salesAdvisor', $salesAdvisor, PDO::PARAM_STR);
        $query->execute();

        // message de validation de l'action
        $messages[] = 'utilisateur modifié';
    } else {
        // si KO
        $errors[] = "Le formulaire est incomplet";

    }
}

// contrôle la variable GET si list existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer la valeur de list
    $id = strip_tags($_GET['id']);
    // Si ok on affiche tous le user
        $sql = 'SELECT * FROM users WHERE id = :id;';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

    // on vérifie si le produit existe
    if(!$user) {
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
	<h2>Utilisateur <?= $user['firstName'].'-'.$user['lastName'] ?></h2>
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
            <h1>Modifier le produit</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input class="form-control" type="text" id="email" name="email" value="<?= $user['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="firstName">Prénom :</label>
                    <input class="form-control" type="text" id="firstName" name ="firstName" value="<?= $user['firstName']?>">
                </div>
                <div class="form-group">
                    <label for="lastName">Nom :</label>
                    <input class="form-control" type="text" id="lastName" name="lastName" value="<?= $user['lastName']?>">
                </div>
                <div class="form-group">
                    <label for="companyName">Société :</label>
                    <input class="form-control" type="text" id="companyName" name="companyName" value="<?= $user['companyName']?>">
                </div>
                <div class="form-group">
                    <label for="salesAdvisor">Conseiller de vente :</label>
                    <input class="form-control" type="text" id="salesAdvisor" name="salesAdvisor" value="<?= $user['salesAdvisor']?>">
                </div>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button class="btn btn-warning">
                    Modifier utilisateur
                </button>
            </form>
            <div class="p-2 container">
                <a class="btn btn-outline-success" href="espaceAdmin.php">Retour à l'espace admin</a>
            </div>
            </section>
        </div>

</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
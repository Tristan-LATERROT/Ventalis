<?php
// page admin /!\
$title = 'VOIR-UTILISATEUR';
$page = 'userDetails';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle la variable GET si list existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer la valeur de list
    $id = strip_tags($_GET['id']);
    // Si ok on affiche tous le user
        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

    // on vérifie si l'id existe
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
                <div class="container">
                        <p>ID : <?= $user['id'] ?></p>
                        <p>Email : <?= $user['email'] ?></p>
                        <p>Prénom : <?= $user['firstName'] ?></p>
                        <p>Nom : <?= $user['lastName'] ?></p>
                        <p>Société : <?= $user['companyName'] ?></p>
                        <p>Conseiller de vente : <?= $user['salesAdvisor'] ?></p>
                        <p>Reset password request : <?= $user['resetPwd'] ?></p>
                </div>
                <div class="container">
                <p>Actions : </p>
                        <a class="btn btn-warning" href="userEdition.php?id=<?= $user['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="delete.php?id=<?= $user['id'] ?>">Supprimer</a>
                        <a class="btn btn-outline-success" href="espaceAdmin.php">Retour à l'espace admin</a>
                </div>
            </section>
    </div>

</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
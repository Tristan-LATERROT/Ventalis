<?php
// page admin /!\
$title = 'RESET-MDP';
$page = 'userResetMdpRequest';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/resetPwd.php');

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle de la variable GET que id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // on vient nettoyer l'id envoyé
    $id = strip_tags($_GET['id']);
    $sql = 'SELECT * FROM users WHERE id = :id;';
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();

    // on vérifie si le user existe
    if(!$user) {
        $errors[] = 'cet ID n\'existe pas';
    }

    // on demande la mise à jour
    $resetRequired = resetPwdRequiredById($pdo, $id);
    $messages[] = 'Demande de mise à jour de mot de passe envoyée';
    

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

<a class="btn btn-outline-success" href="espaceAdmin.php">Retour à l'espace admin</a>

<?php
require_once('templates/footer.php');
?>
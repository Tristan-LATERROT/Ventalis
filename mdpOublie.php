<?php
$title = 'MDP-OUBLIE';
$page = 'mdpOublie';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/resetPwd.php');

// gestions erreurs :
$errors = [];
$messages = [];

if (isset($_POST['resetPass'])) {
    // on vient vérifier que le champ est set et complétés
    if(isset($_POST['email'])
    && !empty($_POST['email'])) 
    {
    $reset = resetForgotPwd($pdo, $_POST['email']);
    if($reset) {
        $messages[] = 'E-mail envoyé';
        // redirection du user
        // header('location: connexion.php');
    } else {
        $errors[] = 'Une erreur est survenue';
    }
    }  else {
        // formulaire incomplet
        $errors[] = 'merci de remplir le champ email pour réinitialiser le mot de passe';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Réinitialiser mon mot de passe oublié</h2>
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

<div class="container-sm">
<form action="" method="POST">
    <div class="row">
        <div class="mb-3 col-auto">
            <label for="email" class="form-label">Votre Email</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">
            Celui que vous avez utilisé pour créer votre compte. <br>
            En cliquant sur réinitialiser mon mot de passe un nouveau vous sera envoyé par email, <br>
            si vous avez un compte associé à cette adresse.
            </div>
        </div>
        <div class="mx-auto">
            <button type="submit" name="resetPass" class="btn btn-warning">Réinitialiser mon mot de passe</button>
        </div>
    </div>

</form>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
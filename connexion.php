<?php
$title = 'LOGIN';
$page = 'connexion';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/login.php');

// gestions erreurs :
$errors = [];
$messages = [];

if (isset($_POST['logIn'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['email'], $_POST['pwd'])
    && !empty($_POST['email']) 
    && !empty($_POST['pwd'])) 
    {
    $user = verifyUserToLog($pdo, $_POST['email'], $_POST['pwd']);
    if($user) {
        $messages[] = 'Utilisateur '.$user['firstName'].' '.$user['lastName'].' connecté';
        $_SESSION['user'] = $user['email'];
        // redirection du user
        header('location: index.php');
    } else {
        $errors[] = 'email ou mot de passe invalide';
    }
    }  else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour vous connecter';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Se connecter à votre espace</h2>
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
        Celui que vous avez utilisé pour créer votre compte.
        </div>
    </div>
        
    <div class="mb-3 col-auto">
            <label for="password" class="form-label">Mot de passe</label>
            <input name="pwd" type="password" class="form-control" id="password">
    </div>
    </div>

            <div class="container mx-auto">
                <button type="submit" name="logIn" class="btn btn-success">Se connecter</button>
                <a class="btn btn-outline-success" href="inscription.php">Créer un compte</a>
                <a class="btn btn-outline-danger" href="mdpOublie.php">Mot de passe oublié</a>
            </div>


</form>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
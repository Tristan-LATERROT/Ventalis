<?php
$title = 'MDP-OUBLIE';
$page = 'mdpOublie';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/updatePwd.php');
require_once('modules/signup.php');

// gestions erreurs :
$errors = [];
$messages = [];

if (isset($_POST['updatePass'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['pwdOld'], $_POST['pwdNew'], $_POST['pwdNewConfirm'])
    && !empty($_POST['pwdOld'])
    && !empty($_POST['pwdNew'])
    && !empty($_POST['pwdNewConfirm'])) 
    {
        //A formulaire complet
        // contrôle que le nouveau mot de passe == la confirmation
        if($_POST['pwdNew'] === $_POST['pwdNewConfirm']) {
            //B contrôle OK mot de passe == la confirmation
            // contrôle de la structure du nouveau mot de passe
            $newPassword = $_POST['pwdNew'];
            $res = checkPwd($newPassword);
            if($res) {
                //C structure du nouveau mot de passe OK
                // contrôle du login avec email de la session connectée
                $user = verifyUserForUpdate($pdo, $_SESSION['user'], $_POST['pwdOld']);
                if($user) {
                    //D login OK
                    // mise à jour du mot de passe
                    $update = updateNewPwd($pdo, $_POST['pwdNew'], $user['email']);
                    if($update) {
                        //E mise à jour du mot de passe OK
                        $messages[] = 'Mot de passe modifié';
                        // redirection du user pour reconnexion
                        header('location: deconnexion.php');
                    } else {
                        //E echec mise à jour du mot de passe
                        $errors[] = 'Erreur de mise à jour';
                    }
                } else {
                    //D echec contrôle du login
                    $errors[] = 'mot de passe invalide';
                }
            } else {
                //C echec contrôle de la structure du nouveau mot de passe
                $errors[] = 'Votre mot de passe n\'est pas valide';
            }
        } else {
            //B echec du contrôle nouveau mot de passe == la confirmation 
            $errors[] = 'La confirmation du mot de passe ne correspond pas au nouveau mot de passe';
        }        
    }  else {
        //A formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour modifier le mot de passe';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Modifier mon mot de passe</h2>
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

            <label for="passOld" class="form-label">Ancien mot de passe</label>
            <input name="pwdOld" type="password" class="form-control" id="passOld" aria-label="passOld">

            <label for="passNew" class="form-label">Votre nouveau mot de passe</label>
            <input name="pwdNew" type="password" class="form-control" id="passNew" aria-label="passNew">

            <label for="passNewConfirm" class="form-label">Confirmation de votre nouveau mot de passe</label>
            <input name="pwdNewConfirm" type="password" class="form-control" id="passNewConfirm" aria-label="passNewConfirm">

        </div>
        <div class="mx-auto">
            <button type="submit" name="updatePass" class="btn btn-warning">Modifier mon mot de passe</button>
        </div>
    </div>

</form>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
<?php
$title = 'SIGNUP';
$page = 'inscription';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/signup.php');
require_once('modules/users.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

if (isset($_POST['createUser'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['email'], $_POST['pwd'], $_POST['firstName'], $_POST['lastName'], $_POST['companyName'])
    && !empty($_POST['email']) 
    && !empty($_POST['pwd']) 
    && !empty($_POST['firstName']) 
    && !empty($_POST['lastName'])
    && !empty($_POST['companyName'])) 
    {
        //formulaire complet
        // contrôle de la structure du mot de passe
        $password = $_POST['pwd'];
        $res = checkPwd($password);
        if($res) {
            // mot de passe ok
            // creation du compte
            $salesAdvisor = getSalesAdvisor($pdo);
            $qry = createUser($pdo, $_POST['email'], $_POST['pwd'], $_POST['firstName'], $_POST['lastName'], $_POST['companyName'], $salesAdvisor['salesAdvisor']);
            if($qry) {
                // on récupère l'id créé
                $userId = getIdByEmail($pdo, $_POST['email']);
                // ecriture du role
                $role = createRole($pdo, $userId['id'], 1);
                $messages[] = 'incription valide vous pouvez à présent vous connecter';
            } else {
                $errors[] = 'erreur d\'inscription merci de refaire votre inscription'; 
            }
        } else {
            // mot de passe ne respecte pas les contraintes
            $errors[] = 'erreur mot de passe invalide merci de refaire votre inscription'; 
        }
    } else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour votre inscription';
    }
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Créer un compte</h2>
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
                    <input name="firstName" type="text" class="form-control" placeholder="Votre prénom" aria-label="userFirstName">
                </div>
                <div class="mb-3 col-auto">
                    <input name="lastName" type="text" class="form-control" placeholder="Votre nom" aria-label="userLastName">
                </div>
                <div class="mb-3 col-auto">
                    <input name="companyName" type="text" class="form-control" placeholder="Votre entreprise" aria-label="userCompName">
                </div>
        </div>

        <div class="row">
            <div class="mb-3 col-auto">
                <label for="email" class="form-label">Votre Email</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">
                    Celui qui sera utilisé pour créer votre compte et vous connecter.
                </div>
            </div>

            <div class="mb-3 col-auto">
                <label for="Password" class="form-label">Choisir un mot de passe</label>
                <input name="pwd" type="password" class="form-control" id="Password" aria-describedby="passwordHelpBlock">
                <div id="passwordHelpBlock" class="form-text">
                votre mot de passe doit contenir au minimum : <br>
                8 caractères de long <br> 
                1 majuscule <br>
                1 minuscule <br>
                1 chiffre <br>
                1 caractère spécial
                </div>
            </div>
        </div>

        <button type="submit" name="createUser" class="btn btn-success">Créer votre compte</button>

    </form>
</div>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
<?php
$title = 'CONTACT';
$page = 'contact';
require_once('templates/header.php');
require_once('templates/redirectUsers.php');
require_once('settings/pdo.php');
require_once('modules/messages.php');
require_once('modules/users.php');

// gestions messages et erreurs :
$errors = [];
$messages = [];

if (isset($_POST['contactMessage'])) {
    // on vient vérifier que les champs sont set et complétés
    if(isset($_POST['companyName'], $_POST['firstName'], $_POST['lastName'], $_POST['msgObject'], $_POST['message'], $_POST['email'])
    && !empty($_POST['companyName'])
    && !empty($_POST['firstName']) 
    && !empty($_POST['lastName'])
    && !empty($_POST['msgObject'])
    && !empty($_POST['message'])
    && !empty($_POST['email'])) 
    {
        //formulaire complet
        // On contrôle les données du formulaire
        $companyName =strip_tags($_POST['companyName']);
        $firstName =strip_tags($_POST['firstName']);
        $lastName =strip_tags($_POST['lastName']);
        $msgObject =strip_tags($_POST['msgObject']);
        $msg =strip_tags($_POST['message']);
        $email =strip_tags($_POST['email']);

        // envoi du message par email
        $sendEmail = sendEmailMessagecontact($pdo, $email, $msgObject, $msg);
        if($sendEmail) {
            $messages[] = 'E-mail envoyé';
            $qry = createMessageContact($pdo, $companyName, $firstName, $lastName, $msgObject, $msg, $email);
            if($qry) {
                $messages[] = 'Message envoyé - merci de nous avoir contacté';
            } else {
                $errors[] = 'erreur d\'envoi du message merci de refaire votre message'; 
            }
        } else {
            // erreur envoi email
            $errors[] = 'Une erreur est survenue';
        }
    } else {
        // formulaire incomplet
        $errors[] = 'merci de remplir tous les champs pour envoyer votre message';
    }
}

if(isset($_SESSION['user'])){
    // on alimente le formulaire de contact
    $user = getUserByEmail($pdo, $_SESSION['user']);
}
?>


<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
		<h2>Contact</h2>
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
        <div></div>
        <div class="row">
                <div class="mb-3 col-auto">
                    <label for="companyName">Entreprise :</label>
                    <input id="companyName" name="companyName" type="text" class="form-control" placeholder="Votre entreprise" aria-label="userCompName" value="<?php if(isset($_SESSION['user'])) { echo $user['companyName'];} ?>">
                </div>
                <div class="mb-3 col-auto">
                <label for="firstName">Prénom :</label>
                    <input id="firstName" name="firstName" type="text" class="form-control" placeholder="Votre prénom" aria-label="userFirstName" value="<?php if(isset($_SESSION['user'])) { echo $user['firstName'];} ?>">
                </div>
                <div class="mb-3 col-auto">
                <label for="lastName">Nom :</label>
                    <input id="lastName" name="lastName" type="text" class="form-control" placeholder="Votre nom" aria-label="userLastName" value="<?php if(isset($_SESSION['user'])) { echo $user['lastName'];} ?>">
                </div>
        </div>

        <div class="row">
            <div class="mb-3 col-auto">
                <label for="msgObjet" class="form-label">Objet du message :</label>
                <input name="msgObject" type="text" class="form-control" size="80" id="email" aria-describedby="emailHelp">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-auto">
                <label for="message" class="form-label">Votre message :</label>
                <textarea name="message" class="form-control" rows="5" cols="80" id="message" aria-describedby="emailHelp"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-auto">
                <label for="email" class="form-label">Votre Email :</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?php if(isset($_SESSION['user'])) { echo $user['email'];} ?>">
                <div id="emailHelp" class="form-text">
                    Vous recevrez votre message et notre réponse sur cette adresse email.
                </div>
            </div>
        </div>

        <button type="submit" name="contactMessage" class="btn btn-success">Envoyer votre message</button>
    </form>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
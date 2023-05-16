<?php
// page intranet /!\
$title = 'GESTION-UTILISATEURS';
$page = 'usersAdmin';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/users.php');

// gestions erreurs :
$errors = [];
$messages = [];

// contrôle si la variable de SESSION est set et non vide
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    // on récupère l'id avec l'email de la SESSION
    $salesId = getIdByEmail($pdo, $_SESSION['user']);
        // On filtre les clients associés au conseiller sans le conseiller lui même
        $sql = 'SELECT * FROM users WHERE salesAdvisor = :salesId AND id != :salesId';
        $query = $pdo->prepare($sql);
        $query->bindParam(':salesId', $salesId['id'], PDO::PARAM_STR);
        $query->execute();
        $customers = $query->fetchall(PDO::FETCH_ASSOC);

        if(!$customers) {
            // Si pas de client associé on envoi le message d'erreur
            $errors[] = 'aucun client associé à votre compte';
        }
} else {
    // on vérifie si l'URL est valide'
    $errors[] = 'impossible de trouver votre session';
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Liste des clients</h2>
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

<!-- Affichage des users -->
<table class="table">
<thead>
    <th>ID</th>
    <th>Email</th>
    <th>Prénom</th>
    <th>Nom</th>
    <th>Société</th>
    <th>Conseiller de vente</th>
    <th>Actions</th>
</thead>
<tbody>
    <?php
    foreach($customers as $row){
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['firstName'] ?></td>
            <td><?= $row['lastName'] ?></td>
            <td><?= $row['companyName'] ?></td>
            <td><?= $row['salesAdvisor'] ?></td>
            
            
            <td>
                <a class="btn btn-success" href="customerDetails.php?id=<?= $row['id'] ?>">
                    Voir le client
                </a>
                <a class="btn btn-success" href="messagesListe.php?id=<?= $row['id'] ?>">
                    Voir messages
                </a>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
<div class="p-2 container">
<a class="btn btn-outline-success" href="espaceIntranet.php">Retour à l'Intranet</a>
</div>
</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
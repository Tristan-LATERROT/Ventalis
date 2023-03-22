<?php
// page admin /!\
$title = 'GESTION-UTILISATEURS';
$page = 'usersAdmin';
require_once('templates/header.php');
require_once('settings/pdo.php');

// gestions erreurs :
$errors = [];
$messages = [];
var_dump($_GET['list']);

// contrôle la variable GET si list existe et n'est pas vide dans l'URL
if(isset($_GET['list']) && !empty($_GET['list'])) {
    // on vient nettoyer la valeur de list
    $list = strip_tags($_GET['list']);
    // Si ok on affiche les users employés
    if($list == 'staff') {
        // recherche des users qui sont employés en bdd
        $roleCible = 'R_SALES';
        $type = '(uniquement les employés)';
        $sql = 
        'SELECT * FROM users 
        INNER JOIN users_roles ON users_roles.userId = users.id 
        INNER JOIN roles ON roles.roleId = users_roles.roleId 
        WHERE roles.roleName = :roleCible';
        $query = $pdo->prepare($sql);
        $query->bindParam(':roleCible', $roleCible, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchall(PDO::FETCH_ASSOC);
    }
    // Si ok on affiche tous les users
    if($list == 'all') {
        $type = '(tous les utilisateurs)';
        $sql = 'SELECT * FROM users';
        $query = $pdo->prepare($sql);
        $query->execute();
        $results = $query->fetchall(PDO::FETCH_ASSOC);
    }
    // on vérifie si le critère existe
    if(!$list) {
        $errors[] = 'cette liste n\'existe pas';
    }

} else {
    // on vérifie si l'URL est valide'
    $errors[] = 'URL invalide';
}
?>

<!-- Main -->
<main class="site-content">

<div class="container-fluid text-dark">
	<h2>Liste des utilisateurs <?= $type?></h2>
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
    <th>Reset password request</th>
    <th>Actions</th>
</thead>
<tbody>
    <?php
    foreach($results as $row){
        ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['firstName'] ?></td>
            <td><?= $row['lastName'] ?></td>
            <td><?= $row['companyName'] ?></td>
            <td><?= $row['salesAdvisor'] ?></td>
            <td><?= $row['resetPwd'] ?></td>
            
            <td>
                <a class="btn btn-success" href="userDetails.php?id=<?= $row['id'] ?>">Voir</a>
                <a class="btn btn-warning" href="userEdition.php?id=<?= $row['id'] ?>">Modifier</a>
                <a class="btn btn-danger" href="userSupprimer.php?id=<?= $row['id'] ?>">Supprimer</a>
                <a class="nav-item btn btn-outline-danger me-md-2" href="userResetMdpRequest.php?id=<?= $row['id'] ?>">Demander modification mot de passe</a>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>
<div class="p-2 container">
<a class="btn btn-outline-success" href="espaceAdmin.php">Retour à l'espace admin</a>
</div>
<div class="p-2 container">
<a class="btn btn-danger" href="mdpOublie.php">Réinitialiser un mot de passe utilisateur</a>
<p>pour réinitialiser un mot de passe utilisateur (copier son email)</p>
</div>
</main>
<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
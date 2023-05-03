<?php
// page intranet /!\
$title = 'MESSAGES';
$page = 'messages';
require_once('templates/header.php');
require_once('settings/pdo.php');
require_once('modules/users.php');
require_once('modules/messages.php');
require_once('templates/redirectVisitors.php');
require_once('templates/redirectUsers.php');

// gestions erreurs :
$errors = [];
$messages = [];

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
    $getUserId = getIdByEmail($pdo, $_SESSION['user']);
    if($getUserId){
        // On filtre les clients associés au conseiller
        $sql = 'SELECT * FROM users WHERE salesAdvisor = :salesId ';
        $query = $pdo->prepare($sql);
        $query->bindParam(':salesId', $getUserId['id'], PDO::PARAM_STR);
        $query->execute();
        $customers = $query->fetchall(PDO::FETCH_ASSOC);

        if(!$customers) {
            // Si pas de client associé on envoi le message d'erreur
            $errors[] = 'pas de contacts : aucun client associé à votre compte';
        }

    }else{
        $errors[] = 'impossible de trouver votre session';
    }
}

	if(isset($_GET['id']) AND !empty($_GET['id'])){
		$getId =strip_tags($_GET['id']);
		$sender = $getUserId['id'];
		$receiver = $getId;

		if(isset($_POST['envoyer']) && !empty($_POST['message'])){
			$message = htmlspecialchars($_POST['message']);
			$sendMsg = createMessage($pdo, $sender, $receiver, $message);
			if($sendMsg) {
                // C'est bon le message est envoyé
            } elseif (!$sendMsg) {
				$errors[] = 'selectionner un contact pour envoyer un message';
			} else {
                $errors[] = 'erreur d\'envoi du message'; 
            }
			}
	} elseif(empty($_GET['id']) && !empty($_SESSION['user'])) {
		// Il ne se passe rien
	} else {
		$errors[] = 'aucun identifiant valide pour cet utilisateur';
	}
?>

<!-- Main -->
<main class="site-content">

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

<!-- CHAT -->

<main class="content">
    <div class="container p-0">

		<h1 class="h3 mb-3">Messages</h1>

		<div class="card">
			<div class="row g-0">

				<!-- liste contacts -->
				<div class="col-12 col-lg-5 col-xl-3 border-right">
					<?php
					foreach($customers as $row){
					?>
					<a href="messagesListe.php?id=<?= $row['id'] ?>" class="list-group-item list-group-item-action border-0">
							<div class="d-flex align-items-start">
								<img src="assets/img/avatar-default.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
								<div class="flex-grow-1 ml-3">
									<?= $row['firstName'].' '.$row['lastName'] ?>
									<div class="small"><span class="fas fa-circle chat-online"></span><?= $row['companyName'] ?></div>
								</div>
							</div>
					</a>
					<?php
					}
					?>
					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>

				<!-- messages avec le contact selectionné -->
				<div class="col-12 col-lg-7 col-xl-9">

					<?php
					if(isset($_GET['id']) AND !empty($_GET['id'])){
						foreach($customers as $row){
							if($row['id'] == $receiver) {
								?>
								<div class="py-2 px-4 border-bottom d-none d-lg-block">
									<div class="d-flex align-items-center py-1">
										<div class="position-relative">
											<img src="assets/img/avatar-default.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
										</div>
										<div class="flex-grow-1 pl-3">
											<strong><?= $row['firstName'].' '.$row['lastName'].' - '.$row['companyName'] ?></strong>
											<div class="text-muted small"><em>Messages...</em></div>
										</div>
									</div>
								</div>
								<?php
							}
						}
					}
					?>	

                    <!-- messages -->
					<div class="position-relative">
						<div class="chat-messages p-4">


							<?php
							if(isset($_GET['id']) AND !empty($_GET['id'])){
								$messages = readMessages($pdo, $sender, $receiver);
								foreach($messages as $msg){
									if($msg['msgToId'] == $getUserId['id']){
							?>
										<div class="d-flex flex-row justify-content-start mb-4">
											<div>
												<img src="assets/img/avatar-default.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
											</div>
											<div class="flex-shrink-1 text-light bg-success rounded py-2 px-3 ml-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $msg['msgTimestamp'] ?>">
												<div class="fw-bold mb-1">Contact</div>
												<?= $msg['msg'] ?>
											</div>
										</div>
							<?php
									}elseif($msg['msgFromId'] == $getUserId['id']){
							?>
										<div class="d-flex flex-row justify-content-end mb-4">
											<div class="flex-shrink-1 text-light bg-primary rounded py-2 px-3 mr-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $msg['msgTimestamp'] ?>">
												<div class="fw-bold mb-1">You</div>
												<?= $msg['msg'] ?>
											</div>
											<div>
												<img src="assets/img/avatar-man-cartoon.jpg" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
											</div>
										</div>
							<?php
									}
									
								}
							}
							?>

						</div>
					</div>

					<div class="flex-grow-0 py-3 px-4 border-top">
						<div class="input-group">
							<form method="POST" action="">
								<input type="text" name="message" class="form-control" size="200" placeholder="Ecrire un message">
								<button type="submit" name="envoyer" class="btn btn-primary">Envoyer</button>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>

</main>

<!-- Footer -->
<?php
require_once('templates/footer.php');
?>
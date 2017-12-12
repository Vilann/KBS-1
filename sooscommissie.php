<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - sooscommissie</title>
        <?php include 'includes/header.php';
				header('Content-Type: text/html; charset=ISO-8859-1');
				try {
							$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
							$user = "root";
							$pass = "usbw";
							$pdo = new PDO($db, $user, $pass);
						}
						catch (PDOException $e) {
						echo $e->getTraceAsString();
					} // NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
						$stmt = $pdo->prepare('SELECT commissienaam as comm_naam, commissiezin as comm_zin, commissietekst as comm_tekst
						FROM commissie
						WHERE commissieID = 0');
						$stmt->execute();
						$data = $stmt->fetchAll();
						foreach($data as $row) {?>
				<div class="container">
					<article class="bd-callout bd-callout-info">
						<?php print($row['comm_tekst']);?>
					</article>
					<iframe src="https://drive.google.com/embeddedfolderview?id=0B5oAJX1eoiAhOVNhYUo2M1JfdFk#list" style="width:100%; height:600px; border:0;"></iframe>
				</div>
			<?php } include 'includes/script.js'; ?>
	</body>
</html>

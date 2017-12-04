<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="commissies.css">
		<?php include 'includes/header.php'; ?>

		<div class="container" id="paginafoto" >
		<img src="afentikabanner.jpg" alt="" width="180px">
	</div>

	<div class="container">
		<article class="beschrijving">
			<?php
			$stmt = $pdo->prepare("SELECT commissiezin, commissietekst FROM commissie WHERE commissieID =?");
			$stmt->execute(array($commissie));
			 ?>
		</article>
	</div>

	</body>
</html>

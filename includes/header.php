<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
		integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="header.css">
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

		<div class="container">
			<img src="Website-logo-blauw.png" width="140px">
		</div>

		<nav>
			<ul class="navigation">
				<li><a href="index.php">Home</a></li>
				<li><a href="#">De vereniging</a></li>
				<li><a href="sidebar_commissie.php">Commissies</a></li>
				<li><a href="disputen.php">Disputen</a></li>
				<li><a href="#">Activiteiten</a></li>
				<li id="lustrum"><a href="#">Lustrum</a></li>
				<li><a href="contact.php">Contact</a></li>

				<?php
                session_start();
                if (!isset($_SESSION['email'])) {
                    print("<li><a href='login.php'>Log in/registreer</a></li>");
                } else {
                    print("<li><a href='#'>Hallo, met je email " . $_SESSION['email'] . " </a></li>");
                }
        ?>
			</ul>
		</nav>
	</body>
</html>

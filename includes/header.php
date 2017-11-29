<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
		integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="header.css">
		<link rel="stylesheet" href="./includes/ionicons/css/ionicons.min.css">
	</head>
	<body>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

		<div class="container">
			<img src="Website-logo-blauw.png" width="140px">
		</div>

		<nav class="navbar navbar-expand-lg navigation">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav mx-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">De vereniging</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="commissie.php">Commissies</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="disputen.php">Disputen</a>
		      </li>
					<li class="nav-item">
		        <a class="nav-link" href="#">Activiteiten</a>
		      </li>
					<li class="nav-item">
		        <a id="lustrum" class="nav-link" href="#">Lustrum</a>
		      </li>
					<li class="nav-item">
		        <a class="nav-link" href="contact.php">Contact</a>
		      </li>
		<!--
		<nav>
			<ul class="navigation">
				<li><a href="index.php">Home</a></li>
				<li><a href="#">De vereniging</a></li>
				<li><a href="sidebar_commissie.php">Commissies</a></li>
				<li><a href="disputen.php">Disputen</a></li>
				<li><a href="#">Activiteiten</a></li>
				<li id="lustrum"><a href="#">Lustrum</a></li>
				<li><a href="contact.php">Contact</a></li>
			-->
				<?php
                session_start();
                if (!isset($_SESSION['email'])) {
                    print("<li><a href='login.php'>Log in/registreer</a></li>");
                } else {
										print("<li class='nav-item dropdown'>
						        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										<img src='http://via.placeholder.com/30x30'>"." ".$_SESSION['email']."
										</a>
						        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
										<div class='container'>
											<div class='row'>
												<div class='col'>
													<p class='small text-secondary'>Persoonlijke pagina's:</p>
													<div class='dropdown-divider'></div>
								          <p class='dropdown-item'>LidNiveau:	<span class='text-secondary'>Nieuwlid</span></p>
								          <a href='./account.php' class='dropdown-item'>Account</a>
													<a href='#' class='dropdown-item'>Disputen</a>
													<a href='#' class='dropdown-item'>Commissies</a>
													<div class='dropdown-divider'></div>
													<a href='#' class='btn btn-outline-danger mx-auto'><i class='fa fa-sign-out' aria-hidden='true'></i> <b>Afmelden</b></a>
												</div>
											</div>
						        </div>
										</div>
						      </li>");
                    //print("<li><a href='#'>Hallo, met je email " . $_SESSION['email'] . " </a></li>");
                }
        ?>
			</ul>
		</div>
	</nav>
				<!--
			</ul>
		</nav>
	-->
	</body>
</html>

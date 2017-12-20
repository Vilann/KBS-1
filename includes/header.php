
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
		integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="header.css">
		<link rel="stylesheet" href="./includes/ionicons/css/ionicons.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<script src="./includes/script.js"></script>
	</head>
	<body>

		<div class="container">
			<img src="Website-logo-blauw.png" width="140px">
		</div>
		<nav class="navbar navbar-inverse bg-inverse navbar-expand-lg navbar-toggleable-sm navigation">
		  <button class="navbar-toggler icon_hamburger" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <i class="icon ion-navicon-round"></i>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">
		    <ul class="navbar-nav mx-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="index">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="vereniging">De vereniging</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="commissies">Commissies</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="disputen">Disputen</a>
		      </li>
					<li class="nav-item">
		        <a class="nav-link" href="activiteiten">Activiteiten</a>
		      </li>
					<!-- <li class="nav-item">
		        <a id="lustrum" class="nav-link" href="#">Lustrum</a>
		      </li> -->
					<li class="nav-item">
		        <a class="nav-link" href="contact">Contact</a>
		      </li>
				<?php
<<<<<<< HEAD
          error_reporting(E_ERROR | E_WARNING | E_PARSE);
=======
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
>>>>>>> d2c3d8aa22328159403f7746c43125db1d521550
                if (!isset($_SESSION['lid'])) {
                    ?>
										<li class="nav-item">
							        <a class="nav-link" href="login">Log in/registreer</a>
							      </li>
										<?php
                } else {
                    ?>
										<li class='nav-item dropdown'>
						        <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										<img src='http://via.placeholder.com/30x30'> <?php print($_SESSION['voornaam']) ?>
										</a>
						        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
										<div class='container'>
											<div class='row'>
												<div class='col'>
													<p class='small text-secondary'>Persoonlijke pagina's:</p>
													<div class='dropdown-divider'></div>
								          <p class='dropdown-item'>LidNiveau:	<span class='text-secondary'>Nieuwlid</span></p>
								          <a href='./account' class='dropdown-item'>Account</a>
													<a href='./account#dispuut' class='dropdown-item'>Disputen</a>
													<a href='./account#commissies' class='dropdown-item'>Commissies</a>
													<a href='./admin' class='dropdown-item'>Beheerpagina</a>
													<div class='dropdown-divider'></div>
													<a class='btn btn-outline-danger mx-auto' href="loguit"><i class="icon ion-log-out"></i> <b>Afmelden</b></a>
												</div>
											</div>
						        </div>
										</div>
						      </li>
									<?php
                }
        ?>
			</ul>
		</div>
	</nav>

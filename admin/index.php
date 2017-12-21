<?php include '../includes/beveiliging.php';
beveilig_adminpagina();
/*edit leden () (1 uur) done
edit commissies & disputen (als ik nog tijd heb) (2 uur)  done
tijdlimiet polls () | 20min
toevoegen leden aan commissies en disputen( 2uur)
aanpassen algemene pagina's (tussen 30min en 2.5 uur)//
toevoegen activiteiten + aanpassen 2 uur

functie die je rechten geeft I quess idk

wachtwoord vergeten*/
?>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
  integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="../includes/ionicons/css/ionicons.min.css">
  <title>ZHTC | Dashboard</title>
  <!-- Bootstrap core CSS -->

  <!-- Custom styles for this template -->
  <link href="./pages/dashboard.css" rel="stylesheet">
  </head>

  <body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script src="../includes/script.js"></script>
  <header>
    <nav class="navbar navbar-inverse bg-inverse navbar-expand-lg navbar-toggleable-sm navigation">
      <a class="navbar-brand text-white" href="#">ZHTC</a>
      <button class="navbar-toggler icon_hamburger" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="icon ion-navicon-round"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class='nav-item dropdown'>
          <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <img src='http://via.placeholder.com/30x30'> <?php print($_SESSION['voornaam']) ?>
          </a>
          <div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdown'>
          <div class='container'>
            <div class='row'>
              <div class='col'>
                <p class='small text-secondary'>Persoonlijke pagina's:</p>
                <div class='dropdown-divider'></div>
                <p class='dropdown-item'>LidNiveau:	<span class='text-secondary'>Nieuwlid</span></p>
                <a href='../../account' class='dropdown-item'>Account</a>
                <a href='../../index' class='dropdown-item'>Homepagina</a>
                <div class='dropdown-divider'></div>
                <a class='btn btn-outline-danger mx-auto' href="../../loguit"><i class="icon ion-log-out"></i> <b>Afmelden</b></a>
              </div>
            </div>
          </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  </header>

  <div class="container-fluid full_length">
  <div class="row full_length">
    <div class="col-md-2 col-xs-1 pl-0 pr-0 collapse show" id="sidebar">
        <div class="list-group panel">
            <a href="../index" class="list-group-item collapsed" data-parent="#sidebar"><i class="icon ion-home"></i> <span class="hidden-sm-down"> Adminpanel</span></a>
            <!-- Beheer tools -->
            <?php
            if(isset($_SESSION['admin']['Beheer'])){
            ?>
            <a id="beheerlink" href="#beheer" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"> <span class="hidden-sm-down">ZHTC-beheer tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
            <div class="collapse" id="beheer">
              <a id="beheerpagina" href="/KBS-1/admin/pages/beheerpagina" class="list-group-item" data-parent="#beheer"><i class="icon ion-edit"></i> Aanpassen pagina's </a>
                <a id="leden" href="/KBS-1/admin/pages/leden" class="list-group-item" data-parent="#beheer"><i class="icon ion-person-stalker"></i> Ledenbestand </a>
                <a id="poll" href="/KBS-1/admin/pages/poll" class="list-group-item" data-parent="#beheer"><i class="icon ion-document-text"></i> Polls </a>
                <a id="commissiedisputen" href="/KBS-1/admin/pages/commissiedisputen" class="list-group-item" data-parent="#beheer"><i class="icon ion-chatbubbles"></i> Commissies & Disputen</a>
                <a id="activiteiten" href="/KBS-1/admin/pages/activiteiten" class="list-group-item" data-parent="#beheer"><i class="icon ion-wineglass"></i> Activiteiten </a>
            </div>
            <!-- Commissie tools -->
            <?php
            }if(isset($_SESSION['admin']['Commissie'])){
            ?>
            <a id="commissielink" href="#commissie" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"> <span class="hidden-sm-down">ZHTC-commissie tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
            <div class="collapse" id="commissie">
                <a id="commissieleden" href="/KBS-1/admin/pages/commissieleden" class="list-group-item" data-parent="#commissie"><i class="icon ion-person-stalker"></i> Commissie leden </a>
                <a id="commissiepagina" href="/KBS-1/admin/pages/commissiepagina" class="list-group-item" data-parent="#commissie"><i class="icon ion-edit"></i> Commissie Pagina </a>
                <a id="2activiteiten" href="/KBS-1/admin/pages/activiteiten" class="list-group-item" data-parent="#commissie"><i class="icon ion-wineglass"></i> Activiteiten </a>
            </div>
            <!-- Dispuut tools -->
            <?php
            }if(isset($_SESSION['admin']['Dispuut'])){
            ?>
            <a id="dispuutlink" href="#dispuut" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><span class="hidden-sm-down">ZHTC-dispuut tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
            <div class="collapse" id="dispuut">
              <a id="dispuutleden" href="/KBS-1/admin/pages/dispuutleden" class="list-group-item" data-parent="#dispuut"><i class="icon ion-person-stalker"></i> Disputen leden </a>
              <a id="dispuutpagina" href="/KBS-1/admin/pages/dispuutpagina" class="list-group-item" data-parent="#dispuut"><i class="icon ion-edit"></i> Disputen Pagina </a>
            </div>
            <?php
            }
            ?>
            <a href="#" class="list-group-item collapsed" data-parent="#sidebar"><i class="icon ion-gear-a"></i> <span class="hidden-sm-down">Instellingen</span></a>
        </div>
    </div>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1>Adminpanel
                            <span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <p class="text-muted">
              hier kun je Bacon ipsum dolor amet meatball shank pork belly cow jowl ham hock ribeye biltong beef ribs capicola bacon t-bone. Doner cow porchetta tongue. Pork picanha bresaola, kevin sausage boudin salami. Sausage cow capicola doner. Andouille beef meatloaf burgdoggen kielbasa, flank jowl drumstick beef ribs ground round tail.
            </p>
        </main>
    </div>
</div>
</body>
</html>

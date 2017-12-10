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
        <li class="nav-item">
          <a class="nav-link" href="index">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  </header>

  <div class="container-fluid">
  <div class="row">
      <div class="col-md-2 col-xs-1 pl-0 pr-0 collapse show" id="sidebar">
          <div class="list-group panel">
              <a href="#" class="list-group-item collapsed" data-parent="#sidebar"><i class="icon ion-home"></i> <span class="hidden-sm-down"> Adminpanel</span></a>
              <a href="#menu1" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"> <span class="hidden-sm-down">ZHTC-beheer tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
              <div class="collapse" id="menu1">
                  <a href="./pages/leden" class="list-group-item" data-parent="#menu1"><i class="icon ion-person-stalker"></i> Ledenbestand </a>
                  <a href="#" class="list-group-item" data-parent="#menu1"><i class="icon ion-document-text"></i> Polls </a>
                  <a href="#" class="list-group-item" data-parent="#menu1"><i class="icon ion-chatbubbles"></i> Commissies & Disputen</a>
              </div>
              <a href="#menu2" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"> <span class="hidden-sm-down">ZHTC-commissie tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
              <div class="collapse" id="menu2">
                  <a href="#" class="list-group-item" data-parent="#menu2"><i class="icon ion-person-stalker"></i> Commissie leden </a>
                  <a href="#" class="list-group-item" data-parent="#menu2"><i class="icon ion-edit"></i> Commissie Pagina </a>
              </div>
              <a href="#menu3" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><span class="hidden-sm-down">ZHTC-dispuut tools </span><i class="icon ion-android-arrow-dropdown-circle"></i></a>
              <div class="collapse" id="menu3">
                <a href="#" class="list-group-item" data-parent="#menu3"><i class="icon ion-person-stalker"></i> Disputen leden </a>
                <a href="#" class="list-group-item" data-parent="#menu3"><i class="icon ion-edit"></i> Disputen Pagina </a>
              </div>
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
              Bacon ipsum dolor amet meatball shank pork belly cow jowl ham hock ribeye biltong beef ribs capicola bacon t-bone. Doner cow porchetta tongue. Pork picanha bresaola, kevin sausage boudin salami. Sausage cow capicola doner. Andouille beef meatloaf burgdoggen kielbasa, flank jowl drumstick beef ribs ground round tail.
            </p>
        </main>
    </div>
</div>
</body>
</html>

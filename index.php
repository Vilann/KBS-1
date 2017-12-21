<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Home</title>
        <?php include 'includes/header.php';
              include 'includes/dbconnect.php';

              if (isset($_POST['submit'])) {
                  //sla de datum van vandaag op in $date
                  //Prepare en execute de sql query om een nieuwe poll toe te voegen
                  error_reporting(E_ERROR | E_WARNING | E_PARSE);
                  $stmt = $pdo->prepare("INSERT INTO pollresultaat(pollId, lidID, pollkeuze)
                  VALUES(?, ?, ?)");
                  $stmt->execute(array($_POST['id'],$_SESSION['lid'],$_POST['keuze']));
                  //die("succes maybe???".$_POST['id']." ".$_SESSION['lid']." ".$_POST['keuze']);
                  header('Location: index');
              } else {
                  //Niks
              }
              //include 'includes/sidebar.php';?>
              <div id="fb-root"></div>
              <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11';
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
              </script>
              <script>
              $(document).ready(function(){
                $(".carousel-item").first().addClass("active");

              });
              </script>

            <div class="container-fluid">
              <div class="row border-top-0 border-right-0 border-left-0 border-secondary border zhtc-brd slide-border">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                  </ol>

                  <!-- Wrapper for slides -->

                  <div class="carousel-inner">
                    <?php
                    $stmt = $pdo->prepare('SELECT * FROM slider');
                    $stmt->execute();
                    $data = $stmt->fetchall();
                    foreach ($data as $data) {
                        ?>
                    <div class="carousel-item" role="listbox">
                      <img class="d-block img-fluid" src="images/slider/<?php print(ucfirst($data['afbeelding'])); ?>" alt="<?php print(strtolower($data['fototitel'])); ?>">
                      <div class="carousel-caption">
                      <h3><?php strtoupper(print($data["fototitel"])); ?></h3>
                        <p><?php print($data["tekst"]); ?></p>
                      </div>
                    </div>
                    <?php
                    } ?>
                  </div>

                  <!-- Left and right controls -->
                  <!-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a> -->
                </div>
                </div>
            </div>
                        <br>
            <div class="container-fluid">
              <div class="row">
                <img src="Website-logo-blauw.png" class="mx-auto d-block img-responsive" width="10%" height="14%">
              </div>
            </div>
            <hr>
            <div class="container-fluid">
                <h2 class="align-middle"><span class="font-weight-light align-middle">D&eacute; studentenvereniging van Zwolle</span></h2>
            </div>
            <div class="container-fluid">
              <div class="row">
                <p class="text-center text-muted font-weight-light mx-3">Gesticht in 1952 is ZHTC de oudste vereniging van Zwolle. De vereniging zet zich in voor contacten leggen met andere studenten, kennis opdoen in commissies, vrienden maken, en leuke activiteiten organiseren. Broederschap staat hierbij hoog in het vaandel. ZHTC is ook de enige studentenvereniging met een eigen sociëteit binnen Zwolle. Hier worden veel activiteiten georganiseerd en het is een ontmoetingsplek voor alle leden. Kortom: ZHTC is het juiste begin van iedereens studententijd.</p>
              </div>
            </div>
            <br>
            <div class="container-fluid">
              <div class="wrapper mx-auto width-60">
                <h2 class="align-middle h2-fac"><span class="font-weight-light align-middle span-fac">Nieuwsberichten</span></h2>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <p class="text-center text-muted font-weight-light mx-auto">Hieronder kunt u onze facebook en instagram feed zien.</p>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-6 col-xs-12">
                  <center class="float-right col-6 mr-3">
                    <div class="fb-page" data-href="https://www.facebook.com/asvzhtc" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false">
                      <blockquote cite="https://www.facebook.com/asvzhtc" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/asvzhtc">ZHTC</a>
                      </blockquote>
                    </div>
                  </center>
                </div>
                <div class="col-6 col-xs-12">
                  <center class="float-left col-6 ml-3">
                    <!-- InstaWidget -->
                    <a href="https://instawidget.net/v/user/asvzhtc" id="link-5fff1ec5c31a9609de1275d00fbb28a1933c4eac00ad9216e8bb6a7b5d24b5b9">@asvzhtc</a>
                    <script src="https://instawidget.net/js/instawidget.js?u=5fff1ec5c31a9609de1275d00fbb28a1933c4eac00ad9216e8bb6a7b5d24b5b9&width=300px"></script>
                  </center>
                </div>
              </div>
          </div>
          <div class="container-fluid">
            <div class="wrapper mx-auto width-60">
              <h2 class="align-middle"><span class="font-weight-light align-middle">Activiteiten</span></h2>
            </div>
          </div>
          <div class="container-fluid">
            <div class="row">
              <p class="text-center text-muted font-weight-light mx-auto">Klik op de knop hieronder om naar de activiteiten pagina te gaan.</p>
            </div>
            <div class="row">
              <button onclick="location.href='activiteiten'" type="button" class="btn btn-outline-primary zhtc-button mx-auto">Activiteiten</button>
            </div>
          </div>
          <?php
          if (isset($_SESSION['lid'])) {
              $stmt = $pdo->prepare("SELECT p.vraag, p.pollID FROM poll p
            WHERE einddatum >= CURDATE()
            ORDER BY pollID DESC
            LIMIT 1");
              $stmt->execute();
              $info = $stmt->fetch(PDO::FETCH_ASSOC);
              $stmt2 = $pdo->prepare("SELECT p.lidID FROM pollresultaat p
            WHERE p.pollID = ?
            AND p.lidID = ?");
              $stmt2->execute(array($info['pollID'],$_SESSION['lid']));
              $info2 = $stmt2->fetch(PDO::FETCH_ASSOC);
              //die($info2['lidID']." | ".$info['pollID']." | ".$_SESSION['lid']);
              if (!empty($info2['lidID'])) {
                  //niks
              } else {
                  ?>
          <div class="position-fixed side-note">
            <div class="card" style="width: 20rem;">
              <div class="card-body">
                <h4 class="card-title"><i class="icon ion-alert"></i> Nieuwe poll</h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php print($info['vraag']); ?></h6>
                <form action="index" method="post">
                  <?php
                  $stmt = $pdo->prepare("SELECT p.vraag, p.pollID, pk.pollkeuzemogelijkheid FROM poll p
                  JOIN pollkeuzemogelijkheid pk ON p.pollID = pk.pollID
                  WHERE einddatum >= CURDATE()
                  AND p.pollID = ?
                  ORDER BY pollID DESC");
                  $stmt->execute(array($info['pollID']));
                  $data = $stmt->fetchAll();
                  foreach ($data as $row) {
                      ?>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="keuze" id="exampleRadios1" value="<?php print($row['pollkeuzemogelijkheid']); ?>">
                    <?php print($row['pollkeuzemogelijkheid']); ?>
                  </label>
                </div>
                <?php
                  } ?>
                <br>
                <input type="hidden" name="id" value="<?php print($row['pollID']); ?>"/>
                <button type="submit" name="submit" class="btn btn-outline-primary zhtc-button">Verzenden</button>
              </form>
              </div>
            </div>
          </div>
          <?php
              }
          }
           ?>
          <br>

              <!-- <a href="https://zhtc.nl/lustrumshop/">Ga naar de Lustrumshop</a> -->

    <?php include 'includes/footer.php'; ?>
</html>

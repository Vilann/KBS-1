<?php
include('includes/beveiliging.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - activiteiten</title>
    <?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(isset($_GET['tpe'])){
      $activiteiten = "<";
      $activiteitenNaam = "Vorige";
      $activiteitenLink = "#";
      $activiteitenRedirect = "Aankomende";
    }else{
      $activiteiten = ">";
      $activiteitenNaam = "Aankomende";
      $activiteitenLink = "?tpe=1";
      $activiteitenRedirect = "Vorige";
    }
    if(isset($_GET['ac']) && !(empty($_GET['ac']))){
      $stmt = $pdo->prepare("SELECT activiteitinfo, activiteitnaam, l.voornaam, DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%Y%m%d') as googledatevanaf, DATE_FORMAT(datumtot, '%Y%m%d') as googledatetot, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitlocatie FROM activiteit a
      JOIN lid l ON a.lidID = l.lidID
      WHERE activiteitid = ?");
      $stmt->execute(array($_GET['ac']));
      $info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($stmt->rowCount()) {
        $googlevanaf = $info['googledatevanaf'];
        $googletot = $info['googledatetot'];
        $activiteitnaam = $info['activiteitnaam'];
        $locatie = $info['activiteitlocatie'];
        $googleLink = "https://calendar.google.com/calendar/r/eventedit?text=$activiteitnaam&dates=$googlevanaf/$googletot&details&location=$locatie&trp=false&sprop=website:https://zhtc.nl&ctz=Europe/Amsterdam&sf=true&output=xml";
      } else {
          print("Werkt niet");
      }
      ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <a href="./activiteiten" class="text-muted pt-5"><i class="icon ion-chevron-left"></i> activiteiten</a>
            <h1 class="text-center mt-4"><u> <?php print($info['activiteitnaam']); ?></u></h1>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 col-lg-7 order-sm-12 order-lg-1">
            <div class="card mb-4 card-noborder">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h5 class="card-text text-left my-0"><i class="icon ion-person zhtc-c mr-2"></i> <?php print($info['voornaam']); ?></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5 offset-7">
                    <?php
                    if($info['datumvanaf'] == $info['datumtot']){
                    ?>
                    <p class="card-text text-right my-0">Datum: <span class="text-muted"><?php print($info['datumvanaf']); ?></span></p>
                    <p class="card-text text-right my-0">Van: <span class="badge badge-primary zhtc-bg"><i class="icon ion-clock"></i><?php print($info['tijdvanaf']); ?></span> <span class="text-muted">t/m</span> <span class="badge badge-primary zhtc-bg"><i class="icon ion-clock"></i>
                    <?php print($info['tijdtot']); ?> </span></p>
                    <?php
                    }else{ ?>
                    <p class="card-text text-right my-0">Vanaf: <span class="text-muted"><?php print($info['datumvanaf']); ?> <span class="badge badge-primary zhtc-bg "><i class="icon ion-clock"></i><?php print($info['tijdvanaf']); ?></span></span></p>
                    <p class="card-text text-right my-0">Tot: <span class="text-muted"><?php print($info['datumtot']); ?> <span class="badge badge-primary zhtc-bg"><i class="icon ion-clock"></i><?php print($info['tijdtot']); ?></span></span></p>
                    <?php }?>
                    <p class="card-text text-right my-0">Locatie: <span class="text-muted"><?php print($info['activiteitlocatie']); ?></span></p>
                  </div>
                </div>
                <h2 class="card-title text-left mt-5">Informatie</h2>
                <p class="card-text text-justify">
                  <?php print($info['activiteitinfo']); ?>
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-5 order-sm-1 order-lg-12">
            <div class="card mb-4 card-noborder">
              <div class="card-body">
                <img src="http://via.placeholder.com/300x300" class="img-fluid mx-auto d-block rounded" alt="Responsive image">
                <hr>
                <div class='wrapper text-center'>
                  <div class="btn-group mx-auto" role="group" aria-label="...">
                    <a href="#" class="btn btn-outline-primary zhtc-button">Koop ticket</a>
                    <a href="<?php print($googleLink);?>" class="btn btn-outline-primary zhtc-button">Toevoegen aan google calender</a>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
      <?php
    }else{
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4"><?php print($activiteitenNaam);?> activiteiten</h1>
          <a href="./activiteiten<?php print($activiteitenLink); ?>" class="text-muted"><i class="icon ion-chevron-left"></i> <?php print($activiteitenRedirect); ?> activiteiten</a>
        </div>
      </div>
      <hr>
      <?php	try {
      		$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
      		$user = "root";
      		$pass = "usbw";
      		$pdo = new PDO($db, $user, $pass);
      	}
      	catch (PDOException $e) {
      	echo $e->getTraceAsString();
      	}
        $stmt = $pdo->prepare("SELECT DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitnaam, activiteitlocatie
        FROM activiteit
        WHERE datumvan $activiteiten CURDATE()
        ORDER by datumvan ASC");
        $stmt->execute();
        $data = $stmt->fetchAll();
        error_reporting(0);
        foreach($data as $row) {
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title"><?php print($row['activiteitnaam']);?></h4>
              <p class="card-text"><i class="icon ion-calendar"></i> <?php print($row['datumvanaf']);?> <span class="badge badge-primary zhtc-bg"><i class="icon ion-clock"></i><?php print($row['tijdvanaf']); ?></span></p>
              <p class="card-text"><i class="icon ion-location"></i> <?php print($row['activiteitlocatie']);?>
              <a href="?ac=<?php print($row['activiteitid']); ?>" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
            </div>
            <div class="card-footer text-muted">
              <?php
              $now = time(); // or your date as well
              $your_date = strtotime($row['datumvanaf']);
              $datediff = $your_date - $now;

              $tijdTotdatum = floor($datediff / (60 * 60 * 24));
               ?>
              over <?php print($tijdTotdatum);?> dagen
            </div>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>
    <?php
    } ?>
  </body>
  <script>
  <?php include 'includes/script.js'; ?>
  </script>
</html>

<!-- ?php
         $stmt = $pdo->prepare("SELECT activiteitid, DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitnaam, activiteitlocatie
// -- >>>>>>> 4d3c7ca675227b3f52adca605d66133461861313 -->

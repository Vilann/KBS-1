<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - commissies</title>
		<?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(isset($_GET['cm']) && !(empty($_GET['cm']))){
      $stmt = $pdo->prepare("SELECT activiteitinfo, activiteitnaam, l.voornaam, DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%Y%m%d') as googledatevanaf, DATE_FORMAT(datumtot, '%Y%m%d') as googledatetot, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitlocatie FROM activiteit a
      JOIN lid l ON a.lidID = l.lidID
      WHERE activiteitid = ?");
      $stmt->execute(array($_GET['cm']));
      $info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($stmt->rowCount()) {
        $googlevanaf = $info['googledatevanaf'];
        $googletot = $info['googledatetot'];
        $activiteitnaam = $info['activiteitnaam'];
        $locatie = $info['activiteitlocatie'];
        $googleLink = "https://calendar.google.com/calendar/r/eventedit?text=$activiteitnaam&dates=$googlevanaf/$googletot&details&location=$locatie&trp=false&sprop=website:https://zhtc.nl&ctz=Europe/Amsterdam&sf=true&output=xml";
      } else {
          print("Werkt niet");
      }}//laatste haakje moet nog weg
      ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Commissies</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
        </div>
      </div>
			<hr>
			<div class="row">
			<?php
			header('Content-Type: text/html; charset=ISO-8859-1');
			try {
						$db = "mysql:host=localhost;dbname=zhtc;port=3306";
						$user = "root";
						$pass = "";
						$pdo = new PDO($db, $user, $pass);
					}
					catch (PDOException $e) {
					echo $e->getTraceAsString();
				} // NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
					$stmt = $pdo->prepare('SELECT commissieID, commissienaam as comm_naam, commissiezin as comm_zin, commissietekst as comm_tekst
					FROM commissie');
					$stmt->execute();
					$data = $stmt->fetchAll();
					foreach($data as $row) {
					?>
        <div class="col-3">
          <div class="card" style="width: 25rem;"><?php // NOTE: was class="card mb4" geen idee wat mb inhoud ?>
            <div class="card-body"> <?php // NOTE: alles in deze div staat in de kaart ?>
              <h4 class="card-title"><?php print($row['comm_naam'])?></h4> <?php // NOTE: de naam van de commissie ?>
              <p class="card-text">
							<img class="card-img-top" src="afentikabanner.jpg" alt="" style="width: 20rem;"><br><?php// print($row['comm_zin']);?><?php // NOTE: de commissiezin ?>
            </div>
						<div class="card-footer text-muted"><?php print($row['comm_zin']);?>
							<a href="?cm=<?php print($row['commissieID'])?>" class="btn btn-outline-primary float-right zhtc-button">Meer<i class="icon ion-arrow-right-c"></i></a></p>
						</div>
          </div>
        </div>
		<?php } ?>
	</div>
    </div>
		<script>
		<?php include 'includes/script.js'; ?>
	  </script>
  </body>
</html>

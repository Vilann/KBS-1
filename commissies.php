<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - commissies</title>
		<link rel="stylesheet" href="commissies.css">
		<?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Commissies</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
        </div>
      </div>
			<hr>
			<?php try {
						$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
						$user = "root";
						$pass = "usbw";
						$pdo = new PDO($db, $user, $pass);
					}
					catch (PDOException $e) {
					echo $e->getTraceAsString();
				} // NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
					$stmt = $pdo->prepare('SELECT commissienaam as comm_naam, commissiezin as comm_zin, commissietekst as comm_tekst
					FROM commissie');
					$stmt->execute();
					$data = $stmt->fetchAll();
					foreach($data as $row) {
					?>
      <div class="row">
        <div class="col-12">
          <div class="card" style="width: 25rem;"><?php // NOTE: was class="card mb4" geen idee wat mb inhoud ?>
            <div class="card-body"> <?php // NOTE: alles in deze div staat in de kaart ?>
              <h4 class="card-title"><?php print($row['comm_naam'])?></h4> <?php // NOTE: de naam van de commissie ?>
              <p class="card-text">
							<img class="card-img-top" src="afentikabanner.jpg" alt="" style="width: 20rem;"><br><?php print($row['comm_zin']);?><?php // NOTE: de commissiezin ?>
							<a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
  <?php } include 'includes/script.js'; ?>
  </script>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - Over de vereniging</title>
		<?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Over ZHTC</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
        </div>
      </div>
			<hr>
			<p class="text-center mt-4">Algemene studentenvereniging Zwols Hoger Technisch Corps (Asv. ZHTC) is dé studentenvereniging voor iedere HBO – òf universitaire student in Zwolle.
Asv. ZHTC heeft als enige studentenvereniging de beschikking over een eigen sociëteit. Een mooi en groot pand aan de Thomas à Kempisstraat, net buiten de grachten van het centrum. Mede dankzij deze sociëteit zorgt Asv. ZHTC voor een leuke, gezellige en ook nog eens een leerzame studententijd. De vereniging is opgericht in 1952, heeft ongeveer driehonderd leden en donateurs en is daarmee de oudste en gezelligste studentenvereniging van Zwolle. De vereniging is opgericht met koninklijke goedkeuring, op d.d. 21 November 1952 en ingeschreven in het verenigingsregister bij de Kamer van Koophandel te Zwolle onder nummer 40059409.</p>

			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h1 class="text-center mt-4">Geschiedenis</h1>
						<!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
					</div>
				</div>
				<hr>
			<p class="text-center mt-4"> Info... </p>
			<div class="container_fluid">
				<div class="row">
					<div class="col-12">
						<h1 class="text-center mt-4">Oud-besturen</h1>
						<!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
					</div>
				</div>
				<hr>
			<h4> Oud bestuur 1: </h4>
			<p> Info... </p>
			<h4> Oud bestuur 2: </h4>
			<p> Info... </p>
			<?php

                        header('Content-Type: text/html; charset=ISO-8859-1');

                    $stmt = $pdo->prepare('SELECT dispuutnaam, dispuutzin, dispuuttekst
					FROM dispuut');
                    $stmt->execute();
                    $data = $stmt->fetchAll();
                    foreach ($data as $row) {
                        ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb4">
            <div class="card-body"> <?php // NOTE: alles in deze div staat in de kaart?>
              <h4 class="card-title"><?php print($row['dispuutnaam'])?></h4>
              <p class="card-text">
              <a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a>
							<img class="card-img-left" src="afentikabanner.jpg" alt="" width="180px"><?php print($row['dispuutzin']); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php include 'includes/footer.php'; ?>
  <script>
  <?php
                    } include 'includes/script.js'; ?>
  </script>
</html>

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
			<p class="text-center mt-4">Info...</p>

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

<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ZHTC - disputen</title>
		<?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    //error_reporting(E_ERROR | E_WARNING | E_PARSE);
        if (isset($_GET['dp']) && !(empty($_GET['dp']))) {
            $stmt = $pdo->prepare("SELECT dispuutvoorzitter as dpvoorzit,
				dispuutbanner as dpbann,
				dispuutnaam as dpnaam,
				dispuutzin as dpzin,
				dispuuttekst as dptekst,
				d.dispuutid as dpid,
				dl.lidID as dplid,
				l.voornaam as voornaam
			FROM dispuut d
			JOIN lid l ON d.dispuutvoorzitter = l.lidID
			JOIN dispuutlid dl ON dl.dispuutID = d.dispuutid
			WHERE d.dispuutid = ?");
			// NOTE: vervolgens wordt hierboven alle relevante dispuut informatie opgehaald (met een voorbereid statement) en hieronder
			// NOTE: wordt de info in een leesbare, makkelijk te gebruiken array gestopt.
            $stmt->execute(array($_GET['dp']));
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount()) {
                $dispuutvoorzitter = $info['dpvoorzit'];
                $dispuutnaam = $info['dpnaam'];
                $dispuutlid = $info['dplid'];
                $dispuutzin = $info['dpzin'];
                $dispuutid = $info['dpid'];
                $dispuuttekst = $info['dptekst'];
                $dispuutagenda = $info['dpagendaID'];
                $dispuutnotulen = $info['dpnotulenID'];
                $dispuutbanner = $info['dpbann'];
                $voornaam = $info['voornaam'];
            } else {
                print("Werkt niet, of... of het database tabel waar je naar zoekt is leeg");
            } ?>
						<?php // NOTE: hieronder wordt elke dispuutskaart afzonderlijk gemaakt ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h1 class="text-center mt-4"><?php print($info['dpnaam']) ?></h1>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 col-lg-7 order-sm-12 order-lg-1">
						<div class="card mb-4 card-noborder">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<h5 class="card-text text-left my-0">
											<?php print($info['voornaam']); ?></h5>
									</div>
								</div>
								<?php// NOTE: dit statement haalt de de voornamen van de dispuutleden op uit de database.
                $stmt = $pdo->prepare("SELECT voornaam FROM lid l JOIN dispuutlid dl ON dl.lidID = l.lidID WHERE dispuutID = ?");
            $stmt->execute(array($dispuutid));
            $leden = $stmt->fetchAll(); ?>
								<div class="row">
									<div class="col-5 offset-7">
										<?php // NOTE:  vervolgens worden die namen hier geprint. ?>
										<p class="card-text text-right my-0">Voorzitter: <span class="text-muted"><?php print(ucfirst($voornaam)); ?></span></p>
										<p class="card-text text-right my-0">Leden:<span class="text-muted">
										<?php foreach ($leden as $lid) {
                print(ucfirst($lid['voornaam'] . "<br>"));
            } ?> </span> </p>
										</div>
								</div>
								<h2 class="card-title text-center mt-5 header-txt">Informatie</h2>
								<p class="card-text text-justify">
									<?php print($info['dptekst']); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-5 order-sm-1 order-lg-12">
						<div class="card mb-4 card-noborder">
							<div class="card-body">
								<img src="images/dispuutfotos/<?php print($info['dpbann']) ?>" class="img-fluid mx-auto d-block rounded" alt="Responsive image">
								<hr>
								<div class='wrapper text-center'>
									<?php if (isset($_SESSION['lid'])) {
                ?>
									<div class="btn-group mx-auto" role="group" aria-label="...">
									<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['dpagendaID']); ?>" class="btn btn-outline-primary zhtc-button">Agenda</a>
									<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['dpnotulenID']); ?>" class="btn btn-outline-primary zhtc-button">Notulen</a>
								</div> <?php
            } ?>
								</div>
						</div>
				</div>
			</div>
		</div>
	</div>
			<?php
        } else {// NOTE: Deze else is de eerste pagina die je ziet. Op het moment dat er op de "meer-knop" wordt gedrukt, wordt het commissieID in de if
								 // NOTE: op regel 8 ingevuld en laad de pagina met dispuuts informatie.
            ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Disputen</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oud Disputen</p> -->
        </div>
      </div>
			<hr>
			<div class="row">
			<?php// NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
                    $stmt = $pdo->prepare('SELECT * FROM dispuut');
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach ($data as $row) {
                ?>
        <div class="col-12">
          <div class="card mb-4"><?php // NOTE: Ditis bootstrap code en heeft te maken met de grootte van de kaart. ?>
            <div class="card-body"> <?php // NOTE: alles in deze div staat in de kaart?>
              <h4 class="card-title"><?php print($row['dispuutnaam'])?></h4>
              <p class="card-text">
							<img class="card-img-left" src="images/dispuutfotos/<?php print($row['dispuutbanner'])?>" alt="" width="180px"></p>
            </div>
						<div class="card-footer text-muted"><?php print($row['dispuutzin']); ?>
						<a href=<?php print("?dp=".$row['dispuutid']) ?> class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
					</div>
          </div>
        </div>
			<?php
            } ?>
		</div>
	    </div><?php
        } ?>
			<?php include 'includes/footer.php'; ?>
			<script>
			<?php include 'includes/script.js'; ?>
		  </script>
</html>

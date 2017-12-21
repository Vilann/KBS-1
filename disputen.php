<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - disputen</title>
		<?php include 'includes/header.php';
    include 'includes/dbconnect.php';
    //error_reporting(E_ERROR | E_WARNING | E_PARSE);
		if(isset($_GET['dp']) && !(empty($_GET['dp']))){
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
			}
			?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h1 class="text-center mt-4"><u> <?php print($info['dpnaam']); ?></u></h1>
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
								<div class="row">
									<div class="col-5 offset-7">

										<p class="card-text text-right my-0">Voorzitter: <span class="text-muted"><?php print ucfirst(($info['voornaam'])); ?></span></p>
										<p class="card-text text-right my-0">Leden:<span class="text-muted">
										<?php foreach ($info as $dispuutlid) {
											print($info['dplid'] . "<br>");}?> </span> </p>
										</div>
								</div>
								<h2 class="card-title text-left mt-5">Informatie</h2>
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
									<?php if(isset($_SESSION['lid'])){ ?>
									<div class="btn-group mx-auto" role="group" aria-label="...">
									<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['dpagendaID']);?>" class="btn btn-outline-primary zhtc-button">Agenda</a>
									<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['dpnotulenID']);?>" class="btn btn-outline-primary zhtc-button">Notulen</a>
								</div> <?php } ?>
								</div>
						</div>
				</div>
			</div>
		</div>
	</div>
			<?php
		}else{?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Disputen</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oud Disputen</p> -->
        </div>
      </div>
			<hr>
			<div class="row">
			<?php
					$stmt = $pdo->prepare('SELECT * FROM dispuut');
					$stmt->execute();
					$data = $stmt->fetchAll();
					foreach($data as $row) {
					?>
        <div class="col-12">
          <div class="card mb4">
            <div class="card-body"> <?php // NOTE: alles in deze div staat in de kaart ?>
              <h4 class="card-title"><?php print($row['dispuutnaam'])?></h4>
              <p class="card-text">
							<img class="card-img-left" src="images/dispuutfotos/<?php print($row['dispuutbanner'])?>" alt="" width="180px"></p>
            </div>
						<div class="card-footer text-muted"><?php print($row['dispuutzin']);?>
						<a href=<?php print("?dp=".$row['dispuutid']) ?> class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
					</div>
          </div>
        </div>
			<?php } ?>
		</div>
	    </div><?php } ?>
			<?php include 'includes/footer.php'; ?>
			<script>
			<?php include 'includes/script.js'; ?>
		  </script>
</html>

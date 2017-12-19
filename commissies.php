<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - commissies</title>
		<?php include 'includes/header.php';
		include 'includes/dbconnect.php';
		if(isset($_GET['cm']) && !(empty($_GET['cm']))){
      $stmt = $pdo->prepare("SELECT commissievoorzitter as cmvoorzit,commissienaam as cmnaam,
				c.commissieID as cmID,commissiezin as cmzin, commissietekst as cmtekst, l.voornaam as voornaam, cl.lidID as cmlid
			FROM commissie c
			JOIN lid l ON c.commissievoorzitter = l.lidID
			JOIN commissielid cl ON cl.commissieID = c.commissieID
      WHERE c.commissieID = ?");
      $stmt->execute(array($_GET['cm']));
      $info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($stmt->rowCount()) {
        $commissievoorzitter = $info['cmvoorzit'];
        $commissienaam = $info['cmnaam'];
        $commissielid = $info['cmlid'];
        $commissiezin = $info['cmzin'];
        $commissieid = $info['cmID'];
        $commissietekst = $info['cmtekst'];
        $voornaam = $info['voornaam'];
      } else {
          print("Werkt niet");
      }
      ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h1 class="text-center mt-4"><u> <?php print($info['cmnaam']); ?></u></h1>
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
											<?php header('Content-Type: text/html; charset=ISO-8859-1'); print($info['voornaam']); ?></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5 offset-7">

                    <p class="card-text text-right my-0">Voorzitter: <span class="text-muted"><?php print ucfirst(($info['voornaam'])); ?></span></p>
                    <p class="card-text text-right my-0">Leden:<span class="text-muted">
                    <?php foreach ($info as $commissielid) {
                    	print($info['cmlid'] . "<br>");}?> </span> </p>
                    </div>
                </div>
                <h2 class="card-title text-left mt-5">Informatie</h2>
                <p class="card-text text-justify">
                  <?php print($info['cmtekst']); ?>
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
                    <a href="#" class="btn btn-outline-primary zhtc-button">Agenda</a>
                    <a href="<?php print($googleLink);?>" class="btn btn-outline-primary zhtc-button">Notulen</a>
                  </div>
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
          <h1 class="text-center mt-4">Commissies</h1>
          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
        </div>
      </div>
			<hr>
			<div class="row">
			<?php
			header('Content-Type: text/html; charset=ISO-8859-1');
			 // NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
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
							<img class="card-img-top" src="images/dispuutfotos/afentikabanner.jpg" alt="" style="width: 20rem;"><br><?php// print($row['comm_zin']);?><?php // NOTE: de commissiezin ?>
            </div>
						<div class="card-footer text-muted"><?php print($row['comm_zin']);?>
							<a href=<?php print("?cm=".$row['commissieID']) ?> class="btn btn-outline-primary float-right zhtc-button">Meer<i class="icon ion-arrow-right-c"></i></a></p>
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

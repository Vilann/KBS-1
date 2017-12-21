<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>ZHTC - commissies</title>
		<?php include 'includes/header.php';
        include 'includes/dbconnect.php';
        if (isset($_GET['cm']) && !(empty($_GET['cm']))) {
            $stmt = $pdo->prepare("SELECT commissievoorzitter as cmvoorzit, commissiebanner as cmbann, commissienaam as cmnaam, c.commissieID as cmID,commissiezin as cmzin, commissietekst as cmtekst, l.voornaam as voornaam, cl.lidID as cmlid, commissieagenda as cmagendaID, commissienotulen as cmnotulenID
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
                $commissieagenda = $info['cmagendaID'];
                $commissienotulen = $info['cmnotulenID'];
                $commissiebanner = $info['cmbann'];
                $voornaam = $info['voornaam'];
            } else {
                print("Werkt niet, of... of het database tabel waar je naar zoekt is leeg");
            } ?>
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
                    <h5 class="card-text text-left my-0"><?php print($info['voornaam']); ?></h5>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5 offset-7">

                    <p class="card-text text-right my-0">Voorzitter: <span class="text-muted"><?php print ucfirst(($info['voornaam'])); ?></span></p>
                    <p class="card-text text-right my-0">Leden:<span class="text-muted">
                    <?php foreach ($info as $commissielid) {
                print($info['cmlid'] . "<br>");
            } ?> </span> </p>
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
                <img src="images/commissiefotos/<?php print($info['cmbann']) ?>" class="img-fluid mx-auto d-block rounded" alt="<?php print($info['cmnaam']); ?>">
                <hr>
                <div class='wrapper text-center'>

<?php if (isset($_SESSION['lid'])) {
                ?>
                  <div class="btn-group mx-auto" role="group" aria-label="...">
										<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['cmagendaID']); ?>" class="btn btn-outline-primary zhtc-button">Agenda</a>
										<a href="https://drive.google.com/embeddedfolderview?id=<?php print($info['cmnotulenID']); ?>" class="btn btn-outline-primary zhtc-button">Notulen</a>
                  </div> <?php
            } ?>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
      <?php
        } else {
            ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Commissies</h1>
<!-- <a href="#">
	 <audio autoplay loop >
  <source src="files/AxelF.wav" type="audio/wav">
</audio>.</a> -->

          <!-- <p class="text-muted"><i class="icon ion-chevron-left"></i> oude commissies</p> -->
        </div>
      </div>
			<hr>
			<div class="row">
			<?php
             // NOTE: hier boven wordt de db verbinding gemaakt en hieronder de relevante data opgehaald
                    $stmt = $pdo->prepare('SELECT commissieID, commissienaam as comm_naam, commissiezin as comm_zin, commissietekst as comm_tekst, commissiebanner as cmbann FROM commissie');
            $stmt->execute();
            $data = $stmt->fetchAll();
            foreach ($data as $row) {
                ?>
        <div class="col-3" >
          <div class="card mb-5 h-100"><?php // NOTE: was class="card mb4" geen idee wat mb inhoud?>
            <div class="card-body p-0"> <?php // NOTE: alles in deze div staat in de kaart?>
							<img class="card-img-top" src="images/commissiefotos/<?php print($row['cmbann'])?>" alt="" ><br><?php// print($row['comm_zin']);?><?php // NOTE: de commissiezin?>
							<h4 class="card-title"><?php print($row['comm_naam'])?></h4> <?php // NOTE: de naam van de commissie?>
              <p class="card-text">
            </div>
						<div class="card-footer text-muted"><?php print($row['comm_zin']); ?>
							<a href=<?php print("?cm=".$row['commissieID']) ?> class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
						</div>
          </div>
        </div>
		<?php
            } ?>
	</div>
</div>
<hr class="mt-3">
	<?php
        } ?>
		<?php include 'includes/footer.php'; ?>
		<script>
		<?php include 'includes/script.js'; ?>
	  </script>
</html>

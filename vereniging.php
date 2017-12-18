<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ZHTC - disputen</title>
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

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
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mt-4">Aankomende activiteiten</h1>
          <p class="text-muted"><i class="icon ion-chevron-left"></i> Vorige activiteiten</p>
        </div>
      </div>
      <hr>
      <?php
        $stmt = $pdo->prepare("SELECT DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitnaam, activiteitlocatie
        FROM activiteit
        WHERE datumvan > CURDATE()
        ORDER by datumvan ASC");
        $stmt->execute();
        $data = $stmt->fetchAll();
        foreach($data as $row) {
      ?>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title"><?php print($row['activiteitnaam']);?></h4>
              <p class="card-text"><i class="icon ion-calendar"></i> <?php print($row['datumvanaf']);?> <i class="icon ion-clock"></i> <?php print($row['tijdvanaf']);?>
              <a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
              <p class="card-text"><i class="icon ion-location"></i> <?php print($row['activiteitlocatie']);?></p>
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
  </body>
  <script>
  <?php include 'includes/script.js'; ?>
  </script>
</html>

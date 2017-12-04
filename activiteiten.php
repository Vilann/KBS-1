<?php
include('includes/beveiliging.php');
beveilig_nietlid();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - activiteiten</title>
    <?php include 'includes/header.php';
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Activiteiten</h1>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title">Bierweek</h4>
              <p class="card-text"><i class="icon ion-calendar"></i> 23-12-2017 <i class="icon ion-clock"></i> 12:00
              <a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
            </div>
            <div class="card-footer text-muted">
              over 10 dagen
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title">Max slapen week</h4>
              <p class="card-text"><i class="icon ion-calendar"></i> 23-12-2017 <i class="icon ion-clock"></i> 12:00
              <a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
            </div>
            <div class="card-footer text-muted">
              over 10 dagen
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title">Kai is dronken week</h4>
              <p class="card-text"><i class="icon ion-calendar"></i> 23-12-2017 <i class="icon ion-clock"></i> 12:00
              <a href="#" class="btn btn-outline-primary float-right zhtc-button">Meer <i class="icon ion-arrow-right-c"></i></a></p>
            </div>
            <div class="card-footer text-muted">
              over 10 dagen
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script>
  <?php include 'includes/script.js'; ?>
  </script>
</html>

<?php

include "includes/beveiliging.php";
beveilig_nietlid();

include 'includes/dbconnect.php';

    $stmt = $pdo->prepare("SELECT voornaam, tussenvoegsel, achternaam, geboortedatum, geslacht, adres, woonplaats, postcode, emailadres, noodnummer, aanmaakdatum FROM lid WHERE lidID = ?");
    $stmt->execute(array($_SESSION['lid']));

    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount()) {
        $vollenaam = $info['voornaam'] . " " . $info['tussenvoegsel'] . " " . $info['achternaam'];
    } else {
        print("Werkt niet");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - <?php print($vollenaam); ?></title>
        <?php include 'includes/header.php';
        header('Content-Type: text/html; charset=ISO-8859-1');?>

      <div class="container-fluid">
        <div class="row name_banner">
          <div class="col">
            <div class="media">
              <img class="align-self-center mr-3" src="http://via.placeholder.com/150x150" alt="Generic placeholder image">
              <div class="media-body vcenter">
                <h5 class="mt-0"><?php print($vollenaam) ?></h5>
                <p class="mb-0">Lid sinds: <span class="text-muted"><?php print(date("d-m-Y", strtotime($info['aanmaakdatum'])));?></span></p>
                <p class="mb-0 text-muted">banaanlid</p>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-7">
              <h3>
                Persoonlijke Gegevens
              </h3>
              <form action="verwerk.php" method="post">
                <div class="form-group row">
                    <label for="voornaam" class="col-sm-3 col-form-label">Naam:</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-5 px-1">
                          <input type="text" id="voornaam" class="form-control" value='<?php print(ucfirst($info['voornaam'])); ?>'name="voornaam" placeholder="Voornaam">
                        </div>
                        <div class="col-2 px-1">
                          <input type="text" class="form-control" value='<?php print($info['tussenvoegsel']); ?>' name="tussenvoegsel" placeholder="Tussenvoegsel">
                        </div>
                        <div class="col-5 px-1">
                          <input type="text" class="form-control" value='<?php print($info['achternaam']); ?>' name="achternaam" placeholder="Achternaam">
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="geboortedatum" class="col-sm-3 col-form-label">Geboortedatum:</label>
                    <div class="col-sm-9 px-0">
                      <input id="geboortedatum" type="date" class="form-control" name="geboortedatum" value='<?php print(date("d-m-Y", strtotime($info['geboortedatum']))); ?>'>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="geslacht" class="col-sm-3 col-form-label">Geslacht:</label>
                    <div class="col-sm-9 px-0">
                      <select id="geslacht" class="form-control" name="geslacht">
                        <option value="man" <?php if ($info['geslacht'] == 'man') {
    print("selected");
} ?>>Man</option>
                        <option value="vrouw" <?php if ($info['geslacht'] == 'vrouw') {
    print("selected");
} ?>>Vrouw</option>
                        <option value="anders" <?php if ($info['geslacht'] == 'anders') {
    print("selected");
} ?>>Geen van bovenstaande</option>
                      </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label for="adres" class="col-sm-3 col-form-label">Locatie:</label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-12 px-0">
                        <input id="adres" type="text" class="form-control" value='<?php print($info['adres']); ?>' name="adres" placeholder="Adres">
                      </div>
                    </div>
                  </div>
                  <label for="woonplaats" class="col-sm-3 col-form-label">Plaatsnaam en postcode</label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-8 px-0">
                        <input id="woonplaats" type="text" class="form-control" value='<?php print($info['woonplaats']); ?>' name="woonplaats" placeholder="Woonplaats">
                      </div>
                      <div class="col-4 px-0">
                        <input type="text" class="form-control" value='<?php print($info['postcode']); ?>' name="postcode" placeholder="Postcode">
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Eigen emailadres:</label>
                    <div class="col-sm-9 px-0">
                      <input type="text" class="form-control" id="email" value='<?php print($info['emailadres']); ?>' name="emailadres" placeholder="email@voorbeeld.nl">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="noodnummer" class="col-sm-3 col-form-label">Noodnummer:</label>
                    <div class="col-sm-9 px-0">
                      <input id="noodnummer" type="text" class="form-control" value='<?php print($info['noodnummer']); ?>' name="noodnummer" placeholder="0612345678">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary" name="infoupdate" value="infoupdate">Aanpassen</button>
              </form>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-5">
              <h3 id="dispuut">
                Dispuut
              </h3>
              <?php
              $stmt = $pdo->prepare("SELECT dispuutnaam, CONCAT(IFNULL(l2.voornaam,''),' ',IFNULL(l2.tussenvoegsel,''),' ',IFNULL(l2.achternaam,'')) AS naam, dispuutvoorzitter, dispuutzin, dispuuttekst FROM dispuut d
              JOIN dispuutlid dl ON d.dispuutid = dl.dispuutID
              JOIN lid l ON dl.lidID = l.lidID
              JOIN lid l2 ON d.dispuutvoorzitter = l2.lidID
              WHERE dl.lidID = ?");
              $stmt->execute(array($_SESSION['lid']));

              $info = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($stmt->rowCount()) {
                //
               ?>
              <div class="card">
                <h4 class="card-header"><?php print($info['dispuutnaam']);?></h4>
                <div class="card-body">
                  <h4 class="card-title"><?php print($info['dispuutzin']);?></h4>
                  <p class="card-text text-justify"><?php $pos=strpos($info['dispuuttekst'], ' ', 250);
                  print(substr($info['dispuuttekst'],0,$pos )."..."); ?></p>
                  <p class="card-text">Voorzitter: <span class="text-muted"><?php print(ucwords($info['naam']));?></span></p>
                  <a href="#" class="btn btn-outline-primary">Naar info pagina</a>
                  <?php
                  if($info['dispuutvoorzitter'] == $_SESSION['lid']){
                  ?>
                    <a href="#" class="btn btn-outline-primary">Bewerken</a>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <?php
            } else {
              print("Geen dispuut gevonden.");
            }
            ?>
          </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <hr>
            <h3 id="commissies">
              Commissies
            <small class="text-muted">Van de hier onderstaande commissies ben je lid.</small>
            </h3>
          </div>
        </div>
          <div class="row">
            <div class="col">
              <div class="card-group">
                <?php
                  $stmt = $pdo->prepare("SELECT commissienaam, CONCAT(IFNULL(l2.voornaam,''),' ',IFNULL(l2.tussenvoegsel,''),' ',IFNULL(l2.achternaam,'')) AS naam, commissievoorzitter, commissiezin, commissietekst FROM commissie c
                  JOIN commissielid cl ON c.commissieID = cl.commissieID
                  JOIN lid l ON cl.lidID = l.lidID
                  JOIN lid l2 ON c.commissievoorzitter = l2.lidID
                  WHERE cl.lidID = ?");
                  $stmt->execute(array($_SESSION['lid']));
                  $data = $stmt->fetchAll();
                  foreach($data as $row) {
                      //$id = $row['id'];
                      //$content = $row['content'];
                ?>
                <div class="card">
                  <h4 class="card-header"><?php print($row['commissienaam']);?></h4>
                  <div class="card-body">
                    <h4 class="card-title"><?php print($row['commissiezin']);?></h4>
                    <p class="card-text text-justify"><?php $pos=strpos($row['commissietekst'], ' ', 250);
                    print(substr($row['commissietekst'],0,$pos )."..."); ?></p>
                    <p class="card-text">Voorzitter: <span class="text-muted"><?php print(ucwords($row['naam']));?></span></p>
                    <a href="#" class="btn btn-outline-primary">commissie pagina</a>
                    <?php
                    if($row['commissievoorzitter'] == $_SESSION['lid']){
                    ?>
                      <a href="#" class="btn btn-outline-primary">Bewerken</a>
                    <?php
                    }
                    ?>
                  </div>
                </div>
                <?php
                }
                ?>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>

<?php
session_start();
  include '../../includes/dbconnect.php';
  include '../alert.php';
  error_reporting(E_ALL & ~E_NOTICE);
  if(isset($_SESSION['admin']['Commissie']) && !isset($_SESSION['admin']['Beheer'])){
    $stmt = $pdo->prepare("SELECT commissieid FROM commissie WHERE commissievoorzitter = ?");
    $stmt->execute(array($_SESSION['lid']));
    $info = $stmt->fetchAll();
    $ids = "";
    foreach($data as $row) {
      $ids .= $row['commissieid'];
    }
    $queryaddon = "
    WHERE c.commissieID IN($ids)";
  }else{
    $queryaddon = "";
  }
  if(isset($_GET['delete']) && !(empty($_GET['delete']))){
    if($_GET['delete'] == "yes"){
      $id = $_GET['id'];
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if($_GET['choice'] == "activiteit"){
        $stmt2 = $pdo->prepare("DELETE FROM activiteit
          WHERE activiteitid=?");
        $stmt2->execute(array($id));
        if (!$stmt) {
          echo "\nPDO::errorInfo():\n";
          print_r($pdo->errorInfo());
        }
      }else{
        //
      }
    }
    $_SESSION['error'] = "U heeft succesvol een activiteit verwijderd.";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorAdd'] = "succes!";
    header('Location: activiteiten');
  }
  if(isset($_POST['addActiviteit']) && !(empty($_POST['addActiviteit']))){
    if (isset($_POST['naam']) && isset($_POST['vanaf']) && isset($_POST['tot']) && isset($_POST['vanaftijd']) && isset($_POST['tottijd']) && isset($_POST['locatie']) && isset($_POST['uitleg'])) {
      $stmt = $pdo->prepare("INSERT INTO activiteit(activiteitnaam, datumvan, datumtot, activiteitlocatie, activiteitinfo, lidID)
        VALUES(?, ?, ?, ?, ?, ?)");
      $stmt->execute(array($_POST['naam'],($_POST['vanaf']." ".$_POST['vanaftijd']),($_POST['tot']." ".$_POST['tottijd']),$_POST['locatie'],$_POST['uitleg'], $_SESSION['lid']));
      if (!$stmt) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
      }
      $_SESSION['error'] = "U heeft succesvol een activiteit toegevoegd";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }else{
      $_SESSION['error'] = "U heeft niet alles ingevuld";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorAdd'] = "Let op!";
      //error niet alles ingevuld
    }
    header('Location: activiteiten');
  }

  if(isset($_POST['editActiviteit']) && !(empty($_POST['editActiviteit']))){
    if (isset($_POST['naam']) && isset($_POST['vanaf']) && isset($_POST['tot']) && isset($_POST['vanaftijd']) && isset($_POST['tottijd']) && isset($_POST['locatie']) && isset($_POST['uitleg'])) {
      $stmt = $pdo->prepare("UPDATE activiteit SET activiteitnaam=?, datumvan=?, datumtot=?, activiteitlocatie=?, activiteitinfo=?
        WHERE activiteitid = ?");
      $stmt->execute(array($_POST['naam'],($_POST['vanaf']." ".$_POST['vanaftijd']),($_POST['tot']." ".$_POST['tottijd']),$_POST['locatie'],$_POST['uitleg'],$_POST['id']));
      $_SESSION['error'] = "U heeft succesvol een activiteit aangepast";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }else{
      $_SESSION['error'] = "U heeft niet alles ingevuld";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorAdd'] = "Let op!";
      //error niet alles ingevuld
    }
    header('Location: activiteiten');
  }
  if(isset($_SESSION['error'])){
    print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
    unset($_SESSION['error']);
  }
?>
<html lang="en">
      <?php include '../header.php'; ?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="activiteiten">ZHTC Activiteiten<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <div class="row">
              <div class="col-md-11">
                <p class="text-muted mb-1">
                  Hieronder vind je alle activiteiten. Deze kun je aanpassen en verwijderen.
                </p>
                <!-- Knop die de modal inlaadt voor het toevoegen van een nieuwe poll -->
                  <button type="button" class="btn btn-outline-primary zhtc-button" data-toggle="modal" data-target="#addActiviteit">Nieuwe activiteit toevoegen</button>
              </div>
            </div>
            <br>
            <?php
            $stmt = $pdo->prepare("SELECT c.commissieID, c.commissievoorzitter, a.lidID, activiteitinfo, activiteitid, activiteitinfo, activiteitnaam, DATE_FORMAT(datumvan, '%d-%m-%Y') as datumvanaf,
            DATE_FORMAT(datumvan, '%H:%i') as tijdvanaf,
            DATE_FORMAT(datumtot, '%d-%m-%Y') as datumtot,
            DATE_FORMAT(datumtot, '%H:%i') as tijdtot, activiteitlocatie
            FROM activiteit a
            LEFT JOIN commissie c ON a.activiteitcommissie = c.commissieID
            $queryaddon
            ORDER by activiteitnaam ASC");
            $stmt->execute();
            $count = $stmt->rowCount();
            $resultsPer = 20;
            $pages = ceil($count/$resultsPer);
            if(isset($_GET['p']) && !empty($_GET['p'])){
              $pageNr = $_GET['p'];
            }else{
              $pageNr = 1;
            }
            if(isset($_GET['ord']) && !empty($_GET['ord'])){
              $order = $_GET['ord'];
            }else{
              $order = "datumvan";
            }
            //check of hij op de laatste of op pagina 1 zit
            function setPagination($pages, $pageNr){
              if($pages == 1 && $pages == $pageNr){
                return(array("disabled","disabled"));
              }
              if($pageNr == $pages){
                return(array("","disabled"));
              }elseif($pageNr == 1){
                return(array("disabled",""));
              }else{
                return(array("",""));
              }
            }
            $page_status = setPagination($pages, $pageNr);
            $page_status_left = $page_status[0];
            $page_status_right = $page_status[1];
            $startNr = ($resultsPer*$pageNr)-$resultsPer;
            $stmt = $pdo->prepare("SELECT c.commissieID, c.commissievoorzitter, a.lidID, activiteitinfo, activiteitid, activiteitinfo, activiteitnaam, DATE_FORMAT(datumvan, '%d-%m-%Y') as datumvanaf,
            DATE_FORMAT(datumvan, '%H:%i') as tijdvanaf,
            DATE_FORMAT(datumtot, '%d-%m-%Y') as datumtot,
            DATE_FORMAT(datumtot, '%H:%i') as tijdtot, activiteitlocatie
            FROM activiteit a
            LEFT JOIN commissie c ON a.activiteitcommissie = c.commissieID
            $queryaddon
            ORDER by $order ASC
            LIMIT $startNr, $resultsPer");
            $stmt->execute();
            $data = $stmt->fetchAll();
             ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php print($page_status_left)?>">
                  <a class="page-link icon-fix" href="?p=<?php print($pageNr-1); ?>" aria-label="Previous">
                    <span class="icon ion-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <?php
                for($i = 1; $i <= $pages; $i++){
                  if($i == $pageNr){
                    print("<li class='page-item active'><a class='page-link zhtc-bg zhtc-brd' href='?p=$i'> $i </a></li>");
                  }else{
                    print("<li class='page-item'><a class='page-link' href='?p=$i'> $i </a></li>");
                  }
                }
                ?>
                <li class="page-item <?php print($page_status_right)?>">
                  <a class="page-link icon-fix" href="?p=<?php print($pageNr+1); ?>" aria-label="Next">
                    <span class="icon ion-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
            <table class="table table-hover">
              <thead class="thead-zhtc">
                <tr id="orderBy" class="<?php print($order);?>">
                  <th scope="col">Acties</th>
                  <th id="activiteitnaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=activiteitnaam">Naam</a></th>
                  <th id="activiteitlocatie" scope="col"><a href="?p=<?php print($pageNr)?>&ord=activiteitlocatie">Locatie</a></th>
                  <th id="datumvan" scope="col"><a href="?p=<?php print($pageNr)?>&ord=datumvan">Vanaf</a></th>
                  <th id="datumtot" scope="col"><a href="?p=<?php print($pageNr)?>&ord=datumtot">Tot</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($data as $row) {
                  $datevan = date_create($row['datumvanaf']);
                  $datetot = date_create($row['datumtot']);
                ?>
                <tr class="thisId activiteit" id='<?php print($row['activiteitid']);?>'>
                  <td>
                    <button class="btn btn-xs delModal activiteit" data-id="<?php print($row['activiteitnaam']);?>" data-toggle="modal" data-target="#verwijderen"><i class="icon ion-trash-b"></i></button>
                    <button class="btn btn-warning btn-xs editmodal activiteit" data-id="" data-toggle="modal" data-target="#editActiviteit<?php print($row['activiteitid']);?>"><i class="icon ion-edit"></i></button>
                  </td>
                  <td><span class="text-muted"><?php print($row['activiteitnaam']);?></span></td>
                  <td><span class="text-muted"><?php print($row['activiteitlocatie']);?></span></td>
                  <td><span class="text-muted"><?php print($row['datumvanaf']); ?> <span class="badge badge-primary zhtc-bg "><i class="icon ion-clock"></i><?php print($row['tijdvanaf']); ?></span></span></td>
                  <td><span class="text-muted"><?php print($row['datumtot']); ?> <span class="badge badge-primary zhtc-bg "><i class="icon ion-clock"></i><?php print($row['tijdtot']); ?></span></span></td>
                </tr>
                <!-- Modal om overige poll gegevens in te laden -->
                <div class="modal fade bd-example-modal-lg editActiviteit" id="editActiviteit<?php print($row['activiteitid']);?>" tabindex="-1" role="dialog" aria-labelledby="editActiviteitlabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addActiviteitlabel">Activiteit aanpassen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p class="text-muted editActiviteitTekst" style="display: none;">
                          U kunt nu aanpassingen maken aan deze activiteit
                        </p>
                        <form id="getErrormess" action="activiteiten" method="post">
                              <div class="form-group row">
                                  <label for="vraag" class="col-sm-3 col-form-label">Naam:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <input type="text" class="form-control M_activiteitnaam" name="naam" placeholder="Bierweek" required readonly value="<?php print($row['activiteitnaam']);?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="keuze" class="col-sm-3 col-form-label">Vanaf:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <div class="input-group mb-2 mb-sm-0">
                                      <input type="date" class="form-control col-9 M_activiteitdatumvan" name="vanaf" value="<?php print(date_format($datevan, 'Y-m-d'));?>" min=<?php print('"' . date('Y-m-d', strtotime("+1 day")) . '"'); ?> required readonly>
                                      <input type="time" class="form-control col-3 M_activiteittijdvan" name="vanaftijd" value="<?php print($row['tijdvanaf']);?>" min=<?php print('"' . date('Y-m-d', strtotime("+2 day")) . '"'); ?> required readonly>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="keuze" class="col-sm-3 col-form-label">Tot:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <div class="input-group mb-2 mb-sm-0">
                                      <input type="date" class="form-control col-9 M_activiteitdatumtot" name="tot" value="<?php print(date_format($datetot, 'Y-m-d'));?>" required readonly>
                                      <input type="time" class="form-control col-3 M_activiteittijdtot" name="tottijd" value="<?php print($row['tijdtot']);?>" required readonly>
                                    </div>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="vraag" class="col-sm-3 col-form-label">Locatie:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <input type="text" class="form-control M_activiteitlocatie" name="locatie" placeholder="Windesheim" value="<?php print($row['activiteitlocatie']);?>" required readonly>
                                  </div>
                              </div>
                              <div class="form-group row">

                                  <label for="exampleFormControlTextarea1" class="col-sm-3 col-form-label">Uitleg:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <textarea class="form-control M_activiteitinfo" name="uitleg" rows="4" readonly><?php print($row['activiteitinfo']);?></textarea>
                                  </div>
                              </div>
                              <input type="hidden" name="id" value="<?php print($row['activiteitid']);?>">
                      </div>
                      <div class="modal-footer">
                        <input class="btn btn-outline-primary editKnop" type="hidden" name="editActiviteit" value="Aanpassen">
                        <input type="button" class="btn btn-outline-dark toggleEdit" value="Edit modus">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                }
                ?>
              </tbody>
            </table>
        </main>
    </div>
</div>
<!-- Modals -->
<div class="modal fade" id="verwijderen" tabindex="-1" role="dialog" aria-labelledby="verwijderenlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verwijderenlabel">Weet u zeker dat u <span class="deleteName"></span> wilt verwijderen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small class="text-muted">Hou er rekening mee dat zodra u <span class="deleteName"></span> verwijderd alle leden die hier in staan uit geschreven worden.</small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal om overige poll gegevens in te laden -->
<div class="modal fade bd-example-modal-lg" id="addActiviteit" tabindex="-1" role="dialog" aria-labelledby="addActiviteitlabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addActiviteitlabel">Activiteit toevoegen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="getErrormess" action="activiteiten" method="post">
              <div class="form-group row">
                  <label for="vraag" class="col-sm-3 col-form-label">Naam:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <input type="text" class="form-control" name="naam" placeholder="Bierweek" required>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="keuze" class="col-sm-3 col-form-label">Vanaf:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <div class="input-group mb-2 mb-sm-0">
                      <input type="date" class="form-control col-9" name="vanaf" value="" min=<?php print('"' . date('Y-m-d', strtotime("+1 day")) . '"'); ?> required>
                      <input type="time" class="form-control col-3" name="vanaftijd" value="" min=<?php print('"' . date('Y-m-d', strtotime("+2 day")) . '"'); ?> required>
                    </div>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="keuze" class="col-sm-3 col-form-label">Tot:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <div class="input-group mb-2 mb-sm-0">
                      <input type="date" class="form-control col-9" name="tot" value="" required>
                      <input type="time" class="form-control col-3" name="tottijd" value="" required>
                    </div>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="vraag" class="col-sm-3 col-form-label">Locatie:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <input type="text" class="form-control" name="locatie" placeholder="Windesheim" required>
                  </div>
              </div>
              <div class="form-group row">

                  <label for="exampleFormControlTextarea1" class="col-sm-3 col-form-label">Uitleg:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="uitleg" rows="4"></textarea>
                  </div>
              </div>
      </div>
      <div class="modal-footer">
        <input class="btn btn-outline-primary" type="submit" name="addActiviteit" value="Toevoegen">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>

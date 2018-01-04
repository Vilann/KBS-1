<?php
  session_start();
  //includes
  include '../../includes/dbconnect.php'; //connectie met de database
  include '../alert.php'; //include alerts
  error_reporting(E_ALL & ~E_NOTICE); //geen notices displayen
  //De functie hieronder kijkt welke commissies horen bij de ingelogde voorzitter en slaat deze op als $ids
  if(isset($_SESSION['admin']['Commissie']) && !isset($_SESSION['admin']['Beheer'])){
    $stmt = $pdo->prepare("SELECT commissieid FROM commissie WHERE commissievoorzitter = ?");
    $stmt->execute(array($_SESSION['lid']));
    $info = $stmt->fetchAll();
    $ids = "";
    //voeg alle ids toe aan string met een loop
    foreach($data as $row) {
      $ids .= $row['commissieid'];
    }
    //voeg de string hieronder toe aan de hooftquery
    $queryaddon = "
    WHERE c.commissieID IN($ids)";
  }else{
    $queryaddon = "";
  }
  //Check of de delete fucntie wordt aangeroepen
  if(isset($_GET['delete']) && !(empty($_GET['delete']))){
    //als delete gelijk is aan yes en choice is activiteit delete die activiteit
    if($_GET['delete'] == "yes"){
      $id = $_GET['id'];
      if($_GET['choice'] == "activiteit"){
        $stmt2 = $pdo->prepare("DELETE FROM activiteit
          WHERE activiteitid=?");
        $stmt2->execute(array($id));
      }else{
        //
      }
    }
    //zet een messege
    $_SESSION['error'] = "U heeft succesvol een activiteit verwijderd.";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorAdd'] = "succes!";
    header('Location: activiteiten');
  }

  //stuk code voor het toevoegen van een activiteit
  if(isset($_POST['addActiviteit']) && !(empty($_POST['addActiviteit']))){
    //kijk of alle gegevens in het/de /idk form zijn ingevuld
    if (isset($_POST['naam']) && isset($_POST['vanaf']) && isset($_POST['tot']) && isset($_POST['vanaftijd']) && isset($_POST['tottijd']) && isset($_POST['locatie']) && isset($_POST['uitleg'])) {
      //controle of de datum tot eerder is dan de datum vanaf als dat zo is geeft hij een warning
      if(($_POST['tot'] < $_POST['vanaf'])){
        $_SESSION['error'] = "Er is iets fout gegaan betreft de gekozen datum en/of tijd.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: activiteiten');
        exit;
      }
      //controle of de datum tot eerder is dan de datum vanaf als dat zo is geeft hij een warning
      if(($_POST['tot'] == $_POST['vanaf']) && ($_POST['tottijd'] < $_POST['vanaftijd'])){
        $_SESSION['error'] = "Er is iets fout gegaan betreft de gekozen datum en/of tijd.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: activiteiten');
        exit;
      }
      //als hij langs de controles is gegaan voeg de activiteit toe
      $stmt = $pdo->prepare("INSERT INTO activiteit(activiteitnaam, datumvan, datumtot, activiteitlocatie, activiteitinfo, lidID)
        VALUES(?, ?, ?, ?, ?, ?)");
      $stmt->execute(array($_POST['naam'],($_POST['vanaf']." ".$_POST['vanaftijd']),($_POST['tot']." ".$_POST['tottijd']),$_POST['locatie'],$_POST['uitleg'], $_SESSION['lid']));

      //melding voor als alles goed is gegaan
      $_SESSION['error'] = "U heeft succesvol een activiteit toegevoegd";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }else{
      //zet de melding voor als je niet alles hebt ingevuld
      $_SESSION['error'] = "U heeft niet alles ingevuld";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorAdd'] = "Let op!";
      //error niet alles ingevuld
    }
    //terug naar activiteitn zonder de post nadat alles met succes / of errors voltooid is
    header('Location: activiteiten');
  }

  //stuk code voor het aanpassen van activiteiten
  if(isset($_POST['editActiviteit']) && !(empty($_POST['editActiviteit']))){
    //kijk weer of alles van de/het form is ingevuld
    if (isset($_POST['naam']) && isset($_POST['vanaf']) && isset($_POST['tot']) && isset($_POST['vanaftijd']) && isset($_POST['tottijd']) && isset($_POST['locatie']) && isset($_POST['uitleg'])) {
      //controle of de datum tot eerder is dan de datum vanaf als dat zo is geeft hij een warning
      if(($_POST['tot'] < $_POST['vanaf'])){
        $_SESSION['error'] = "Er is iets fout gegaan betreft de datum en/of tijd.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: activiteiten');
        exit;
      }
      //controle of de datum tot eerder is dan de datum vanaf als dat zo is geeft hij een warning
      if(($_POST['tot'] == $_POST['vanaf']) && ($_POST['tottijd'] < $_POST['vanaftijd'])){
        $_SESSION['error'] = "Er is iets fout gegaan betreft de datum en/of tijd.";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: activiteiten');
        exit;
      }
      //voer een update query uit
      $stmt = $pdo->prepare("UPDATE activiteit SET activiteitnaam=?, datumvan=?, datumtot=?, activiteitlocatie=?, activiteitinfo=?
        WHERE activiteitid = ?");
      $stmt->execute(array($_POST['naam'],($_POST['vanaf']." ".$_POST['vanaftijd']),($_POST['tot']." ".$_POST['tottijd']),$_POST['locatie'],$_POST['uitleg'],$_POST['id']));
      //warning als alles gelukt is
      $_SESSION['error'] = "U heeft succesvol een activiteit aangepast";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }else{
      //error niet alles ingevuld
      $_SESSION['error'] = "U heeft niet alles ingevuld";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorAdd'] = "Let op!";
    }
    //terug naar activiteitn zonder de post nadat alles met succes / of errors voltooid is
    header('Location: activiteiten');
  }
  //kijk of er errors gezet zijn zo ja voer dan de createerror functie uit (wordt geladen via alert.php) met de opgeslagen parameters
  if(isset($_SESSION['error'])){
    print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
    //unset de error zodat hij niet vaker displayed
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
            //selecteer alle activiteiten die of van een commissievoorzitter zijn of alle activiteint als het gaat om een beheerder
            $stmt = $pdo->prepare("SELECT c.commissieID, c.commissievoorzitter, a.lidID, activiteitinfo, activiteitid, activiteitinfo, activiteitnaam, DATE_FORMAT(datumvan, '%d-%m-%Y') as datumvanaf,
            DATE_FORMAT(datumvan, '%H:%i') as tijdvanaf,
            DATE_FORMAT(datumtot, '%d-%m-%Y') as datumtot,
            DATE_FORMAT(datumtot, '%H:%i') as tijdtot, activiteitlocatie
            FROM activiteit a
            LEFT JOIN commissie c ON a.activiteitcommissie = c.commissieID
            $queryaddon
            ORDER by activiteitnaam ASC");
            $stmt->execute();
            //kijk hoeveel resultaten hij heeft
            $count = $stmt->rowCount();
            //zet het aantal resultaten per pagina
            $resultsPer = 20;
            //bereken het aantal pagina's
            $pages = ceil($count/$resultsPer);
            //als er in de url een ander pagina nummer staat zet dan die neer als pageNr anders gewoon paginaNr 1
            if(isset($_GET['p']) && !empty($_GET['p'])){
              $pageNr = $_GET['p'];
            }else{
              $pageNr = 1;
            }
            //als er in de url een andere sorteer staat aangegeven zie ord(order) dan zet die in de variable anders datumvan als de standaard
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
            //kijk welke onderdelen hij moet disabelen
            $page_status = setPagination($pages, $pageNr);
            $page_status_left = $page_status[0];
            $page_status_right = $page_status[1];
            //bereken bij hoeveel resultaten hij moet beginnen op basis van welke pagina die is
            $startNr = ($resultsPer*$pageNr)-$resultsPer;
            //selecteer alle activiteiten die of van een commissievoorzitter zijn of alle activiteint als het gaat om een beheerder
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
                //voeg pagination toe op basis van hoeveel paginas er zijn
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
            <div class="table-responsive">
            <table class="table table-hover">
              <!-- Create table waar de activiteiten in staan -->
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
          </div>
        </main>
    </div>
</div>
<!-- Modals -->
<!-- Modal voor het verwijderen van een activiteit -->

<div class="modal fade" id="verwijderen" tabindex="-1" role="dialog" aria-labelledby="verwijderenlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verwijderenlabel">Weet u zeker dat u "<span class="deleteName"></span>" wilt verwijderen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small class="text-muted">Alle opgeslagen gegevens die wat met deze activiteit te maken hebben zullen verloren gaan.</small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal voor het toevoegen van een activiteit -->
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
                      <input type="time" class="form-control col-3" name="vanaftijd" value="" required>
                    </div>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="keuze" class="col-sm-3 col-form-label">Tot:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <div class="input-group mb-2 mb-sm-0">
                      <input type="date" class="form-control col-9" name="tot" value="" min=<?php print('"' . date('Y-m-d', strtotime("+1 day")) . '"'); ?> required>
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

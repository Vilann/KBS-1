<?php
  /*
  ##Commissieleden pagina##
  Op deze pagina kun je:
  -alle leden van jouw commissie zien
  -leden uit jouw commissie verwijderen
  -nieuwe leden toevoegen aan jouw commissie
  -nieuwe voorzitter aanwijzen
   */
  session_start();
  //includes
  include '../../includes/dbconnect.php'; //connectie met de database
  include '../alert.php'; //include alerts

  //Met de code hieronder wordt een lid uit de commissie verwijderd
  if(isset($_GET['delete']) && !(empty($_GET['delete']))){
    if($_GET['delete'] == "yes"){
      $id = $_GET['id'];
      $Sid = $_GET['ots'];
      if($_GET['choice'] == "commissie"){
        //verwijder de het lid uit de commissie
        $stmt2 = $pdo->prepare("DELETE FROM commissielid
          WHERE lidID=?
          AND commissieID = ?
          ");
        $stmt2->execute(array($id,$Sid));
      }else{
        //
      }
    }
    //zet succes melding
    $_SESSION['error'] = "U heeft succesvol een lid verwijderd uit uw commissie";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorAdd'] = "succes!";
    header('Location: commissieleden');
  }

  //de code hieronder is voor het toevoegen van nieuwe leden en en verwisselen van voorzitter
  //kijk of er een keuze (voorzitter/of lid) is gemaakt en gezet
  if(isset($_GET['choice']) && !(empty($_GET['choice']))){
    if(isset($_GET['leden']) && isset($_GET['id'])){
      //zet alle gekozen leden in een array
      $ledenArray = explode(",", $_GET['leden']);
      //kijk of er daadwerkelijk een lid is gekozen
      if(isset($_GET['leden']) && !(empty($_GET['leden']))){
        //goed
      }else{
        //als er niet een lid is gekozen geef dan per keuze een melding weer
        if($_GET['as'] == "voorzitter"){
          $_SESSION['error'] = "U heeft geen lid gekozen om als nieuwe voorzitter op te stellen.";
        }else{
          $_SESSION['error'] = "U heeft geen leden gekozen om aan u commissie toe te voegen.";
        }
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!!";
        header('Location: commissieleden');
        exit;
      }
          //define id als variabele
          $id = $_GET['id'];
          //check of de keuze voorzitter is
          if($_GET['as'] == "voorzitter"){
            //selecteer de huidige commissievoorzitter
            $stmt = $pdo->prepare("SELECT commissievoorzitter FROM commissie
            WHERE commissieID = ?");
            $stmt -> execute(array($id));
            $cVoorzitter = $stmt -> fetch(PDO::FETCH_ASSOC);
            //delete de huidige voorzitter uit commissielid
            $stmt2 = $pdo->prepare("DELETE FROM commissielid
              WHERE commissieID=?
              AND lidID = ?");
            $stmt2->execute(array($id,$cVoorzitter['commissievoorzitter']));
            //update de commissievoorzitter naar de nieuwe voorzitter
            $stmt = $pdo->prepare("UPDATE commissie SET commissievoorzitter=?
              WHERE commissieID = ?");
            $stmt->execute(array($ledenArray[0],$id));
            //zet de nieuwe voorzitter in commissielid bij de commissie waar hij zouist de voorzxitter van is geworden
            $stmt = $pdo->prepare("INSERT INTO commissielid(commissieID, lidID)
              VALUES(?, ?)");
            $stmt->execute(array($id,$ledenArray[0]));
            //als de verwisseling is gedaan zorg er voor dat de huidige voorzitter uitlogt zodat hij daar verder niks meer mee kan doen
            header('Location: ../../loguit');
          }else{
            //code voor als de keuze is om nieuwe leden toe te voegen
            //ga met een loop als alle leden die gekozen zijn
            for($i = 0; $i <= count($ledenArray); $i++){
              //en zet deze in commissieleden bij de juiste commissie
              $stmt = $pdo->prepare("INSERT INTO commissielid(commissieid, lidid)
                VALUES(?, ?)");
              $stmt->execute(array($id,$ledenArray[$i]));
            }
            //succesmelding zetten
            $_SESSION['error'] = "U heeft succesvol een lid toegevoegd uit uw commissie";
            $_SESSION['errorType'] = "success";
            $_SESSION['errorAdd'] = "succes!";
          }
    }
    header('Location: commissieleden');
  }

  //notices uit zetten voor reasons unknown
  error_reporting(E_ALL & ~E_NOTICE);
  session_start();

  //selecteer de commissieId van de ingelogde commissievoorzitter
  $stmt = $pdo->prepare("SELECT commissieid FROM commissie WHERE commissievoorzitter = ?");
  $stmt->execute(array($_SESSION['lid']));

  $info = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($stmt->rowCount()) {
      //
  } else {
      print("Werkt niet");
  }
  //
  //kijk of er errors gezet zijn zo ja voer dan de createerror functie uit (wordt geladen via alert.php) met de opgeslagen parameters
  if(isset($_SESSION['error'])){
    print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
    //unset de error zodat hij niet vaker displayed
    unset($_SESSION['error']);
  }
?>
<html lang="en">
      <?php include '../header.php';
      ?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="commissieleden">ZHTC CommissieLeden<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <div class="row">
              <div class="col-md-11">
                <!-- knoppen voor 1:toevoegen nieuwe voorziiter en 2:toevoegen leden -->
                  <button type="button" class="btn btn-outline-primary zhtc-button" onclick="location.href='toevoegenlid?choice=commissie&id=<?php print($info['commissieid']);?>&as=voorzitter'">Nieuwe voorzitter aanwijzen</button>
                  <button type="button" class="btn btn-outline-primary zhtc-button" onclick="location.href='toevoegenlid?choice=commissie&id=<?php print($info['commissieid']);?>&as=lid'">Nieuwe leden toevoegen</button>
              </div>
            </div>
            <hr>
            <?php
            //query voor het kijken hoeveel resulaten de query opleverd
            $stmt = $pdo->prepare("SELECT * FROM commissielid c
            JOIN lid l ON c.lidID = l.lidID
            WHERE commissieid = ?");
            $stmt->execute(array($info['commissieid']));
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
              $order = "voornaam";
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
            //selecteer alle commissieleden die van een commissievoorzitter
            $stmt = $pdo->prepare("SELECT * FROM commissielid cl
            JOIN lid l ON cl.lidID = l.lidID
            JOIN commissie c ON cl.commissieID = c.commissieID
            WHERE c.commissieid = ?
            ORDER by $order ASC
            LIMIT $startNr, $resultsPer");
            $stmt->execute(array($info['commissieid']));
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
                //zet alle pages in setPagination
                //en geef de pagina waarop de gebruiker zich bevindt
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
            <table class="table table-hover table-responsive">
              <thead class="thead-zhtc">
                <tr id="orderBy" class="<?php print($order);?>">
                  <th scope="col">Acties</th>
                  <th id="commissienaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=commissienaam">Commissienaam</a></th>
                  <th id="voornaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=voornaam">Voornaam</a></th>
                  <th id="tussenvoegsel" scope="col"><a href="?p=<?php print($pageNr)?>&ord=tussenvoegsel">Tussenvoegsel</a></th>
                  <th id="achternaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=achternaam">Achternaam</a></th>
                  <th id="geboortedatum" scope="col"><a href="?p=<?php print($pageNr)?>&ord=geboortedatum">Geboortedatum</a></th>
                  <th id="adres" scope="col"><a href="?p=<?php print($pageNr)?>&ord=adres">Adres</a></th>
                  <th id="woonplaats" scope="col"><a href="?p=<?php print($pageNr)?>&ord=woonplaats">Woonplaats</a></th>
                  <th id="postcode" scope="col"><a href="?p=<?php print($pageNr)?>&ord=postcode">Postcode</a></th>
                  <th id="geslacht" scope="col"><a href="?p=<?php print($pageNr)?>&ord=geslacht">Geslacht</a></th>
                  <th id="emailadres" scope="col"><a href="?p=<?php print($pageNr)?>&ord=emailadres">Emailadres</a></th>
                  <th id="rekeningnummer" scope="col"><a href="?p=<?php print($pageNr)?>&ord=rekeningnummer">Rekeningnummer</a></th>
                  <th id="noodnummer" scope="col"><a href="?p=<?php print($pageNr)?>&ord=noodnummer">Noodnummer</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                //zet elk resultaat in een tabel
                foreach($data as $row) {
                  //check of het de voorzitter is om te voorkomen dat je de voorzitter kan verwijderen
                  if($row['lidID'] == $row['commissievoorzitter']){
                    //zet de data-target van de knop naar wat er in diabled staat
                    $disabled = "disabled";
                  }else{
                    $disabled = "verwijderen";
                  }
                ?>
                <tr class="thisId commissie" id='<?php print($row['lidID']);?>'>
                  <td class="ChosenC" id='<?php print($row['commissieID']);?>'>
                    <!-- knop voor het verwijderen van commissieleden -->
                    <button class="btn btn-xs delModal commissie" data-id="<?php print($row['voornaam']." ".$row['achternaam']);?>" data-toggle="modal" data-target="#<?php print($disabled);?>"><i class="icon ion-trash-b" <?php print($disabled);?>></i></button>
                  </td>
                  <td><?php print($row['commissienaam']);?></td>
                  <td><?php print($row['voornaam']);?></td>
                  <td><?php print($row['tussenvoegsel']);?></td>
                  <td><?php print($row['achternaam']);?></td>
                  <td><?php print($row['geboortedatum']);?></td>
                  <td><?php print($row['adres']);?></td>
                  <td><?php print($row['woonplaats']);?></td>
                  <td><?php print($row['postcode']);?></td>
                  <td><?php print($row['geslacht']);?></td>
                  <td><?php print($row['emailadres']);?></td>
                  <td><?php print($row['rekeningnummer']);?></td>
                  <td><?php print($row['noodnummer']);?></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
        </main>
    </div>
</div>
<!-- Modals -->
<!-- Modaal voor het verwijderen van een lid uit de commissie -->
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
        <small class="text-muted"></small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<!-- Modaal die je te zien krijgt als je de voorzitter probeert te verwijderen -->
<div class="modal fade" id="disabled" tabindex="-1" role="dialog" aria-labelledby="disabledlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disabledlabel">U kunt de voorzitter (uzelf) niet verwijderen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small class="text-muted">Als je van voorzitter wilt veranderen kan dat met de "Nieuwe voorzitter aanwijzen" knop</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

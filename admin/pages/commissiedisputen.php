<?php
session_start();
include '../../includes/dbconnect.php';
include '../alert.php';
if(isset($_GET['delete']) && !(empty($_GET['delete']))){
  if($_GET['delete'] == "yes"){
    $id = $_GET['id'];
    if($_GET['choice'] == "dispuut"){
      $stmt2 = $pdo->prepare("DELETE FROM dispuutlid
        WHERE dispuutid=?");
      $stmt2->execute(array($id));
      $stmt1 = $pdo->prepare("DELETE FROM dispuut
        WHERE dispuutid=?");
      $stmt1->execute(array($id));
      if ($stmt1->rowCount() > 0) {
        $_SESSION['error'] = "Het dispuut is succesvol verwijderd!";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
      }
    }elseif($_GET['choice'] == "commissie"){
      $stmt2 = $pdo->prepare("DELETE FROM commissielid
        WHERE commissieID=?");
      $stmt2->execute(array($id));
      $stmt1 = $pdo->prepare("DELETE FROM commissie
        WHERE commissieID=?");
      $stmt1->execute(array($id));
      if ($stmt1->rowCount() > 0) {
        $_SESSION['error'] = "De commissie is succesvol verwijderd!";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
      }
    }
  }
  header('Location: commissiedisputen');
}
if(isset($_GET['as']) && !(empty($_GET['as']))){
  if($_GET['as'] == "commissie"){
    if($_GET['edit'] == "true"){
      //opvragen Huidige voorzitter
      $stmt = $pdo->prepare("SELECT commissievoorzitter FROM commissie
      WHERE commissieID = ?");
      $stmt -> execute(array($_GET['cid']));
      $cVoorzitter = $stmt -> fetch(PDO::FETCH_ASSOC);

      //verwijderen huidige voorzitter uit commissielid
      $stmt2 = $pdo->prepare("DELETE FROM commissielid
        WHERE commissieID=?
        AND lidID = ?");
      $stmt2->execute(array($_GET['cid'],$cVoorzitter['commissievoorzitter']));

      //De nieuwe voorzitter toevoegen als commissievoorzitter
      $stmt = $pdo->prepare("UPDATE commissie
        SET commissienaam=?, commissievoorzitter=?
        WHERE commissieID=?");
      $stmt->execute(array($_GET['newName'], $_GET['nameid'], $_GET['cid']));
      if ($stmt->rowCount() > 0) {
        //succesvol
        $_SESSION['error'] = "De commissie is succesvol aangepast!";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
      }

      //De nieuwe voorzitter toevoegen als lid (als hij nog geen lid is)
      $stmt = $pdo->prepare("INSERT INTO commissielid(commissieID, lidID)
        VALUES(?, ?)");
      $stmt->execute(array($_GET['cid'],$_GET['nameid']));

      header('Location: commissiedisputen');
    }else{
      //Prepare en execute de sql query om een nieuwe commissie toe te voegen
      $stmt = $pdo->prepare("INSERT INTO commissie(commissienaam, commissievoorzitter)
        VALUES(?, ?)");
      $stmt->execute(array($_GET['newName'], $_GET['nameid']));

      //Selecteer het id van de commissie die zojuist is toegevoegd en sla die op als $maxId
      $stmt = $pdo->prepare("SELECT MAX(commissieID) AS max_id FROM commissie");
      $stmt -> execute();
      $maxId = $stmt -> fetch(PDO::FETCH_ASSOC);
      $maxId = $maxId['max_id'];

      //Voeg de nieuwe commissie toe
      $stmt = $pdo->prepare("INSERT INTO commissielid(commissieID, lidID)
        VALUES(?, ?)");
      $stmt->execute(array($maxId, $_GET['nameid']));
      if ($stmt->rowCount() > 0) {
        //succesvol
        $_SESSION['error'] = "De nieuwe commissie (".$_GET['newName'].") is succesvol toegevoegd.";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
        header('Location: commissiedisputen');
      }
    }
  }elseif($_GET['as'] == "dispuut"){
    if($_GET['edit'] == "true"){
      //Opvragen huidige  voorzitter
      $stmt = $pdo->prepare("SELECT dispuutvoorzitter FROM dispuut
      WHERE dispuutid = ?");
      $stmt -> execute($_GET['cid']);
      $dVoorzitter = $stmt -> fetch(PDO::FETCH_ASSOC);

      //Deze uit dispuutlid verwijderen
      $stmt2 = $pdo->prepare("DELETE FROM dispuutlid
        WHERE dispuutid=?
        AND lidID = ?");
      $stmt2->execute(array($_GET['cid'],$dVoorzitter['commissievoorzitter']));
      //die($_GET['newName']." | ".$_GET['nameid']." | ".$_GET['cid']);
      //Verander dispuutvoorzitter naar de nieuwe voorzitter
      $stmt = $pdo->prepare("UPDATE dispuut
        SET dispuutnaam=?, dispuutvoorzitter=?
        WHERE dispuutid=?");
      $stmt->execute(array($_GET['newName'], $_GET['nameid'], $_GET['cid']));
      if ($stmt->rowCount() > 0) {
        //succesvol
        $_SESSION['error'] = "Het dispuut is succesvol aangepast!";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
      }

      //Voeg ook de nieuwe voorzitter toe aan dispuutlid
      $stmt = $pdo->prepare("INSERT INTO dispuutlid(dispuutid, lidID)
        VALUES(?, ?)");
      $stmt->execute(array($_GET['cid'],$_GET['nameid']));

      header('Location: commissiedisputen');
      //end edit
    }else{
      //Prepare en execute de sql query om een nieuwe dispuut toe te voegen
      $stmt = $pdo->prepare("INSERT INTO dispuut(dispuutnaam, dispuutvoorzitter)
        VALUES(?, ?)");
      $stmt->execute(array($_GET['newName'], $_GET['nameid']));

      //Selecteer het id van de dispuut die zojuist is toegevoegd en sla die op als $maxId
      $stmt = $pdo->prepare("SELECT MAX(dispuutid) AS max_id FROM dispuut");
      $stmt -> execute();
      $maxId = $stmt -> fetch(PDO::FETCH_ASSOC);
      $maxId = $maxId['max_id'];

      //Voeg het dispuut toe
      $stmt = $pdo->prepare("INSERT INTO dispuutlid(dispuutid, lidID)
        VALUES(?, ?)");
      $stmt->execute(array($maxId, $_GET['nameid']));
      if ($stmt->rowCount() > 0) {
        //succesvol
        $_SESSION['error'] = "Het nieuwe dispuut (".$_GET['newName'].") is succesvol toegevoegd.";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "Succes!";
        header('Location: commissiedisputen');
      }
    }
  }
  header('Location: commissiedisputen');
}

//Kijk of er niks leeg is gepost
  if(isset($_POST['add'])){
    $as = $_POST['as'];
    $edit = $_POST['edit'];
    $newName = $_POST['newName'];
    $id = $_POST['id'];
    $voorzitterNaam = explode(" ", $_POST['voorzitter']);
    if(!isset($voorzitterNaam[1])){
      $_SESSION['error'] = "Er is iets fout gegaan. Kijk goed of u daadwerkelijk alle velden goed heeft ingevuld.(Geen voornaam en achternaam gevonden)";
      $_SESSION['errorType'] = "danger";
      $_SESSION['errorAdd'] = "Let op!";
      header('Location: commissiedisputen');
    }else{
      $stmt = $pdo->prepare("SELECT lidID, voornaam, tussenvoegsel, achternaam, geboortedatum, woonplaats FROM lid
      WHERE voornaam = ?
      AND achternaam = ?");
      $stmt->execute(array($voorzitterNaam[0],$voorzitterNaam[1]));
      $data3 = $stmt->fetchAll();
      if (!$stmt->rowCount() > 0) {
        $_SESSION['error'] = "Er is geen persoon in het systeem gevonden met die voornaam en achternaam.(Controleer of je de naam goed hebt ingevuld.)";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: commissiedisputen');
      }
      if($count = $stmt->rowCount() == 1){
        foreach($data3 as $row) {
          $voorzitterID = $row['lidID'];
        }
        header('Location: commissiedisputen?as='.$as.'&nameid='.$voorzitterID.'&newName='.$newName.'&edit='.$edit.'&cid='.$id);
        exit;
      }
      $voorzitterList = "";
      foreach($data3 as $row) {
        $voorzitterList .= $row['lidID']." ";
      }
      unset($_POST['addc']);
    }
  }else{
    $id="";
    $voorzitterList="";
    $newName = "";
    $as="";
  }
  if(isset($_SESSION['error'])){
    print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
    unset($_SESSION['error']);
  }
 ?>
<html lang="en">
      <?php
      include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="commissiedisputen">ZHTC commissies en disputen overzicht<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>
            </div>
            <br>
            <div class="card">
              <div class="card-header">
                <h3 id="getVoorzitter" class="<?php print($voorzitterList); ?>">Commissies</h3>
              </div>
              <div class="card-body">
            <?php
            $stmt = $pdo->prepare("SELECT c.commissienaam, c.commissiezin, CONCAT(IFNULL(l1.voornaam,''),' ',IFNULL(l1.tussenvoegsel,''),' ',IFNULL(l1.achternaam,'')) AS voorzitter, COUNT(*) AS aantal_leden FROM commissielid cl
			      JOIN commissie c ON cl.commissieID = c.commissieID
            JOIN lid l1 ON c.commissievoorzitter = l1.lidID
            JOIN lid l2 ON cl.lidID = l2.lidID
            GROUP BY c.commissieID");
            $stmt->execute();
            $count = $stmt->rowCount();
            $resultsPer = 20;
            $pages = ceil($count/$resultsPer);
            if(isset($_GET['p']) && !empty($_GET['p'])){
              $pageNr = $_GET['p'];
            }else{
              $pageNr = 1;
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
            $stmt = $pdo->prepare("SELECT c.commissieID, c.commissienaam, c.commissiezin, CONCAT_WS(' ',l1.voornaam, l1.tussenvoegsel, l1.achternaam) AS voorzitter, COUNT(*) AS aantal_leden FROM commissielid cl
			      JOIN commissie c ON cl.commissieID = c.commissieID
            JOIN lid l1 ON c.commissievoorzitter = l1.lidID
            JOIN lid l2 ON cl.lidID = l2.lidID
            GROUP BY c.commissieID
            ORDER by commissienaam ASC
            LIMIT $startNr, $resultsPer");
            $stmt->execute();
            $data = $stmt->fetchAll();
             ?>
             <div class="row">
               <div class="col-sm-6 col-xs-12">
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
          </div>
            <div class="col-sm-6 col-xs-12">
                <button type="button" class="btn btn-outline-primary zhtc-button float-right" data-toggle="modal" data-target="#addcommissie">Nieuwe commissie toevoegen</button>
            </div>
          </div>
            <hr>
            <div class="table-responsive">
            <table class="table table-hover">
              <caption>Commissies</caption>
              <thead class="thead-zhtc">
                <tr>
                  <th scope="col">Acties</th>
                  <th scope="col"><a>Commissienaam</a></th>
                  <th scope="col"><a>Voorzitter</a></th>
                  <th scope="col"><a>Aantal leden</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($data as $row) {
                ?>
                <tr class="thisId commissie" id='<?php print($row['commissieID']);?>'>
                  <td id='<?php print($row['voorzitter']);?>'>
                    <button class="btn btn-xs delModal commissie" data-id="<?php print($row['commissienaam']);?>" data-toggle="modal" data-target="#verwijderen"><i class="icon ion-trash-b"></i></button>
                    <button class="btn btn-xs editModal btn-warning commissie" data-id="<?php print($row['commissienaam']);?>" data-toggle="modal" data-target="#editc<?php print($row['commissieID']);?>"><i class="icon ion-edit"></i></button>
                  </td>
                  <td><?php print($row['commissienaam']);?></td>
                  <td><?php print($row['voorzitter']);?></td>
                  <td><?php print($row['aantal_leden']);?></td>
                </tr>
                <!-- Modals -->
                <div class="modal fade" id="editc<?php print($row['commissieID']);?>" tabindex="-1" role="dialog" aria-labelledby="editc<?php print($row['commissieID']);?>label" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editc<?php print($row['commissieID']);?>label">Aanpassen <span class="deleteName"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <small class="text-muted">Let op dat zodra de voorzitter aangepast wordt deze persoon geen rechten meer heeft tot aanpassingen.</small>
                        <form class="mt-3" id="getErrormess" action="commissiedisputen" method="post">
                              <div class="form-group row">
                                  <label for="newName" class="col-sm-3 col-form-label">Naam:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <input  id="commNaam" type="text" class="form-control" name="newName" placeholder="" required value="<?php print($row['commissienaam']);?>">
                                  </div>
                              </div>
                              <div class="imput-group row">
                                  <label for="voorzitterInput" class="col-sm-3 col-form-label">Voorzitter:</label>
                                  <div class="col-sm-9 px-0 pr-5">
                                    <div class="input-group mb-2 mb-sm-0">
                                      <input  id="voorzitterNaam" type="text" class="form-control" name="voorzitter" value="<?php print($row['voorzitter']);?>" required>
                                    </div>
                                    <small id="voorzitterHelp" class="form-text text-muted">Vul de voornaam en de achternaam van de persoon in gescheiden met een spatie</small>
                                    <div id="feedkeuze" class="invalid-feedback" hidden>
                                    </div>
                                  </div>
                              </div>
                      </div>
                      <input type="hidden" name="id" value="<?php print($row['commissieID']);?>">
                      <input type="hidden" name="as" value="commissie">
                      <input type="hidden" name="edit" value="true">
                      <div class="modal-footer">
                        <button id="setthisHref2" onclick="" class="btn btn-outline-warning" type="submit" name="add">Aanpassen</button>
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
        </div>
        </div>
        <br>
        <div class="card">
          <div class="card-header">
            <h3>Disputen</h3>
          </div>
          <div class="card-body">
        <?php
        $stmt = $pdo->prepare("SELECT d.dispuutnaam, d.dispuutzin, CONCAT_WS(' ',l1.voornaam, l1.tussenvoegsel, l1.achternaam) AS voorzitter, COUNT(*) AS aantal_leden FROM dispuutlid dl
        JOIN dispuut d ON dl.dispuutID = d.dispuutID
        JOIN lid l1 ON d.dispuutvoorzitter = l1.lidID
        JOIN lid l2 ON dl.lidID = l2.lidID
        GROUP BY d.dispuutID");
        $stmt->execute();
        $count = $stmt->rowCount();
        $resultsPer = 20;
        $pages = ceil($count/$resultsPer);
        if(isset($_GET['p2']) && !empty($_GET['p2'])){
          $pageNr = $_GET['p2'];
        }else{
          $pageNr = 1;
        }
        $page_status = setPagination($pages, $pageNr);
        $page_status_left = $page_status[0];
        $page_status_right = $page_status[1];
        $startNr = ($resultsPer*$pageNr)-$resultsPer;
        $stmt = $pdo->prepare("SELECT d.dispuutid, d.dispuutnaam, d.dispuutzin, CONCAT_WS(' ',l1.voornaam, l1.tussenvoegsel, l1.achternaam) AS voorzitter, COUNT(*) AS aantal_leden FROM dispuutlid dl
        JOIN dispuut d ON dl.dispuutID = d.dispuutID
        JOIN lid l1 ON d.dispuutvoorzitter = l1.lidID
        JOIN lid l2 ON dl.lidID = l2.lidID
        GROUP BY d.dispuutID
        ORDER by dispuutnaam ASC
        LIMIT $startNr, $resultsPer");
        $stmt->execute();
        $data = $stmt->fetchAll();
         ?>
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php print($page_status_left)?>">
                  <a class="page-link icon-fix" href="?p2=<?php print($pageNr-1); ?>" aria-label="Previous">
                    <span class="icon ion-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <?php
                for($i = 1; $i <= $pages; $i++){
                  if($i == $pageNr){
                    print("<li class='page-item active'><a class='page-link zhtc-bg zhtc-brd' href='?p2=$i'> $i </a></li>");
                  }else{
                    print("<li class='page-item'><a class='page-link' href='?p2=$i'> $i </a></li>");
                  }
                }
                ?>
                <li class="page-item <?php print($page_status_right)?>">
                  <a class="page-link icon-fix" href="?p2=<?php print($pageNr+1); ?>" aria-label="Next">
                    <span class="icon ion-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="col-sm-6 col-xs-12">
              <button type="button" class="btn btn-outline-primary zhtc-button float-right" data-toggle="modal" data-target="#adddispuut">Nieuw dispuut toevoegen</button>
          </div>
        </div>
        <hr>
        <div class="table-responsive">
        <table class="table table-hover">
          <caption>Disputen</caption>
          <thead class="thead-zhtc">
            <tr>
              <th scope="col">Acties</th>
              <th scope="col"><a>Dispuutnaam</a></th>
              <th scope="col"><a>Voorzitter</a></th>
              <th scope="col"><a>Aantal leden</a></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($data as $row) {
            ?>
            <tr class="thisId dispuut" id='<?php print($row['dispuutid']);?>'>
              <td id='<?php print($row['voorzitter']);?>'>
                <button class="btn btn-xs delModal dispuut" data-id="<?php print($row['dispuutnaam']);?>" data-toggle="modal" data-target="#verwijderen"><i class="icon ion-trash-b"></i></button>
                <button class="btn btn-xs editModal btn-warning dispuut" data-id="<?php print($row['dispuutnaam']);?>" data-toggle="modal" data-target="#edit<?php print($row['dispuutid']);?>"><i class="icon ion-edit"></i></button>
              </td>
              <td><?php print($row['dispuutnaam']);?></td>
              <td><?php print($row['voorzitter']);?></td>
              <td><?php print($row['aantal_leden']);?></td>
            </tr>
            <!-- Modals -->
            <div class="modal fade" id="edit<?php print($row['dispuutid']);?>" tabindex="-1" role="dialog" aria-labelledby="edit<?php print($row['dispuutid']);?>label" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="edit<?php print($row['dispuutid']);?>label">Aanpassen <span class="deleteName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <small class="text-muted">Let op dat zodra de voorzitter aangepast wordt deze persoon geen rechten meer heeft tot aanpassingen.</small>
                    <form class="mt-3" id="getErrormess" action="commissiedisputen" method="post">
                          <div class="form-group row">
                              <label for="newName" class="col-sm-3 col-form-label">Naam:</label>
                              <div class="col-sm-9 px-0 pr-5">
                                <input  id="dispNaam" type="text" class="form-control" name="newName" placeholder="" required value="<?php print($row['dispuutnaam']);?>">
                              </div>
                          </div>
                          <div class="imput-group row">
                              <label for="dvoorzitterInput" class="col-sm-3 col-form-label">Voorzitter:</label>
                              <div class="col-sm-9 px-0 pr-5">
                                <div class="input-group mb-2 mb-sm-0">
                                  <input  id="dvoorzitterNaam" type="text" class="form-control" name="voorzitter" required value="<?php print($row['voorzitter']);?>">
                                </div>
                                <small id="dvoorzitterHelp" class="form-text text-muted">Vul de voornaam en de achternaam van de persoon in gescheiden met een spatie</small>
                                <div id="feedkeuze" class="invalid-feedback" hidden>
                                </div>
                              </div>
                          </div>
                  </div>
                  <input type="hidden" name="id" value="<?php print($row['dispuutid']);?>">
                  <input type="hidden" name="as" value="dispuut">
                  <input type="hidden" name="edit" value="true">
                  <div class="modal-footer">
                    <button id="setthisHref3" onclick="" class="btn btn-outline-warning" type="submit" name="add">Aanpassen</button>
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
      </div>
    </div>
        </main>
    </div>
</div>
<!-- Modals -->
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
        <small class="text-muted">Houdt er rekening mee dat zodra u "<span class="deleteName"></span>" verwijderd alle leden die hier in staan uit geschreven worden.</small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal nieuwe commissie toevoegen -->
<div class="modal fade" id="addcommissie" tabindex="-1" role="dialog" aria-labelledby="addcommissielabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addcommissielabel">Commissie toevoegen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="getErrormess" action="commissiedisputen" method="post">
              <div class="form-group row">
                  <label for="newName" class="col-sm-3 col-form-label">Naam:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <input  id="newName" type="text" class="form-control" name="newName" placeholder="" required>
                  </div>
              </div>
              <div class="imput-group row">
                  <label for="keuze" class="col-sm-3 col-form-label">Voorzitter:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <div class="input-group mb-2 mb-sm-0">
                      <input  id="voorzitterInput" type="text" max="8" class="form-control" name="voorzitter" value="" required>
                    </div>
                    <small id="voorzitterHelp" class="form-text text-muted">Vul de voornaam en de achternaam van de persoon in gescheiden met een spatie(Dus geen tussenvoegsels)</small>
                    <div id="feedkeuze" class="invalid-feedback" hidden>
                    </div>
                  </div>
              </div>
              <input type="hidden" name="id" value="">
              <input type="hidden" name="as" value="commissie">
              <input type="hidden" name="edit" value="false">
      </div>
      <div class="modal-footer">
        <input id="voorzitter" class="btn btn-outline-primary" type="submit" name="add" value="Toevoegen">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal nieuwe dispuut toevoegen -->
<div class="modal fade" id="adddispuut" tabindex="-1" role="dialog" aria-labelledby="adddispuutlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adddispuutlabel">Dispuut toevoegen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="getErrormess" action="commissiedisputen" method="post">
              <div class="form-group row">
                  <label for="newName" class="col-sm-3 col-form-label">Naam:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <input  id="newName" type="text" class="form-control" name="newName" placeholder="" required>
                  </div>
              </div>
              <div class="imput-group row">
                  <label for="voorzitterInput" class="col-sm-3 col-form-label">Voorzitter:</label>
                  <div class="col-sm-9 px-0 pr-5">
                    <div class="input-group mb-2 mb-sm-0">
                      <input  id="voorzitterInput" type="text" class="form-control" name="voorzitter" value="" required>
                    </div>
                    <small id="voorzitterHelp" class="form-text text-muted">Vul de voornaam en de achternaam van de persoon in gescheiden met een spatie(Dus geen tussenvoegsels)</small>
                    <div id="feedkeuze" class="invalid-feedback" hidden>
                    </div>
                  </div>
              </div>
      </div>
      <input type="hidden" name="id" value="">
      <input type="hidden" name="as" value="dispuut">
      <input type="hidden" name="edit" value="false">
      <div class="modal-footer">
        <input id="voorzitter" class="btn btn-outline-primary" type="submit" name="add" value="Toevoegen">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal nieuwe dispuut toevoegen -->
<div class="modal fade" id="kiesVoorzitter" tabindex="-1" role="dialog" aria-labelledby="kiesVoorzitterlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kiesVoorzitterlabel">Voorzitter kiezen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted">Er zijn meerdere personen gevonden met dezelfde voornaam en achternaam. Klik op de persoon die u bedoelde.</p>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Naam</th>
              <th scope="col">Geboortedatum</th>
              <th scope="col">woonplaats</th>
            </tr>
          </thead>
          <tbody>
            <?php
            //
            foreach($data3 as $row) {
            print("<tr>
              <td><a href='?nameid=".$row['lidID']."&newName=$newName&edit=$edit&as=$as&cid=$id'>".$row['voornaam']." ".$row['tussenvoegsel']." ".$row['achternaam']."</a></td>
              <td>".$row['geboortedatum']."</td>
              <td>".$row['woonplaats']."</td>
            </tr>");
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

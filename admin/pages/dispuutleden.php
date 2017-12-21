<?php
  session_start();
  include '../../includes/dbconnect.php';
  include '../alert.php';
  //Verwijder code
  if(isset($_GET['delete']) && !(empty($_GET['delete']))){
    if($_GET['delete'] == "yes"){
      $id = $_GET['id'];
      $Sid = $_GET['ots'];
      if($_GET['choice'] == "dispuut"){
        $stmt2 = $pdo->prepare("DELETE FROM dispuutlid
          WHERE lidID=?
          AND dispuutid = ?
          ");
        $stmt2->execute(array($id,$Sid));
      }else{
        //
      }
    }
    $_SESSION['error'] = "U heeft succesvol een lid verwijderd uit uw dispuut";
    $_SESSION['errorType'] = "success";
    $_SESSION['errorAdd'] = "succes!";
    header('Location: dispuutleden');
  }

  //Toevoeg code
  if(isset($_GET['choice']) && !(empty($_GET['choice']))){
    if(isset($_GET['leden']) && isset($_GET['id'])){
      $ledenArray = explode(",", $_GET['leden']);
      if(isset($_GET['leden']) && !(empty($_GET['leden']))){
        //goed
      }else{
        if($_GET['as'] == "voorzitter"){
          $_SESSION['error'] = "U heeft geen lid gekozen om als nieuwe voorzitter op te stellen.";
        }else{
          $_SESSION['error'] = "U heeft geen leden gekozen om aan u dispuut toe te voegen.";
        }
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!!";
        header('Location: dispuutleden');
        exit;
      }
      $id = $_GET['id'];
      if($_GET['as'] == "voorzitter"){
        $stmt = $pdo->prepare("SELECT dispuutvoorzitter FROM dispuut
        WHERE dispuutid = ?");
        $stmt -> execute(array($id));
        $cVoorzitter = $stmt -> fetch(PDO::FETCH_ASSOC);

        $stmt2 = $pdo->prepare("DELETE FROM dispuutlid
          WHERE dispuutid=?
          AND lidID = ?");
        $stmt2->execute(array($id,$cVoorzitter['dispuutvoorzitter']));
        //get id huidige voorzitter query
        //delete die van dispuutlid
        $stmt = $pdo->prepare("UPDATE dispuut SET dispuutvoorzitter=?
          WHERE dispuutid = ?");
        $stmt->execute(array($ledenArray[0],$id));
        $stmt = $pdo->prepare("INSERT INTO dispuutlid(dispuutid, lidID)
          VALUES(?, ?)");
        $stmt->execute(array($id,$ledenArray[0]));
        // header naar logout script
        header('Location: ../../loguit');
      }else{
        for($i = 0; $i <= count($ledenArray); $i++){
          $stmt = $pdo->prepare("INSERT INTO dispuutlid(dispuutid, lidid)
            VALUES(?, ?)");
          $stmt->execute(array($id,$ledenArray[$i]));
        }
        $_SESSION['error'] = "U heeft succesvol leden toegevoegd aan uw dispuut";
        $_SESSION['errorType'] = "success";
        $_SESSION['errorAdd'] = "succes!";
      }
    }
    header('Location: dispuutleden');
  }
  error_reporting(E_ALL & ~E_NOTICE);
  session_start();
  $stmt = $pdo->prepare("SELECT dispuutid FROM dispuut WHERE dispuutvoorzitter = ?");
  $stmt->execute(array($_SESSION['lid']));

  $info = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($stmt->rowCount()) {
      //
  } else {
      print("Werkt niet");
  }
  if(isset($_SESSION['error'])){
    print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
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
                <h1 id="pageLoc" class="dispuutleden">ZHTC DispuutLeden<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>
            </div>
            <br>
            <div class="row">
              <div class="col-md-11">
                <!-- Knop die de modal inlaadt voor het toevoegen van een nieuwe poll -->
                  <button type="button" class="btn btn-outline-primary zhtc-button" onclick="location.href='toevoegenlid?choice=dispuut&id=<?php print($info['dispuutid']);?>&as=voorzitter'">Nieuwe voorzitter aanwijzen</button>
                  <button type="button" class="btn btn-outline-primary zhtc-button" onclick="location.href='toevoegenlid?choice=dispuut&id=<?php print($info['dispuutid']);?>&as=lid'">Nieuwe leden toevoegen</button>
              </div>
            </div>
            <hr>
            <?php
            $stmt = $pdo->prepare("SELECT dispuutid FROM dispuut WHERE dispuutvoorzitter = ?");
            $stmt->execute(array($_SESSION['lid']));

            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount()) {
                //
            } else {
                print("Werkt niet");
            }
            $stmt = $pdo->prepare("SELECT * FROM dispuutlid d
            JOIN lid l ON d.lidID = l.lidID
            WHERE dispuutid = ?");
            $stmt->execute(array($info['dispuutid']));
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
            $page_status = setPagination($pages, $pageNr);
            $page_status_left = $page_status[0];
            $page_status_right = $page_status[1];
            $startNr = ($resultsPer*$pageNr)-$resultsPer;
            $stmt = $pdo->prepare("SELECT * FROM dispuutlid dl
            JOIN lid l ON dl.lidID = l.lidID
            JOIN dispuut d ON dl.dispuutID = d.dispuutid
            WHERE dl.dispuutid = ?
            ORDER by $order ASC
            LIMIT $startNr, $resultsPer");
            $stmt->execute(array($info['dispuutid']));
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
            <table class="table table-hover table-responsive">
              <thead class="thead-zhtc">
                <tr id="orderBy" class="<?php print($order);?>">
                  <th scope="col">Acties</th>
                  <th id="dispuutnaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=dispuutnaam">Dispuutnaam</a></th>
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
                foreach($data as $row) {
                  if($row['lidID'] == $row['dispuutvoorzitter']){
                    $disabled = "disabled";
                  }else{
                    $disabled = "verwijderen";
                  }
                ?>
                <tr class="thisId dispuut" id='<?php print($row['lidID']);?>'>
                  <td class="ChosenC" id='<?php print($row['dispuutid']);?>'>
                    <button class="btn btn-xs delModal dispuut" data-id="<?php print($row['voornaam']." ".$row['achternaam']);?>" data-toggle="modal" data-target="#<?php print($disabled);?>"><i class="icon ion-trash-b"></i></button>
                  </td>
                  <td><?php print($row['dispuutnaam']);?></td>
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
        <small class="text-muted"></small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>
<!-- Modals -->
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

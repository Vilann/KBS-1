<?php
  /*
  /bug sortering en pagination werkt niet
  ##pollpagina##
  Op deze pagina kun je:
  -Alle polls zien die in het verleden zijn afgerond
  -Nieuwe polls toevoegen
  -...
  -...
   */
  //includes
  include '../../includes/dbconnect.php'; //connectie met de database

  //Kijk of er een choice is gezet (commissie of dispuut)
  if(isset($_GET['choice']) && !(empty($_GET['id']))){
    $id = $_GET['id']; //id van de commissie/dispuut
    $choice = $_GET['choice']; //of het gaat om een dispuut of commissie
    $as = $_GET['as']; //voorzitter of lid
    //als het gaat om commissie/dispuut veranderd de sql naar dit
    if($choice == "commissie"){
      $choiceSQL1 = "commissielid";
      $choiceSQL2 = "commissieID";
    }else{
      $choiceSQL1 = "dispuutlid";
      $choiceSQL2 = "dispuutid";
    }
    //de tekst aanpassen als het gaat om een voorzitter of dispuut
    if($_GET['as'] == "voorzitter"){
      $titel = "Hier kunt u een nieuwe voorzitter aanwijzen";
      $tekst = "Klik op de voorzitter die u als nieuwe voorzitter wilt aanwijzen. houd er rekening mee dat zodra deze actie voltooid is je geen voorzitters rechten hebt en opnieuw moet inloggen.";
    }else{
      $titel = "Hier kunt u een nieuwe leden aanwijzen";
      $tekst = "Klik op de alle leden die u wilt uitnodigen om deel te nemen aan uw commissie en klik hierna op voltooien.";
    }
  }else{
    //header('Location: toevoegenlid');
  }
?>
<html lang="en">
      <?php include '../header.php'; ?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="disabled"><?php print($titel); ?></h1>
            </div>
            <div id="<?php print($as);?>" class="row as">
              <div class="col-md-11">
                <p class="text-muted mb-1">
                  <?php print($tekst); ?>
                </p>
              </div>
            </div>
            <span class="id" id="<?php print($_GET['id']);?>"></span>
            <br>
            <?php
            //query om alle leden op te halen op basis van de meegegeven variabelen
            $sql = "SELECT * FROM lid l
            WHERE inactief = 0
            AND l.lidID NOT IN (SELECT lidID FROM $choiceSQL1
            WHERE $choiceSQL2 = ?)
            ORDER by achternaam ASC";
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($id));
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
            //selecteer alle leden van zhtc die niet verwijderd zijn
            $sql = "SELECT * FROM lid l
            WHERE inactief = 0
            AND l.lidID NOT IN (SELECT lidID FROM $choiceSQL1
            WHERE $choiceSQL2 = ?)
            ORDER by $order ASC
            LIMIT $startNr, $resultsPer";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($id));
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
                  <th id="voornaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=voornaam">Voornaam</a></th>
                  <th id="tussenvoegsel" scope="col"><a href="?p=<?php print($pageNr)?>&ord=tussenvoegsel">Tussenvoegsel</a></th>
                  <th id="achternaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=achternaam">Achternaam</a></th>
                  <th id="geboortedatum" scope="col"><a href="?p=<?php print($pageNr)?>&ord=geboortedatum">Geboortedatum</a></th>
                  <th id="woonplaats" scope="col"><a href="?p=<?php print($pageNr)?>&ord=woonplaats">Woonplaats</a></th>
                  <th id="geslacht" scope="col"><a href="?p=<?php print($pageNr)?>&ord=geslacht">Geslacht</a></th>
                  <th id="emailadres" scope="col"><a href="?p=<?php print($pageNr)?>&ord=emailadres">Emailadres</a></th>
                </tr>
              </thead>
              <tbody class="choice" id="<?php print($_GET['choice']);?>">
                <?php
                //alle data in een tabel laden
                foreach($data as $row) {
                ?>
                <tr class="thisId leden clickable-row" id='<?php print($row['lidID']);?>'>
                  <td><?php print($row['voornaam']);?></td>
                  <td><?php print($row['tussenvoegsel']);?></td>
                  <td><?php print($row['achternaam']);?></td>
                  <td><?php print($row['geboortedatum']);?></td>
                  <td><?php print($row['woonplaats']);?></td>
                  <td><?php print($row['geslacht']);?></td>
                  <td><?php print($row['emailadres']);?></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <hr>
            <div class="row">
              <div class="col-md-12">
                  <button type="button" onclick="javascript:history.back()" class="btn btn-outline-secondary float-right ml-2"> terug </button>
                  <a id="voltooien" class="btn btn-outline-primary zhtc-button float-right"> Voltooien </a>
              </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>

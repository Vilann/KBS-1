<?php
  /*
  ##Commissiepagina##
  Op deze pagina kun je:
  -Alle leden van ZHTC inzien
  -Alle leden aanpassen
  -Leden uit de vereniging zetten
  -...
   */
  session_start();
  //includes
  include '../../includes/dbconnect.php'; //connectie met de database
  include '../alert.php'; //include alerts

  //Code die getrigger wordt als er een lid verwijderd wordt
  if(isset($_GET['delete']) && !(empty($_GET['delete']))){
    if($_GET['delete'] == "yes"){
      $id = $_GET['id'];
      if($_GET['choice'] == "leden"){
        //zet het lid in kwestie op inactief
        $stmt = $pdo->prepare("DELETE FROM commissielid
            WHERE lidID=?");
        $stmt->execute(array($id));
        $stmt = $pdo->prepare("DELETE FROM dispuutlid
            WHERE lidID=?");
        $stmt->execute(array($id));
        $stmt = $pdo->prepare("DELETE FROM bestuur
            WHERE bestuurslidID=?");
        $stmt->execute(array($id));
        $stmt = $pdo->prepare("DELETE FROM pollresultaat
            WHERE lidID=?");
        $stmt->execute(array($id));
        $stmt = $pdo->prepare("DELETE FROM lid
            WHERE lidID=?");
        $stmt->execute(array($id));
      }else{
        //
      }
      //succesmelding
      $_SESSION['error'] = "U heeft succesvol een lid verwijderd";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }
    header('Location: leden');
  }

  //Deze code wordt geactiveerd als er op aanpassen gedrukt wordt
  if(isset($_POST['edit'])){
    $id = $_POST['id'];
    //Kijk of alle essentiële onderdelen zijn ingevuld zo ja ga verder
    if (isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['geboortedatum']) && isset($_POST['adres']) && isset($_POST['postcode'])
    && isset($_POST['woonplaats']) && isset($_POST['gender'])) {

      //prepare query voor het aanpassen van een lid
      $stmt = $pdo->prepare("UPDATE lid
          SET voornaam=?,tussenvoegsel=?,achternaam=?,geboortedatum=?,adres=?,postcode=?,woonplaats=?,geslacht=?
          WHERE lidID=?");
      $stmt->execute(array($_POST['voornaam'],$_POST['tussenvoegsel'],$_POST['achternaam'],$_POST['geboortedatum'],$_POST['adres'],$_POST['postcode'],$_POST['woonplaats'],$_POST['gender'],$id));

      //succesmelding
      $_SESSION['error'] = "Het lid is succesvol aangepast";
      $_SESSION['errorType'] = "success";
      $_SESSION['errorAdd'] = "succes!";
    }
    unset($_POST);
    header('Location: leden');
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
                <h1 id="pageLoc" class="leden">ZHTC ledenbestand<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM lid
            WHERE inactief = 0
            ORDER by achternaam ASC");
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
            //als er in de url een andere sorteer staat aangegeven zie ord(order) dan zet die in de variable anders voornaam als de standaard
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
            $stmt = $pdo->prepare("SELECT * FROM lid
            WHERE inactief = 0
            ORDER by $order DESC
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
                  //Geef de pagina waar de gebruiker zich op bevindt een ander kleurtje
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
                //zet alle resultaten van de query in een tabel
                foreach($data as $row) {
                ?>
                <tr class="thisId leden" id='<?php print($row['lidID']);?>'>
                  <td>
                    <button class="mb-2 btn btn-xs delModal leden" data-id="<?php print($row['voornaam']." ".$row['achternaam']);?>" data-toggle="modal" data-target="#verwijderen"><i class="icon ion-trash-b"></i></button>
                    <button class="btn btn-warning btn-xs editmodal leden" data-id="<?php print($row['voornaam']." ".$row['achternaam']);?>" data-toggle="modal" data-target="#edit<?php print($row['lidID']);?>"><i class="icon ion-edit"></i></button>
                  </td>
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
                <!-- Modals -->
                <!-- Modal voor het aanpassen van leden -->
                <div class="modal fade bd-example-modal-lg" id="edit<?php print($row['lidID']);?>" tabindex="-1" role="dialog" aria-labelledby="edit<?php print($row['lidID']);?>label" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="edit<?php print($row['lidID']);?>label">Aanpassen <span class="deleteName"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body mr-5">
                        <form action="leden" method="post">
                              <div class="form-group row">
                                  <label for="voornaam" class="col-sm-4 col-form-label">* Voornaam:</label>
                                  <div class="col-sm-8 px-0">
                                    <input type="text" class="form-control" name="voornaam" placeholder="Voornaam" value="<?php print($row['voornaam']);?>" required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="tussenvoegsel" class="col-sm-4 col-form-label">Tussenvoegsel:</label>
                                  <div class="col-sm-3 px-0">
                                    <input type="text" class="form-control" name="tussenvoegsel" placeholder="Tussenvoegsel" value="<?php print($row['tussenvoegsel']);?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="achternaam" class="col-sm-4 col-form-label">* Achternaam:</label>
                                  <div class="col-sm-8 px-0">
                                    <input type="text" class="form-control" name="achternaam" placeholder="Achternaam" value="<?php print($row['achternaam']);?>" required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="geboortedatum" class="col-sm-4 col-form-label">* Geboortedatum:</label>
                                  <div class="col-sm-8 px-0">
                                    <input type="date" class="form-control" name="geboortedatum" placeholder="geboortedatum" value="<?php print($row['geboortedatum']);?>" max=<?php print('"' . date('Y-m-d', strtotime("-16 year")) . '"'); ?> required>
                                  </div>
                              </div>
                              <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">* Locatie:</label>
                                <div class="col-sm-8">
                                  <div class="row">
                                    <div class="col-12 px-0">
                                      <input type="text" class="form-control" name="adres" placeholder="Adres" value="<?php print($row['adres']);?>">
                                    </div>
                                  </div>
                                </div>
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                  <div class="row">
                                    <div class="col-8 px-0">
                                      <input type="text" class="form-control" name="woonplaats" placeholder="Woonplaats" value="<?php print($row['woonplaats']);?>">
                                    </div>
                                    <div class="col-4 px-0">
                                      <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="<?php print($row['postcode']);?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <fieldset class="form-group">
                                <div class="row">
                                  <legend class="col-form-legend col-sm-4">* Geslacht</legend>
                                  <?php
                                    //zet checked bij het geslacht wat in de db staat
                                    $man = "";
                                    $vrouw = "";
                                    $notset = "";
                                    if($row['geslacht'] == "man"){
                                      $man = "checked";
                                    }elseif ($row['geslacht'] == "vrouw") {
                                      $vrouw = "checked";
                                    }else{
                                      $notset = "checked";
                                    }
                                   ?>
                                  <div class="col-sm-8">
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender" value="man" <?php print($man); ?>>
                                        Man
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender" value="vrouw"  <?php print($vrouw); ?>>
                                        Vrouw
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="gender" value="anders" <?php print($notset); ?>>
                                        Geen van bovenstaande
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </fieldset>
                              <div class="form-group row">
                                  <label for="rekening" class="col-sm-4 col-form-label">* Rekeningnummer:</label>
                                  <div class="col-sm-8 px-0">
                                    <input  id="rekening" type="text" class="form-control" name="iban" placeholder="NL12RABO0123456789" required value="<?php print($row['rekeningnummer']);?>">
                                    <div id="feediban" class="invalid-feedback" hidden>
                                    </div>
                                  </div>
                                  <!-- NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai -->
                              </div>
                              <!-- NOTE: door op deze knop te drukken wordt al deze info gestopt in de value registreer. *zie verwerk Gr Kai -->
                      </div>
                      <input type="hidden" name="id" value="<?php print($row['lidID']);?>">
                      <div class="modal-footer">
                        <button id="setthisHref2" type="submit" onclick="" name="edit" class="btn btn-outline-warning">Aanpassen</button>
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
<!-- Modal voor het verwijderen van leden -->
<div class="modal fade" id="verwijderen" tabindex="-1" role="dialog" aria-labelledby="verwijderenlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verwijderenlabel">Weet u zeker dat u <span class="deleteName"></span>" wilt verwijderen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <small class="text-muted">Het lid wordt verwijderd. let op, als u deze actie voltooid dan dit niet terug te draaien.</small>
      </div>
      <div class="modal-footer">
        <button id="setthisHref" onclick="" class="btn btn-outline-danger" type="button">Verwijderen</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

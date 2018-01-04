<?php
/*
##Commissiepagina##
Op deze pagina kun je:
-Alle commissies zien waarvan jij een voorzitter bent
-De commissie zin aanpassen (motto)
-Commissie tekstje schrijven/aanpassen deze komt op de commissie die voor iedereen te zien is
-Aanpassen/toevoegen banner/foto van jouw commissie
 */
session_start();
//includes
include '../../includes/dbconnect.php'; //connectie met de database
include '../alert.php'; //include alerts

//zet de header zodat de tekens er niet meer raar uitzien
header('Content-Type: text/html; charset=ISO-8859-1');

//Kijk of er op de 'aanpassen' knop is gedrukt
if(isset($_POST['submit']) && !(empty($_POST['submit']))){
  //Kijk of er een error is gevonden tijdens het uploaden van de foto
  if ( $_FILES['fileToUpload']['error'] > UPLOAD_ERR_OK ){
    //
  }else{
    //als alles goed is gegaan kijk dan of er al een image was
    if(isset($_POST['image']) && !(empty($_POST['image']))){
      //als dat zo is verwijder deze foto dan
      if (!unlink(dirname(dirname( dirname(__FILE__) ) ) . "/images/commissiefotos/" . $_POST['image'])){
        print ("Error deleting ".$_POST['image']);
      }else{
        print ("Deleted ".$_POST['image']);
      }
    }
      //zet het bestand in een variabele
      $fileToUpload = $_FILES['fileToUpload']['name'];
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      //get het bestandssoort
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $newfilename= date('dmYHis')."-".str_replace(" ", "", basename($_FILES["fileToUpload"]["name"]));;
      $newfilename2 = '../../images/commissiefotos/'.$newfilename;

      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          $melding = "Bestand is geen foto.";
          $uploadOk = 0;
      }
      // Kijk of het bestand al bestaat
      if (file_exists($target_file)) {
          $melding = "Bestand bestaat al.";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
          $melding = "Bestand is te groot.";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          $melding = "Alleen jpg, png, jpeg en gif zijn toegestaan.";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        $_SESSION['error'] = "Er is een fout gevonden tijdens het uploaden van je bestand met error($melding)";
        $_SESSION['errorType'] = "danger";
        $_SESSION['errorAdd'] = "Let op!";
        header('Location: dispuutpagina');
        exit;
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename2)) {
              echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
  }
  //als er een nieuwe foto is geupload behoudt dan deze naam
  if(isset($newfilename)){
    //
  //is dat niet zo behoudt de vorige naam
  }else{
    $newfilename = $_POST['image'];
  }
  //de query voor het het aanpassen van commissie gegevens
  $stmt = $pdo->prepare("UPDATE commissie
      SET commissienaam=?, commissiezin=?, commissietekst=?, commissiebanner=?
  		WHERE commissieID=?");
  $stmt->execute(array($_POST['naam'],$_POST['zin'],$_POST['commissieTekst'],$newfilename,$_POST['commissieID']));
  unset($_POST);
  unset($_FILES);
  //succesmelding
  $_SESSION['error'] = "De commissie aanpassingen zijn succesvol ingevoerd";
  $_SESSION['errorType'] = "success";
  $_SESSION['errorAdd'] = "succes!";
  header('Location: commissiepagina');
}
//kijk of er errors gezet zijn zo ja voer dan de createerror functie uit (wordt geladen via alert.php) met de opgeslagen parameters
if(isset($_SESSION['error'])){
  print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
  //unset de error zodat hij niet vaker displayed
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
                <h1 id="pageLoc" class="commissiepagina">ZHTC aanpassen commissie pagina<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
              //query om alle commissie gegevens op te halen
              $stmt = $pdo->prepare("SELECT c.commissieID, commissienaam, commissievoorzitter, commissiezin, commissietekst, commissiebanner FROM commissie c
                WHERE c.commissievoorzitter = ?");
              $stmt->execute(array($_SESSION['lid']));
              $data = $stmt->fetchAll();
              foreach($data as $row) {
            ?>
            <div class="card">
              <div class="card-header">
                <h4 class="text-muted">Commissie <span class="badge badge-secondary zhtc-bg"><?php print($row['commissienaam']);?></span></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form id="getErrormess" action="commissiepagina" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="vraag" class="col-sm-2 col-form-label">Commissienaam:</label>
                            <div class="col-sm-10 px-0 pr-5">
                              <input readonly type="text" class="form-control" name="naam" value="<?php print($row['commissienaam']);?>">
                            </div>
                        </div>
                          <div class="form-group row">
                              <label for="vraag" class="col-sm-2 col-form-label">Commissiezin:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                <input  id="vraag" type="text" class="form-control" name="zin" value="<?php print($row['commissiezin']);?>" placeholder="De beste commissie van heel ZHTC" required>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="vraag" class="col-sm-2 col-form-label">Commissiebanner:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label class="custom-file align-top">
                                      <input type="file" id="file2" name="fileToUpload" class="custom-file-input">
                                      <span class="custom-file-control"></span>
                                    </label>
                                    <span class="text-muted" id="divFileName"></span>
                                  </div>
                                  <div class="col-sm-6">
                                    <span class="text-muted">Huidige banner:</span>
                                    <img src="../../images/commissiefotos/<?php print($row['commissiebanner']);?>" alt="Huidige banner" style="max-height:200px;" class="img-thumbnail">
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="imput-group row">
                              <label for="commissieText" class="col-sm-2 col-form-label">Commissietext:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                  <textarea class="nice-edit" name="commissieTekst" style="width: 100%; min-height:150px" required>
                                    <?php print($row['commissietekst']);?>
                                  </textarea>
                                  <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                              <div id="feedkeuze" class="invalid-feedback" hidden>
                              </div>
                              </div>
                          </div>
                          <hr>
                          <input type="hidden" name="commissieID" value="<?php print($row['commissieID']);?>">
                          <input type="hidden" name="image" value="<?php print($row['commissiebanner']);?>">
                          <div class="form-group row">
                            <div class="col-sm-12 px-0 pr-5">
                              <!-- 'aanpassen' knop -->
                              <input class="btn btn-outline-primary float-right" type="submit" name="submit" value="aanpassen">
                            </div>
                          </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <?php
            }
            ?>
        </main>
    </div>
</div>
</body>
</html>

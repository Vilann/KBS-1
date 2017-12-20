<?php
session_start();
include '../../includes/dbconnect.php';
header('Content-Type: text/html; charset=ISO-8859-1');
if(isset($_POST['submit']) && !(empty($_POST['submit']))){
  if(isset($_POST['image']) && !(empty($_POST['image']))){
    if (!unlink(dirname( dirname(__FILE__) ) . "/uploads/" . $_POST['image'])){
      //echo ("Error deleting ".$_POST['image']);
    }else{
      //echo ("Deleted ".$_POST['image']);
    }
  }
  $fileToUpload = $_FILES['fileToUpload']['name'];
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $newfilename= date('dmYHis')."-".str_replace(" ", "", basename($_FILES["fileToUpload"]["name"]));;
  $newfilename2 = '../uploads/'.$newfilename;
  //die($newfilename2);
  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
      //echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      //echo "File is not an image.";
      $uploadOk = 0;
  }
  // Kijk of het bestand al bestaat
  if (file_exists($target_file)) {
      //echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      //echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      //echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename2)) {
          //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
          //echo "Sorry, there was an error uploading your file.";
      }
  }
  $stmt = $pdo->prepare("UPDATE dispuut
      SET dispuutnaam=?, dispuutzin=?, dispuuttekst=?, dispuutbanner=?
  		WHERE dispuutID=?");
  $stmt->execute(array($_POST['naam'],$_POST['zin'],$_POST['dispuutTekst'],$newfilename,$_POST['dispuutID']));
  //print(htmlspecialchars($_POST['dispuutText']));
  //die("testico ".$_POST['naam']." ".$_POST['zin']." ".$_POST['dispuutTekst']." ".$_POST['dispuutID']);
  unset($_POST);
  unset($_FILES);
  $_SESSION['error'] = "testZIN!!!!!!!!!!!!!";
  $_SESSION['errorType'] = "danger";
  $_SESSION['errorAdd'] = "test!";
  header('Location: dispuutpagina');
}
?>
<html lang="en">
      <?php
      include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="dispuutpagina">ZHTC Aanpassen dispuut pagina<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
              $stmt = $pdo->prepare("SELECT d.dispuutID, dispuutnaam, dispuutvoorzitter, dispuutzin, dispuuttekst, dispuutbanner FROM dispuut d
                WHERE d.dispuutvoorzitter = ?");
              $stmt->execute(array($_SESSION['lid']));
              $data = $stmt->fetchAll();
              foreach($data as $row) {
            ?>
            <div class="card">
              <div class="card-header">
                <h4 class="text-muted">dispuut <span class="badge badge-secondary zhtc-bg"><?php print($row['dispuutnaam']);?></span></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form id="getErrormess" action="dispuutpagina" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="vraag" class="col-sm-2 col-form-label">dispuutnaam:</label>
                            <div class="col-sm-10 px-0 pr-5">
                              <input readonly type="text" class="form-control" name="naam" value="<?php print($row['dispuutnaam']);?>">
                            </div>
                        </div>
                          <div class="form-group row">
                              <label for="vraag" class="col-sm-2 col-form-label">dispuutzin:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                <input  id="vraag" type="text" class="form-control" name="zin" value="<?php print($row['dispuutzin']);?>" placeholder="De beste dispuut van heel ZHTC" required>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="vraag" class="col-sm-2 col-form-label">Dispuutbanner:</label>
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
                                    <img src="../uploads/<?php print($row['dispuutbanner']);?>" alt="Huidige banner" style="max-height:200px;" class="img-thumbnail">
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="imput-group row">
                              <label for="dispuutText" class="col-sm-2 col-form-label">dispuuttext:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                  <textarea class="nice-edit" name="dispuutTekst" style="width: 100%; min-height:150px" required>
                                    <?php print($row['dispuuttekst']);?>
                                  </textarea>
                                  <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                              <div id="feedkeuze" class="invalid-feedback" hidden>
                              </div>
                              </div>
                          </div>
                          <hr>
                          <input type="hidden" name="dispuutID" value="<?php print($row['dispuutID']);?>">
                          <input type="hidden" name="image" value="<?php print($row['dispuutbanner']);?>">
                          <div class="form-group row">
                            <div class="col-sm-12 px-0 pr-5">
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

<?php
include '../../includes/dbconnect.php';
header('Content-Type: text/html; charset=ISO-8859-1');
if(isset($_POST['submit']) && !(empty($_POST['submit']))){
  if(isset($_POST['image']) && !(empty($_POST['image']))){
    if (!unlink(dirname( dirname(__FILE__) ) . "/uploads/" . $_POST['image'])){
      echo ("Error deleting ".$_POST['image']);
    }else{
      echo ("Deleted ".$_POST['image']);
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
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      echo "File is not an image.";
      $uploadOk = 0;
  }
  // Kijk of het bestand al bestaat
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename2)) {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
  $stmt = $pdo->prepare("UPDATE commissie
      SET commissienaam=?, commissiezin=?, commissietekst=?, commissiebanner=?
  		WHERE commissieID=?");
  $stmt->execute(array($_POST['naam'],$_POST['zin'],$_POST['commissieTekst'],$newfilename,$_POST['commissieID']));
  //print(htmlspecialchars($_POST['commissieText']));
  //die("testico ".$_POST['naam']." ".$_POST['zin']." ".$_POST['commissieTekst']." ".$_POST['commissieID']);
  unset($_POST);
  unset($_FILES);
  header('Location: commissiepagina');
}
?>
<html lang="en">
      <?php
      include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="commissiepagina">ZHTC Aanpassen commissie pagina<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
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
                                    <img src="../uploads/<?php print($row['commissiebanner']);?>" alt="Huidige banner" style="max-height:200px;" class="img-thumbnail">
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

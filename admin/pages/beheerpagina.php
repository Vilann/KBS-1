<?php
include '../../includes/dbconnect.php';
header('Content-Type: text/html; charset=ISO-8859-1');
if(isset($_POST['edit']) && !(empty($_POST['edit']))){
  $stmt = $pdo->prepare("UPDATE commissie
      SET commissienaam=?, commissiezin=?, commissietekst=?
  		WHERE commissieID=?");
  $stmt->execute(array($_POST['naam'],$_POST['zin'],$_POST['commissieTekst'],$_POST['commissieID']));
  //print(htmlspecialchars($_POST['commissieText']));
  //die("testico ".$_POST['naam']." ".$_POST['zin']." ".$_POST['commissieTekst']." ".$_POST['commissieID']);
  unset($_POST);
}
?>
<html lang="en">
      <?php
      include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="beheerpagina">ZHTC Aanpassen commissie pagina<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
              $stmt = $pdo->prepare("SELECT c.commissieID, commissienaam, CONCAT(IFNULL(l2.voornaam,''),' ',IFNULL(l2.tussenvoegsel,''),' ',IFNULL(l2.achternaam,'')) AS naam, commissievoorzitter, commissiezin, commissietekst FROM commissie c
              JOIN commissielid cl ON c.commissieID = cl.commissieID
              JOIN lid l ON cl.lidID = l.lidID
              JOIN lid l2 ON c.commissievoorzitter = l2.lidID
              WHERE c.commissievoorzitter = ?");
              $stmt->execute(array($_SESSION['lid']));
              $data = $stmt->fetchAll();
              foreach($data as $row) {
                  //$id = $row['id'];
                  //$content = $row['content'];
            ?>
            <div class="card">
              <div class="card-header">
                <h4 class="text-muted">Commissie <span class="badge badge-secondary zhtc-bg"><?php print($row['commissienaam']);?></span></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form id="getErrormess" action="commissiepagina" method="post">
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
                          <div class="imput-group row">
                              <label for="commissieText" class="col-sm-2 col-form-label">Commissietext:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                  <textarea id="commissieText" name="commissieTekst" style="width: 100%; min-height:150px" required>
                                    <?php print($row['commissietekst']);?>
                                  </textarea>
                                  <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                              <div id="feedkeuze" class="invalid-feedback" hidden>
                              </div>
                              </div>
                          </div>
                          <hr>
                          <input type="hidden" name="commissieID" value="<?php print($row['commissieID']);?>">
                          <div class="form-group row">
                            <div class="col-sm-12 px-0 pr-5">
                              <input class="btn btn-outline-primary float-right" type="submit" name="edit" value="aanpassen">
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

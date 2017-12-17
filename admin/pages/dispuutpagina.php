<?php
include '../../includes/dbconnect.php';
header('Content-Type: text/html; charset=ISO-8859-1');
if(isset($_POST['edit']) && !(empty($_POST['edit']))){
  $stmt = $pdo->prepare("UPDATE dispuut
      SET dispuutnaam=?, dispuutzin=?, dispuuttekst=?
  		WHERE dispuutID=?");
  $stmt->execute(array($_POST['naam'],$_POST['zin'],$_POST['dispuutTekst'],$_POST['dispuutID']));
  //print(htmlspecialchars($_POST['dispuutText']));
  //die("testico ".$_POST['naam']." ".$_POST['zin']." ".$_POST['dispuutTekst']." ".$_POST['dispuutID']);
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
                <h1 id="pageLoc" class="dispuutpagina">ZHTC Aanpassen dispuut pagina<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <?php
              $stmt = $pdo->prepare("SELECT d.dispuutID, dispuutnaam, CONCAT(IFNULL(l2.voornaam,''),' ',IFNULL(l2.tussenvoegsel,''),' ',IFNULL(l2.achternaam,'')) AS naam, dispuutvoorzitter, dispuutzin, dispuuttekst FROM dispuut d
              JOIN dispuutlid dl ON d.dispuutID = dl.dispuutID
              JOIN lid l ON dl.lidID = l.lidID
              JOIN lid l2 ON d.dispuutvoorzitter = l2.lidID
              WHERE d.dispuutvoorzitter = ?");
              $stmt->execute(array($_SESSION['lid']));
              $data = $stmt->fetchAll();
              foreach($data as $row) {
                  //$id = $row['id'];
                  //$content = $row['content'];
            ?>
            <div class="card">
              <div class="card-header">
                <h4 class="text-muted">dispuut <span class="badge badge-secondary zhtc-bg"><?php print($row['dispuutnaam']);?></span></h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <form id="getErrormess" action="dispuutpagina" method="post">
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
                          <div class="imput-group row">
                              <label for="dispuutText" class="col-sm-2 col-form-label">dispuuttext:</label>
                              <div class="col-sm-10 px-0 pr-5">
                                  <textarea id="dispuutText" name="dispuutTekst" style="width: 100%; min-height:150px" required>
                                    <?php print($row['dispuuttekst']);?>
                                  </textarea>
                                  <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                              <div id="feedkeuze" class="invalid-feedback" hidden>
                              </div>
                              </div>
                          </div>
                          <hr>
                          <input type="hidden" name="dispuutID" value="<?php print($row['dispuutID']);?>">
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

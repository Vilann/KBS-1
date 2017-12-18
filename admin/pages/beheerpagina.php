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
            <ul id="tabs" class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item">
                <a class="nav-link active" href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Home</a>
              </li>
              <li role="presentation" class="nav-item">
                <a class="nav-link" href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">De vereniging</a>
              </li>
              <li role="presentation" class="nav-item">
                <a class="nav-link" href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Contact</a>
              </li>
              <li role="presentation" class="nav-item">
                <a class="nav-link" href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">footer</a>
              </li>
            </ul>
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="tab1"><br>
                <div class="card">
                  <div class="card-header">
                    <h4 class="text-muted">Bewerken <span class="badge badge-secondary zhtc-bg">Home</span></h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <form id="getErrormess" action="commissiepagina" method="post">
                            <div class="form-group row">
                                <label for="vraag" class="col-sm-2 col-form-label">Titel:</label>
                                <div class="col-sm-10 px-0 pr-5">
                                  <input type="text" class="form-control" name="naam" value="Home">
                                </div>
                            </div>
                              <div class="imput-group row">
                                  <label for="commissieText" class="col-sm-2 col-form-label">Paginatext:</label>
                                  <div class="col-sm-10 px-0 pr-5">
                                      <textarea id="commissieText" name="commissieTekst" style="width: 100%; min-height:150px" required>
                                      </textarea>
                                      <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                                  <div id="feedkeuze" class="invalid-feedback" hidden>
                                  </div>
                                  </div>
                              </div>
                              <hr>
                              <input type="hidden" name="commissieID" value="1">
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
              </div>

              <div role="tabpanel" class="tab-pane" id="tab2">
                <br>
                <div class="card">
                  <div class="card-header">
                    <h4 class="text-muted">Bewerken <span class="badge badge-secondary zhtc-bg">De vereniging</span></h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <form id="getErrormess5" action="commissiepagina" method="post">
                            <div class="form-group row">
                                <label for="vraag" class="col-sm-2 col-form-label">Titel:</label>
                                <div class="col-sm-10 px-0 pr-5">
                                  <input type="text" class="form-control" name="naam" value="De vereniging">
                                </div>
                            </div>
                              <div class="imput-group row">
                                  <label for="commissieText" class="col-sm-2 col-form-label">Paginatext:</label>
                                  <div class="col-sm-10 px-0 pr-5">
                                      <textarea name="commissieTekst" style="width: 853%; height:150px" required>
                                      </textarea>
                                      <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                                  </div>
                              </div>
                              <hr>
                              <input type="hidden" name="commissieID" value="1">
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

              </div>
              <div role="tabpanel" class="tab-pane" id="tab3">
                <br>
                <div class="card">
                  <div class="card-header">
                    <h4 class="text-muted">Bewerken <span class="badge badge-secondary zhtc-bg">Contact</span></h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <form id="getErrormess3" action="commissiepagina" method="post">
                            <div class="form-group row">
                                <label for="vraag" class="col-sm-2 col-form-label">Titel:</label>
                                <div class="col-sm-10 px-0 pr-5">
                                  <input type="text" class="form-control" name="naam" value="Contact">
                                </div>
                            </div>
                              <div class="imput-group row">
                                  <label for="commissieText" class="col-sm-2 col-form-label">Paginatext:</label>
                                  <div class="col-sm-10 px-0 pr-5">
                                      <textarea name="commissieTekst" style="width: 853%; height:150px" required>
                                      </textarea>
                                      <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                                  </div>
                              </div>
                              <hr>
                              <input type="hidden" name="commissieID" value="1">
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
              </div>
              <div role="tabpanel" class="tab-pane" id="tab4">
                <br>
                <div class="card">
                  <div class="card-header">
                    <h4 class="text-muted">Bewerken <span class="badge badge-secondary zhtc-bg">Footer</span></h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <form id="getErrormess2" action="commissiepagina" method="post">
                            <div class="form-group row">
                                <label for="vraag" class="col-sm-2 col-form-label">Titel:</label>
                                <div class="col-sm-10 px-0 pr-5">
                                  <input type="text" class="form-control" name="naam" value="Footer">
                                </div>
                            </div>
                              <div class="imput-group row">
                                  <label for="commissieText" class="col-sm-2 col-form-label">Paginatext:</label>
                                  <div class="col-sm-10 px-0 pr-5">
                                      <textarea name="commissieTekst" style="width: 853%; height:150px" required>
                                      </textarea>
                                      <small class="form-text text-muted">Met de texteditor hierboven kun je de pagina stylen zoals je wilt</small>
                                  </div>
                              </div>
                              <hr>
                              <input type="hidden" name="commissieID" value="1">
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
              </div>
            </div>
            <br>
        </main>
    </div>
</div>
</body>
</html>

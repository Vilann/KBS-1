<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Profiel (Naam)</title>
        <?php include 'includes/header.php'; ?>


    <body>
      <div class="container-fluid">
        <div class="row name_banner">
          <div class="col">
            <div class="media">
              <img class="align-self-center mr-3" src="http://via.placeholder.com/150x150" alt="Generic placeholder image">
              <div class="media-body vcenter">
                <h5 class="mt-0">Voornaam (tussenvoegsel) Achternaam</h5>
                <p class="mb-0">Lid sinds: <span class="text-muted">23-06-2000</span></p>
                <p class="mb-0 text-muted">banaanlid</p>
                <p class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-7">
              <h3>
                Persoonlijke Gegevens
              </h3>
              <i class="fa fa-paper-plane" area-hidden="true"></i>
              <form>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Naam:</label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-5 px-1">
                          <input type="text" class="form-control" value="Jacob" placeholder="Voornaam" readonly>
                        </div>
                        <div class="col-2 px-1">
                          <input type="text" class="form-control" value="van" placeholder="Tussvgsl..." readonly>
                        </div>
                        <div class="col-5 px-1">
                          <input type="text" class="form-control" value="Steen" placeholder="Achternaam" readonly>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Geboortedatum:</label>
                    <div class="col-sm-9 px-0">
                      <input type="date" class="form-control" id="inputPassword" value="23-05-1988" placeholder="23-02-1970" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Geslacht:</label>
                    <div class="col-sm-9 px-0">
                      <select id="inputState" class="form-control" readonly>
                        <option selected>Man</option>
                        <option>...</option>
                      </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Locatie:</label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-12 px-0">
                        <input type="text" class="form-control" value="Testlaan 12" placeholder="Adres" readonly>
                      </div>
                    </div>
                  </div>
                  <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-8 px-0">
                        <input type="text" class="form-control" value="Zwolle" placeholder="Woonplaats" readonly>
                      </div>
                      <div class="col-4 px-0">
                        <input type="text" class="form-control" value="1337GG" placeholder="Postcode" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">E-mail adres:</label>
                    <div class="col-sm-9 px-0">
                      <input type="text" class="form-control" id="inputPassword" value="email@gmail.com" placeholder="email@voorbeeld.nl" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Noodnummer:</label>
                    <div class="col-sm-9 px-0">
                      <input type="text" class="form-control" id="inputPassword" value="0612345678" placeholder="0612345678" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Aanpassen</button>
              </form>
            </div>
            <div class="col-sm-12 col-xs-12 col-md-5">
              <h3>
                Disputen
              </h3>
            </div>
          </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col">

          </div>
        </div>
      </div>
    </body>
</html>

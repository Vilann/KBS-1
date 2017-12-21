<?php
include('includes/beveiliging.php');
beveilig_lid();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Registreren</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <?php include 'includes/header.php';
    if (isset($_GET['succes'])) {
        ?>
        <div class="container-fluid">
          <div class="wrapper mx-auto width-60 mt-5">
            <h2 class="align-middle"><span class="font-weight-light align-middle"><span class="badge badge-success">Succes!</span></span></h2>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <p class="text-center text-muted font-weight-light mx-auto"> U krijgt binnen enkele minuten een mail met een activatiecode.</p>
          </div>
          <div class="row">
          </div>
        </div>
        <?php
    } elseif (isset($_GET['token'])) {
        include("includes/dbconnect.php");
        // Voeg toe melding voor als je je account geactiveerd hebt.
        $email=$_GET['email'];
        $token=$_GET['token'];
        $stmt = $pdo->prepare("SELECT lidID FROM lid WHERE emailadres=? AND token=?");
        $stmt->execute(array($email,$token));
        if ($stmt->RowCount()>0) {
            $id = $stmt->fetch(PDO::FETCH_ASSOC)["lidID"];
            print($id);
            $stmt = $pdo->prepare("UPDATE lid SET inactief='0', token = NULL WHERE lidID = ?");
            $stmt->execute(array($id));
            if ($stmt->RowCount()>0) {
                print('Uw account is geactiveerd,  <a href="login">klik hier</a> om in te loggen');
            }
        }
        $pdo = null;
    } else {
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        if (isset($_SESSION["error"])) {
            $error = explode(",", $_SESSION["error"]);
            switch ($error[0]) {
          case "email":
            $errormess = $error[1];
          break;
          case "noodnummer":
          //
          break;
        }
            unset($_SESSION["error"]);
        } ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 id="getError" class="<?php print($error[0]); ?>">Registreer</h1>
          <p id="getErrormess" class="<?php print($error[1]); ?>">Hier kun je je inschrijven voor ZHTC. Bij opgave ga je akkoord met onze
            <b><a href="files/privacyvoorwaarden.pdf">privacyvoorwaarden</a></b> en ga je ermee akkoord dat we &euro;25
            contributie per halfjaar van je rekening halen.</p>
            <p class="belangrijk">De velden met een * zijn verlicht.</p>
        </div>
      <div class="col-sm-12 col-xs-12 col-md-6">
    <form action="verwerk" method="post">
          <div class="form-group row">
              <label for="voornaam" class="col-sm-3 col-form-label">* Voornaam:</label>
              <div class="col-sm-9 px-0">
                <input  id="voornaam" type="text" class="form-control" name="voornaam" placeholder="Voornaam" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="tussenvoegsel" class="col-sm-3 col-form-label">Tussenvoegsel:</label>
              <div class="col-sm-3 px-0">
                <input  id="tussenvoegsel" type="text" class="form-control" name="tussenvoegsel" placeholder="Tussenvoegsel">
              </div>
          </div>
          <div class="form-group row">
              <label for="achternaam" class="col-sm-3 col-form-label">* achternaam:</label>
              <div class="col-sm-9 px-0">
                <input  id="achternaam" type="text" class="form-control" name="achternaam" placeholder="Achternaam" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="geboortedatum" class="col-sm-3 col-form-label">* geboortedatum:</label>
              <div class="col-sm-9 px-0">
                <input  id="geboortedatum" type="date" class="form-control" name="geboortedatum" placeholder="geboortedatum" max=<?php print('"' . date('Y-m-d', strtotime("-16 year")) . '"'); ?> required>
                <div id="feedgeboortedatum" class="invalid-feedback" hidden>
                </div>
              </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">* Locatie:</label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-12 px-0">
                  <input type="text" class="form-control" name="adres" placeholder="Adres">
                </div>
              </div>
            </div>
            <label for="inputPassword" class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-8 px-0">
                  <input type="text" class="form-control" name="woonplaats" placeholder="Woonplaats">
                </div>
                <div class="col-4 px-0">
                  <input type="text" class="form-control" name="postcode" placeholder="Postcode" >
                </div>
              </div>
            </div>
          </div>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-legend col-sm-3">* Geslacht</legend>
              <div class="col-sm-9">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="man" checked>
                    Man
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="vrouw">
                    Vrouw
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="anders">
                    Geen van bovenstaande
                  </label>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group row">
              <label for="rekening" class="col-sm-3 col-form-label">* Rekeningnummer:</label>
              <div class="col-sm-9 px-0">
                <input  id="rekening" type="text" class="form-control" name="iban" placeholder="NL12RABO0123456789" required>
                <div id="feediban" class="invalid-feedback" hidden>
                </div>
              </div>
              <!-- NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai -->
          </div>
          <div class="form-group row">
              <label for="noodnummer" class="col-sm-3 col-form-label">* Noodnummer:</label>
              <div class="col-sm-9 px-0">
                <input  id="noodnummer" type="text" class="form-control" name="noodnummer" placeholder="06 123 45 678" required>
                <div id="feednoodnummer" class="invalid-feedback" hidden>
                </div>
              </div>
          </div>
          <div class="form-group row">
            <label for="tshirt" class="col-sm-3 col-form-label">* T-shirtmaat:</label>
            <div class="col-sm-9 px-0">
              <select id="tshirt" class="form-control" name="maat" required>
                <option selected disabled>Kies T-shirtmaat...</option>
                <option value="xs"> XS </option>
                <option value="s"> S </option>
                <option value="m"> M </option>
                <option value="l"> L </option>
                <option value="xl"> XL </option>
                <option value="xxl"> XXL </option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="Medicatie:" class="col-sm-3">Medicatie:</label>
            <div class="col-sm-9 px-0">
              <textarea class="form-control" id="Medicatie" name="medicatie" rows="4" placeholder="Ik gebruik deze medicatie"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="dieetwensen:" class="col-sm-3">Dieetwensen:</label>
            <div class="col-sm-9 px-0">
              <textarea class="form-control" id="dieetwensen" name="dieetwensen" rows="4" placeholder="Ik ... lust geen chocola. Ik ... ben allergisch voor gluten"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="opmerking:" class="col-sm-3">Opmerking:</label>
            <div class="col-sm-9 px-0">
              <textarea class="form-control" id="opmerking" rows="4" name="opmerking" placeholder="Wil je nog wat kwijt?"></textarea>
            </div>
          </div>
          <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label">* Emailadres:</label>
              <div class="col-sm-9 px-0">
                <input  id="email" type="email" class="form-control" name="email" placeholder="voorbeeld@email.nl" required>
                <div id="feedemail" class="invalid-feedback" hidden>
                </div>
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="wachtwoord">* Wachtwoord:</label>
              <div class="col-sm-9 px-0">
              <input type="password" id="wachtwoord" class="form-control" name="wachtwoord" aria-describedby="passwordHelpBlock">
              <div id="feedwachtwoord" class="invalid-feedback" hidden>
              </div>
              <small id="passwordHelpBlock" class="form-text text-muted">
              Je wachtwoord moet 8-60 karakters lang zijn, moet letters en nummers bevatten, en mag geen spaties bevatten.
              </small>
            </div>
          </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label" for="herhaalwachtwoord">* Herhaal wachtwoord:</label>
                <div class="col-sm-9 px-0">
                <input type="password" id="herhaalwachtwoord" class="form-control" name="herhaalwachtwoord">
                <div id="feedherhaalwachtwoord" class="invalid-feedback" hidden>
                </div>
              </div>
          </div>

          <div class="form-group row">
            <div class="g-recaptcha col-sm-9 offset-sm-3 px-0" data-sitekey="6Ld7nTsUAAAAADXHtsQJLwU-Zt1wcQ_ysEB9B0Dz"></div>
          </div>
          <?php
          error_reporting(E_ERROR | E_WARNING | E_PARSE);

        if (isset($_SESSION['captchamelding'])) {
            print('<p>' . $_SESSION['captchamelding'] . '</p>');
            unset($_SESSION["captchamelding"]);
        } ?>
          <div class="form-group row">
            <div class="col-sm-9 offset-sm-3 px-0">
              <input class="btn btn-outline-primary" type="submit" name="registreer" value="Registreer">
            </div>
          </div>
          <!-- NOTE: door op deze knop te drukken wordt al deze info gestopt in de value registreer. *zie verwerk Gr Kai -->
    </form>
  </div>
  </div>
  </div>
<?php
    } ?>
  <script>
  <?php include 'includes/script.js'; ?>
<?php include("includes/footer.php"); ?>

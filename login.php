<?php
include('includes/beveiliging.php');
beveilig_lid();
include 'includes/dbconnect.php';
if (isset($_SESSION['lid'])) {
    header("Location: index");
} else {
    ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Login</title>

    <?php include 'includes/header.php';
    if (isset($_GET['dp']) && !(empty($_GET['dp']))) {
        ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-5 mr-md-5">
        <h3 id="getError" class="<?php print($error[0]); ?>">Wachtwoord vergeten</h3>
        <p class="text-muted">Vul hier je emailadres in om je wachtwoord te herstellen.</p>
        <form id="getErrormess" class="<?php print($error[1]); ?>" action="verwerk" method="post">
          <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label">Email:</label>
              <div class="col-sm-9 px-0">
                <input  id="email" type="email" class="form-control" name="email" placeholder="Emailadres" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label"> Bevestig email:</label>
              <div class="col-sm-9 px-0">
                <input  id="email" type="email" class="form-control" name="email" placeholder="Emailadres" required>
              </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-9 offset-sm-3 px-0">
              <input class="btn btn-outline-primary" type="submit" name="wwreset" value="Verzenden">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


<?php
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
        <div class="col-md-12 col-lg-5 mr-md-5">
      <h1 id="getError" class="<?php print($error[0]); ?>">Log in</h1>
      <p class="text-muted">Welkom bij ZHTC vul je gegevens in om in te loggen</p>
      <form id="getErrormess" class="<?php print($error[1]); ?>" action="verwerk" method="post">
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-9 px-0">
                  <input  id="email" type="email" class="form-control" name="email" placeholder="Emailadres" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="wachtwoord" class="col-sm-3 col-form-label">Wachtwoord:</label>
                <div class="col-sm-9 px-0">
                  <input  id="wachtwoord" type="password" class="form-control" name="wachtwoord" placeholder="Wachtwoord" value="" required>
                  <div id="feedwachtwoord" class="invalid-feedback" hidden>
                  </div>
                </div>
            </div>
            <?php
            $ip= $_SERVER['REMOTE_ADDR'];
        $stmt=$pdo->prepare("SELECT Count(*) as failed
                FROM   loginpoging
                WHERE  tijd > Date_sub(Now(), INTERVAL 15 minute) and  ip=?");
        $stmt->execute(array($ip));
        $pogingen = $stmt->fetch(PDO::FETCH_ASSOC);
        // die($pogingen['testbanaan']);
        if ($pogingen['failed']>=3) {
            print('3 Foute inlogpogingen,probeer straks <a href="login">opnieuw</a>');
            unset($_SESSION["failed"]);
        } else {
            print('
            <div class="form-group row">
              <label for="ingelogdblijven" class="col-sm-3 col-form-label">Ingelogd blijven:</label>
              <div class="my-auto px-0">
               <input type="checkbox" id="ingelogdblijven" class="form-control" name="ingelogdblijven" value="Ja">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3 px-0">
                <input class="btn btn-outline-primary" type="submit" name="login" value="Inloggen">
              </div>

              <div class="col-sm-9 offset-sm-3 px-0">
                <a href = "?dp=hoi" class="float-left">Wachtwoord vergeten</a></p>
              </div>
            </div>

');
        } ?>

            <hr>
        <p>
          <b>Nog geen lid?</b> <br>
          Wil jij lid worden van ZHTC? <br>
          Klik <a href="registreer">hier</a>
        </p>
      </form>
    </div>
  </div>
  </div>

<?php
    }
    include("includes/footer.php");
}
 ?>

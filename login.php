<?php
include('includes/beveiliging.php');
beveilig_lid();
if (isset($_SESSION['lid'])) {
    header("Location: index");
} else {
    ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Login</title>

    <?php include 'includes/header.php';
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
                  <input  id="email" type="email" class="form-control" name="email" placeholder="ZHTC-emailadres" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="wachtwoord" class="col-sm-3 col-form-label">Wachtwoord:</label>
                <div class="col-sm-9 px-0">
                  <input  id="wachtwoord" type="password" class="form-control" name="wachtwoord" value="" required>
                  <div id="feedwachtwoord" class="invalid-feedback" hidden>
                  </div>
                </div>
            </div>
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
            </div>
            <?php if ($_SESSION['failed']) {
        print "banaan kan niet inloggen";
        unset($_SESSION["failed"]);
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
  </body>
</html>
<?php
}
 ?>

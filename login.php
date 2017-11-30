<?php
include('includes/beveiligd.php');
if (isset($_SESSION['lid'])) {
    header("Location: index");
} else {
    ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Login</title>

    <?php include 'includes/header.php' ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-5">
      <h1>Log in</h1>
      <p class="text-muted">Welkom bij ZHTC vul je gegevens in om in te loggen</p>
      <form action="verwerk" method="post">
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-9 px-0">
                  <input  id="email" type="email" class="form-control" name="email" placeholder="ZHTC-emailadres" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Wachtwoord" class="col-sm-3 col-form-label">Wachtwoord:</label>
                <div class="col-sm-9 px-0">
                  <input  id="Wachtwoord" type="password" class="form-control" name="wachtwoord" value="" required>
                </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3 px-0">
                <input class="btn btn-outline-primary" type="submit" name="login" value="Inloggen">
              </div>
            </div>
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

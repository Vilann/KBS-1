<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Contact</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php include 'includes/header.php';
            include 'includes/dbconnect.php';
           ?>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-lg-5 mr-md-5">
        <h1 id="getError">Contactformulier</h1>
        <p class="text-muted">Wilt u contact opnemen met ZHTC? Dat kan, vul dit formuliertje in.</p>
        <form id="getErrormess" action="verwerk" method="post">
              <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email:</label>
                  <div class="col-sm-9 px-0">
                    <input  id="email" type="email" class="form-control" name="email" placeholder="Uw emailadres" required>
                  </div>
              </div>
              <div class="form-group row">
                  <label for="wachtwoord" class="col-sm-3 col-form-label">Naam:</label>
                  <div class="col-sm-9 px-0">
                    <input  id="naam" type="text" class="form-control" name="naam" value="" placeholder="Uw naam" required>
                  </div>
              </div>
              <div class="form-group row">
                <label for="bericht" class="col-sm-3 col-form-label">Bericht:</label>
                <div class="col-sm-9 px-0">
                 <textarea id="bericht" class="form-control" name="bericht" rows="8" cols="63" placeholder="Uw vragen, opmerkingen, tips e.d." required></textarea>
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
              }
              ?>
              <div class="form-group row">
                <div class="col-sm-9 offset-sm-3 px-0">
                    <input class="btn btn-outline-primary" type="submit" name="contact" value="Verstuur">
                </div>
              </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2427.997172364323!2d6.100033315984932!3d52.515390244322994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7df3c9a5bcfe1%3A0x907105d2484be27f!2sAlgemene+Studentenvereniging+ZHTC!5e0!3m2!1snl!2snl!4v1511780795999" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

    </div>
    </div>


    </body>
</html>

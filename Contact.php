<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Contact</title>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php include 'includes/header.php';
            include 'includes/dbconnect.php';
           ?>


    <body>
      <div class="container">
        <div class="row">
          <div class="col">
            <h1>Contactformulier</h1>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2427.997172364323!2d6.100033315984932!3d52.515390244322994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7df3c9a5bcfe1%3A0x907105d2484be27f!2sAlgemene+Studentenvereniging+ZHTC!5e0!3m2!1snl!2snl!4v1511780795999" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          <p></p>
        </div>
          <div class="col">
            <form Method="POST" Action='contactverwerk'>
              <?php
                        //                 error_reporting(E_ERROR | E_WARNING | E_PARSE);
                        // if (!isset($_SESSION['lid'])) {
                        //     require_once('includes/captcha/recaptchalib.php');
                        //     $publickey = "6Ld7nTsUAAAAADXHtsQJLwU-Zt1wcQ_ysEB9B0Dz"; // you got this from the signup page
                        //     echo recaptcha_get_html($publickey);
                        // }
  ?>
              <table>
                <tr>
                  <td><label class="col-sm-4 col-form-label" for="contactmail">Emailadres:</label></td>
                  <td><input class="form-control" id="contactmail" type="mail" name="contactmail" placeholder="Uwmailadres@voorbeeld.com" required></td>
                </tr>
                <tr>
                  <td><label class="col-sm-4 col-form-label" for="contactnaam">Naam:</label></td>
                  <td><input class="form-control" id="contactnaam" type="text" name="contactnaam" placeholder="Uw naam" required></td>
                </tr>
                <tr class="col-sm-4 px-0">
                  <td><label class="col-sm-4 col-form-label" for="contactbericht">Bericht:</label></td>
                  <td><textarea class="form-control" id="contactbericht" name="contactbericht" placeholder="Uw vragen, opmerkingen of tips" required></textarea></td>
                </tr>
              </table>
              <div class="form-group row">
                <div class="col-sm-9 offset-sm-3 px-0">
                <input class="btn btn-outline-primary" type="submit" name="verzend" value="Verzend">
              </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-9 offset-sm-3 px-0">
          <php? 	<?php
                                    error_reporting(E_ERROR | E_WARNING | E_PARSE);
                    if (!isset($_SESSION['lid'])) {
                        ?> <div class="g-recaptcha" data-sitekey="6Ld7nTsUAAAAADXHtsQJLwU-Zt1wcQ_ysEB9B0Dz"></div>
                <?php
                    }
                ?>
          </div>
          </div>
          ?>

            </form>
                    </div>
                  </div>
                  </div>
            <h4>CONTACT INFO
</h1>
<h6>
  ADDRESS
</h6>
<p>
  Postbus 1475, 8001 BL, Zwolle
</p>
<h6>
  EMAIL
</h6>
<p>secretariaat@zhtc.nl</p>





    </body>
</html>

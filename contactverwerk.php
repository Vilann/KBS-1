<?php
 session_start();
//  require_once('includes/captcha/recaptchalib.php');
  $privatekey = "6Ld7nTsUAAAAALPpQKrdXPI3nJnSF11aSBmvx6HF";
//  $resp = recaptcha_check_answer(
//      $privatekey,
//                                $_SERVER["REMOTE_ADDR"],
//                                $_POST["recaptcha_challenge_field"],
//                                $_POST["recaptcha_response_field"]
//  );
//
//  if (!$resp->is_valid) {
//      // What happens when the CAPTCHA was entered incorrectly
//      header("Location: contact");
//      die("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
//         "(reCAPTCHA said: " . $resp->error . ")");
//  } else {
//      if (isset($_POST['verzend']) && isset($_POST['contactmail']) && isset($_POST['contactnaam']) && isset($_POST['contactbericht'])) {
//          $naam = $_POST['contactnaam'];
//          $emailadres = $_POST['contactmail'];
//          $bericht = $_POST['contactbericht'];
//          $zhtcmailadres = "Iemands@emailadres.com";
//          $onderwerp = "Een mail van $naam";
//          $mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
//          $header= 'From: $emailadres' ."/r/n".
//        'Reply-To: $zhtcmailadres' ."/r/n".
//          'X-Mailer: PHP/' . phpversion();
//          mail($zhtcmailadres, $onderwerp, $mailbericht, $header);
//      };
//  }
if (isset($_POST['contact'])) {
    include("includes/mail.php");
    $naam = $_POST['contactnaam'];
    $emailadres = $_POST['contactmail'];
    $bericht = $_POST['contactbericht'];
    mail_contact($emailadres, $naam, $bericht);
}





  if ((isset($_POST['verzend']))) {
      $recaptchaAntwoord = $_POST['g-recaptcha-response'];
      $opvraag = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$recaptchaAntwoord."&remoteip=".$_SERVER['REMOTE_ADDR']);

      $obj = json_decode($opvraag);
      if ($obj->success == true && isset($_POST['contactmail']) && isset($_POST['contactnaam']) && isset($_POST['contactbericht'])) {
          include("includes/mail.php");
          $naam = $_POST['contactnaam'];
          $emailadres = $_POST['contactmail'];
          $bericht = $_POST['contactbericht'];
          mail_contact($emailadres, $naam, $bericht);
      } else {
          session_start();
          $_SESSION['captchaerror']=true;
          header("Location: contact");
      }
  }

//          }//passes test
//      } else {
//          if (!strstr($opvraag, "false")) {
//              print '<div class="notification error clearfix"><p><strong>Attention!</strong> You didnt complete the captcha.</p></div>';
//          }    //error handling
//      }
//
//      if (!strstr($opvraag, "false")) {
//          print '<div class="notification error clearfix"><p><strong>Attention!</strong> You didnt complete the captcha.</p></div>';
//      } else {
//      }

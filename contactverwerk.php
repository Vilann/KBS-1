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
//

    $sender_name = stripslashes($_POST["contactnaam"]);
    $sender_email = stripslashes($_POST["contactmail"]);
    $sender_message = stripslashes($_POST["contactbericht"]);
    $response = $_POST["g-recaptcha-response"];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6Ld7nTsUAAAAALPpQKrdXPI3nJnSF11aSBmvx6HF',
        'response' => $_POST["g-recaptcha-response"]
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success=json_decode($verify);
    if ($captcha_success->success==false) {
        echo "<p>You are a bot! Go away!</p>";
    } elseif ($captcha_success->success==true) {
        echo "<p>You are not not a bot!</p>";
        session_start();
        $_SESSION['captchasucces']="captcha is gelukt";
    }

  if ((isset($_POST['verzend'])) && (isset($_SESSION['lid']))) {
      $naam = $_POST['contactnaam'];
      $emailadres = $_POST['contactmail'];
      $bericht = $_POST['contactbericht'];
      $zhtcmailadres = "Iemands@emailadres.com";
      $onderwerp = "Een mail van $naam";
      $mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
      mail($zhtcmailadres, $onderwerp, $mailbericht, $header);
  } else {
      $recaptchaAntwoord = $_POST['g-recaptcha-response'];
      $opvraag = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$recaptchaAntwoord."&remoteip=".$_SERVER['REMOTE_ADDR']);

      $obj = json_decode($opvraag);
      if ($obj->success == true) {
          if (isset($_POST['verzend']) && isset($_POST['contactmail']) && isset($_POST['contactnaam']) && isset($_POST['contactbericht'])) {
              $naam = $_POST['contactnaam'];
              $emailadres = $_POST['contactmail'];
              $bericht = $_POST['contactbericht'];
              $zhtcmailadres = "Iemands@emailadres.com";
              $onderwerp = "Een mail van $naam";
              $mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
              mail($zhtcmailadres, $onderwerp, $mailbericht, $header);
              // session_start();
              // $_SESSION['captchasucces']="captcha is gelukt";
              // header("Location: contact");
          }
      } else {
          // session_start();
          // $_SESSION['captchaerror']=true;
          // header("Location: contact");
      }
  }

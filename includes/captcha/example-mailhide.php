<html><body>
<?php
require_once("recaptchalib.php");

// get a key at http://www.google.com/recaptcha/mailhide/apikey
$mailhide_pubkey = '01F_7DtjD9qwvXkMu5Tax9Gw==';
$mailhide_privkey = '332138d0eaf4955d60936016d5f243e0';

?>

The Mailhide version of example@example.com is
<?php echo recaptcha_mailhide_html($mailhide_pubkey, $mailhide_privkey, "example@example.com"); ?>. <br>

The url for the email is:
<?php echo recaptcha_mailhide_url($mailhide_pubkey, $mailhide_privkey, "example@example.com"); ?> <br>

</body></html>

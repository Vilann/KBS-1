<?php
$salt = random_bytes(60);
$ww = "waaaachtwoord";
$hashed = password_hash($salt . $ww, PASSWORD_BCRYPT);
print($hashed . "<br> ");
print(password_hash($salt . "waaaachtwoord", PASSWORD_BCRYPT));

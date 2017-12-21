<?php
// Voeg toe melding voor als je je account geactiveerd hebt.
$hash = '$2y$10$T68fUqddhRjjERKVbDjdI.zwpKl4pZN9Nu2CHpDyuWmTov1z0QHhS';
$ww = password_hash("Login12345", PASSWORD_BCRYPT);
print($hash . "<br>");
print($ww);
if ($hash == $ww) {
    print("Succes");
} else {
    print("NOPE");
}

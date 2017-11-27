<?php

$db = "mysql:host=localhost;dbname=ZHTC;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);
// We halen het wachtwoord op van het lid met het lidID dat bij het emailadres staat.
$stmt = $pdo->prepare("INSERT INTO login (lidID, wachtwoord, datecreated)
                       VALUES (?,?,?)");
$stmt->execute(array(1, password_hash("geheimwachtwoord", PASSWORD_BCRYPT), date("Y-m-d")));

//|| empty ($emailadres) || (empty ($bericht))

<?php
$db = "mysql:host=localhost;dbname=ZHTC;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

$stmt = $pdo->prepare("UPDATE lid SET wachtwoord = ? WHERE lidID = 1");
$stmt->execute(array(password_hash("geheimwachtwoord", PASSWORD_BCRYPT)));

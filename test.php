<?php
include 'includes/dbconnect.php';

$stmt = $pdo->prepare("UPDATE lid SET wachtwoord = ? WHERE lidID = 1");
$stmt->execute(array(password_hash("geheimwachtwoord", PASSWORD_BCRYPT)));

<?php
// Voeg toe melding voor als je je account geactiveerd hebt.
include("includes/dbconnect.php");
$email= "jelle.santema@gmail.com";
$token="713bbe114130d5954ed3d56e3ec57cab";
try {
    $stmt = $pdo->prepare("SELECT lidID FROM lid WHERE emailadres=? AND token=?");

    $stmt->execute(array($email,$token));
} catch (PDOException $e) {
    die($e);
}

if ($stmt->RowCount() > 0) {
    $id = $stmt->fetch(PDO::FETCH_ASSOC)["lidID"];
    print($id);
    $stmt = $pdo->prepare("UPDATE lid SET inactief = 0, token = NULL WHERE lidID = ?");
    $stmt->execute(array($id));
    if ($stmt->RowCount()>0) {
        print('Uw account is geactiveerd,  <a href="login">klik hier</a> om in te loggen');
    }
} else {
    print("Fout!");
}

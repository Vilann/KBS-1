<?php
include 'includes/dbconnect.php';




$stmt = $pdo->prepare("SELECT * FROM lid WHERE emailadres=?");
$stmt->execute(array($id));
$id = $stmt->fetch(PDO::FETCH_ASSOC);
$lidID=$id['lidID'];
$email=$id['emailadres'];
$hashed_expected= hash_hmac("sha256", $lidID, $email, false);
$token=hash_hmac("sha256", $lidID, $_POST['email'], false);
print $token;
print "<br>";
print $hashed_expected;

if (hash_equals($hashed_expected, $token)) {
    echo 'Your account is activated, please <a href="index.php">click here</a> to to login';
} else {
    echo "Invalid activation key!";
}

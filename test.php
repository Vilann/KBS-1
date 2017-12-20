<?php
include 'includes/dbconnect.php';




$hash=rand(0, 10000);
$token= hash_hmac("sha256", $hash, "banaan@email.com", false);
print $token;

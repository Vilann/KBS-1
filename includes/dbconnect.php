<?php
try {
    $db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
    $user = "root";
    $pass = "usbw";
    $pdo = new PDO($db, $user, $pass);
} catch (PDOException $e) {
    echo $e->getTraceAsString();
}

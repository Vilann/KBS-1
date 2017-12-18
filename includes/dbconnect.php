<?php
try {
    $db = "mysql:host=localhost;dbname=zhtc;port=3306";
    $user = "root";
    $pass = "";
    $pdo = new PDO($db, $user, $pass);
} catch (PDOException $e) {
    echo $e->getTraceAsString();
}

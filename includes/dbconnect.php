<?php
try {
<<<<<<< HEAD
	$db = "mysql:host=localhost;dbname=zhtc;port=3306";
	$user = "root";
	$pass = "";
	$pdo = new PDO($db, $user, $pass);
}
catch (PDOException $e) {
echo $e->getTraceAsString();
=======
    $db = "mysql:host=localhost;dbname=zhtc;port=3306";
    $user = "root";
    $pass = "";
    $pdo = new PDO($db, $user, $pass);
} catch (PDOException $e) {
    echo $e->getTraceAsString();
>>>>>>> b37c2c78df3625e351ab3b94f55f3bde5e9204f3
}

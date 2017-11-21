<?php
if (($naam = filter_input(INPUT_POST, 'naam')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
    $db = "mysql:host=localhost;dbname=kbs;port=3306";
    $user = "root";
    $pass = "";
    $pdo = new PDO($db, $user, $pass);
    $stmt = $pdo->prepare("SELECT wachtwoord FROM gebruiker WHERE naam=?");
    $stmt->execute(array($naam));
    if ($stmt->fetch() == $ww) { //TODO hash
    }
    $pdo = null;
}

// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (($naam = filter_input(INPUT_POST, 'naam')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
    print($naam . " " . $ww);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

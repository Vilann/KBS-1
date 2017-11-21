<?php
// Filter_input is een functie die kijkt of de informatie bestaat/aan (hier niet) gespecificeerde regels voldoet.
if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
    $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
    $user = "root";
    $pass = "";
    $pdo = new PDO($db, $user, $pass);
    // We halen het wachtwoord op van het lid met het lidID dat bij het emailadres staat.
    $stmt = $pdo->prepare("SELECT wachtwoord FROM login WHERE lidID=(SELECT lidID FROM lid WHERE ZHTC-emailadres = ?)");
    $stmt->execute(array($email));
    $dbww = $stmt->fetch();
    // password_verify is een functie om een gehasht wachtwoord dat gemaakt is met password_hash()
    if ($dbww['wachtwoord'] == password_verify($ww)) {
        session_start();
        $_SESSION['$email'] = $email;
    }

    $pdo = null;
}

// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (isset($_SESSION['email'])) {
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

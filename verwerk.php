<?php
// Filter_input is een functie die kijkt of de informatie bestaat.
// en of de info aan (hier niet) gespecificeerde regels voldoet.
if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {

    $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
    $user = "root";
    $pass = "";
    $pdo = new PDO($db, $user, $pass);

    // We halen het wachtwoord op van het lid met het lidID dat
    // Bij het emailadres staat. met de volgende sql query:
    $stmt = $pdo->prepare("SELECT wachtwoord FROM login WHERE lidID=
      (SELECT lidID  FROM lid WHERE ZHTC-emailadres = ?)");

    //Hier wordt de email voor het vraagteken in de query ingevuld.
    $stmt->execute(array($email));
    //Het wachtwoord wat uit deze query komt wordt in de variabele
    //dbww (database wachtwoord)gestopt.
    $dbww = $stmt->fetch();
    if ($dbww['wachtwoord'] == password_verify($ww)) {
        session_start();
        $_SESSION['$email'] = $email;
    }

/*
Het registratieformulier en loginformulier hebben allebei een verstuurknop met een naam, login en registreer.
De buitenste if-statements kijken welke van de 2 gebruikt is. Bij login wordt het eerste gebruikt, de loginfunctionaliteit.
Bij registreren wordt het tweede blok gebruikt.
 */

if (isset($_POST['login'])) {
    // Filter_input is een functie die kijkt of de informatie bestaat.
    // en of de info aan (hier niet) gespecificeerde regels voldoet.
    if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
        // de database, de gebruikersnaam daarvoor en het wachtwoord worden
        // in de volgende 3 variabelen gestopt.
        $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
        $user = "root";
        $pass = "";
        //Er ontstaat een verbinding met de database (new PDO) en de variabele worden gebruikt.
        $pdo = new PDO($db, $user, $pass);
        // We halen het wachtwoord op van het lid met het lidID dat bij het
        // (bij login ingevulde) emailadres staat. en stoppen dat in de variabele stmt.
        $stmt = $pdo->prepare("SELECT wachtwoord FROM login WHERE lidID=(SELECT lidID FROM lid WHERE ZHTC-emailadres = ?)");
        //Hier wordt de email voor het vraagteken in de query ingevuld.
        $stmt->execute(array($email));
        // vervolgens st
        $dbww = $stmt->fetch();
        // password_verify is een functie om een gehasht wachtwoord dat gemaakt is met password_hash()
        if ($dbww['wachtwoord'] == password_verify($ww)) {
            session_start();
            $_SESSION['$email'] = $email;
        }

        $pdo = null;
    }
}
if (isset($_POST['registreer'])) {
    // TODO: Logica toevoegen
}
// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (isset($_SESSION['email'])) {
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

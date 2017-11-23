<?php

/*
Het registratieformulier en loginformulier hebben allebei een verstuurknop met een naam, login en registreer.
De buitenste if-statements kijken welke van de 2 gebruikt is. Bij login wordt het eerste gebruikt, de loginfunctionaliteit.
Bij registreren wordt het tweede blok gebruikt.
 */
if (isset($_POST['login'])) {
    // Filter_input is een functie die kijkt of de informatie bestaat/aan (hier niet) gespecificeerde regels voldoet.
    if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
        $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
        $user = "root";
        $pass = "";
        $pdo = new PDO($db, $user, $pass);
        // We halen het wachtwoord op van het lid met het lidID dat bij het emailadres staat.
        $stmt = $pdo->prepare("SELECT Wachtwoord FROM login WHERE lidID=(SELECT lidID FROM lid WHERE ZHTCemailadres = ?)");
        $stmt->execute(array($email));
        $dbww = $stmt->fetch();
        $dbww = $dbww["Wachtwoord"];
        // password_verify is een functie om een gehasht wachtwoord dat gemaakt is met password_hash()
        if (password_verify($ww, $dbww)) {
            session_start();
            $_SESSION['email'] = $email;
        } else {
            //password false
            echo $ww."<br>".$dbww;
        }
        $pdo = null;
    }
}
if (isset($_POST['registreer'])) {
    // TODO: Logica toevoegen
    // TODO: Toevoegen logica login tabel
}

// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (isset($_SESSION['email'])) {
    print("Succesvol ingelogd!<br>");
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

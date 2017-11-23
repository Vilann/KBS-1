<?php

/*
Het registratieformulier en loginformulier hebben allebei een verstuurknop met een naam, login en registreer.
De buitenste if-statements kijken welke van de 2 gebruikt is. Bij login wordt het eerste gebruikt, de loginfunctionaliteit.
Bij registreren wordt het tweede blok gebruikt.
 */
if (isset($_POST['login'])) {
    // allereerst wordt er gekeken of de email en het wachtwoord overeen komen.
    // Filter_input is een functie die kijkt of de informatie bestaat.
    // en of de info aan (hier niet) gespecificeerde regels voldoet.
    //
    // Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is. //NOTE: hoe dan?

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
    // TODO: check naar de verplichte velden

    // Een lid krijgt een zhtc-emailadres, dat is 'voornaam'.'achternaam'@zhtc.nl
    // Dit wordt samen met het eigen emailadres opgeslagen
    $ZHTCemailadres = $_POST['voornaam'] . "." . $_POST['achternaam'] . "@zhtc.nl";

    // try-catch om te kijken of de registratie gelukt is
    try {
        $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
        $user = "root";
        $pass = "";
        $pdo = new PDO($db, $user, $pass);
        $sql = "INSERT INTO Lid (Voornaam, Tussenvoegsel, achternaam, Geboortedatum,
                                Adres, Woonplaats, Postcode, Geslacht,
                                Emailadres, Rekeningnummer, Noodnummer, shirtmaat,
                                Medicatie, Dieetwensen, Opmerking, ZHTCemailadres)
              VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($_POST["voornaam"],$_POST["tussenvoegsel"], $_POST["achternaam"], $_POST["geboortedatum"],
                           $_POST["adres"],$_POST["woonplaats"],$_POST["postcode"],$_POST["gender"],
                           $_POST["email"],$_POST["iban"],$_POST["noodnummer"],$_POST["maat"],
                           $_POST["medicatie"],$_POST["dieetwensen"],$_POST["opmerking"],$ZHTCemailadres));
        print($stmt->RowCount());
    } catch (exception $e) {
        print($e);
    }
}

// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.
// Testcode om te kijken of de sessie werkt
if (isset($_SESSION['email'])) {
    print("Succesvol ingelogd!<br>");
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

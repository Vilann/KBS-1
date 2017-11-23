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
}
if (isset($_POST['registreer'])) {
    // TODO: Logica toevoegen
    // TODO: alle attributen in de db laten beginnen met een
    //       kleine letter?
    //


    if ($filterPost = filter_input_array(INPUT_POST)) {
        $ZHTCemailadres = $filterPost['voornaam'] . "." . $filterPost['achternaam'] . "@zhtc.nl";
        print($ZHTCemailadres);


        try {
            $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
            $user = "root";
            $pass = "";
            $pdo = new PDO($db, $user, $pass);
            $sql = "INSERT INTO Lid (Voornaam, Tussenvoegsel, achternaam, Geboortedatum,
                                Adres, Woonplaats, Postcode, Geslacht,
                                Emailadres, Rekeningnummer, Noodnummer, T-shirtmaat,
                                Medicatie, Dieetwensen, Opmerking, ZHTC-emailadres)
              VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($filterPost["voornaam"],$filterPost["tussenvoegsel"], $filterPost["achternaam"], $filterPost["geboortedatum"],
                           $filterPost["adres"],$filterPost["woonplaats"],$filterPost["postcode"],$filterPost["gender"],
                           $filterPost["email"],$filterPost["iban"],$filterPost["noodnummer"],$filterPost["maat"],
                           $filterPost["medicatie"],$filterPost["dieetwensen"],$filterPost["opmerking"],$ZHTCemailadres));
        } catch (exception $e) {
            print($e);
        }
    }
}

// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (isset($_SESSION['email'])) {
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

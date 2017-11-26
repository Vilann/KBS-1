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
    // TODO: zorgen dat het beveiligd is tegen hacks/cracks/cheats etc. dus dat je niet een situatie krijgt als in "; drop table users" (zie xkcd)

    // kijken of elke not-null waarde is ingevuld in het formulier
    if (isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['geboortedatum']) && isset($_POST['adres']) && isset($_POST['postcode'])
    && isset($_POST['woonplaats']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['iban']) && isset($_POST['noodnummer']) && isset($_POST['maat'])) {
        // Een lid krijgt een zhtc-emailadres, dat is 'voornaam'.'achternaam'@zhtc.nl
        // Dit wordt samen met het eigen emailadres opgeslagen, dus een lid heeft 2 emailadressen
        $ZHTCemailadres = $_POST['voornaam'] . "." . $_POST['achternaam'] . "@zhtc.nl";

        // try-catch heb ik verwijderd, die catcht geen fout :(

        $db = "mysql:host=localhost;dbname=zhtc;port=3306";
        $user = "root";
        $pass = "";
        $link = new PDO($db, $user, $pass);
        //zet de juiste error reporting zodat fouten kunnen worden opgevangen
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $link->prepare("INSERT INTO lid (Voornaam, Tussenvoegsel, Achternaam, Geboortedatum,
                                    Adres, Woonplaats, Postcode, Geslacht,
                                    Emailadres, Rekeningnummer, Noodnummer, shirtmaat,
                                    Medicatie, Dieetwensen, Opmerking, ZHTCemailadres)
                  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        // str_replace haalt alle spaties uit de postcode zodat het altijd 6 tekens is
        $statement->execute(array($_POST["voornaam"],$_POST["tussenvoegsel"], $_POST["achternaam"], $_POST["geboortedatum"],
                               $_POST["adres"],$_POST["woonplaats"],str_replace(' ', '', $_POST["postcode"]),$_POST["gender"],
                               $_POST["email"],$_POST["iban"],$_POST["noodnummer"],$_POST["maat"],
                               $_POST["medicatie"],$_POST["dieetwensen"],$_POST["opmerking"],$ZHTCemailadres));

        if($statement->RowCount()){
          print("succes!<br>");
        }
    };
}

// Testcode om te kijken of de sessie werkt
if (isset($_SESSION['email'])) {
    print("Succesvol ingelogd!<br>");
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

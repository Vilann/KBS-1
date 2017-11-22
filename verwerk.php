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
        // de database(db), de gebruikersnaam daarvoor en het wachtwoord worden
        // in de variabelen(var) $db, $user en $pass gestopt.
        // vervolgens maken we met "new PDO" een verbinding met de database en vullen we
        // de credentials in die we in die variabelen hebben gestopt.
        $db = "mysql:host=localhost;dbname=ZHTC;port=3306";
        $user = "root";
        $pass = "";
        $pdo = new PDO($db, $user, $pass);

        // Dan halen we het wachtwoord op van het lid met het lidID dat bij het
        // (bij login ingevulde) emailadres staat. en stoppen dat in de var stmt.
        $stmt = $pdo->prepare("SELECT wachtwoord FROM login WHERE lidID=(SELECT lidID FROM lid WHERE ZHTC-emailadres = ?)");
        $stmt->execute(array($email));//Hier wordt de email voor het vraagteken in de query ingevuld.
        $dbww = $stmt->fetch();//Het wachtwoord wat uit deze query komt wordt in de vardbww (database wachtwoord)gestopt.
        // password_verify is een functie om een gehasht wachtwoord dat gemaakt is met password_hash() // NOTE: halve zin? gr Kai
        if ($dbww['wachtwoord'] == password_verify($ww)) {
            session_start();
            $_SESSION['$email'] = $email;
        }

        $pdo = null; // hier wordt de db-verbinding weer verbroken.
    }
}
if (isset($_POST['registreer'])) {//als er op de registreer knop wordt gedrukt en alles is ingevuld? gr Kai
    // TODO: Logica toevoegen
    // TODO: alle attributen in de db laten beginnen met een
    //       kleine letter?
    //

    if ($filter_input_array(INPUT_POST, $args)) {
    }
    $sql = "INSERT INTO Lid (Voornaam, Tussenvoegsel, Geboortedatum,
                              Adres, Woonplaats, Postcode, Geslacht,
                              Emailadres, Rekeningnummer, Noodnummer, T-shirtmaat,
                              Medicatie, Dieetwensen, Opmerking, ZHTC-emailadres)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_POST["Voornaam"],$_POST["Tussenvoegsel"],$_POST["Geboortedatum"],
                         $_POST["Adres"],$_POST["Woonplaats"],$_POST["Postcode"],$_POST["Geslacht"],
                         $_POST["Emailadres"],$_POST["Rekeningnummer"],$_POST["Noodnummer"],$_POST["shirtmaat"],
                         $_POST["Medicatie"],$_POST["Dieetwensen"],$_POST["Opmerking"],$_POST["emailadres"]));
}
<<<<<<< HEAD
=======
// NOTE: https://secure.php.net/manual/en/filter.filters.sanitize.php hier zullen we ongetwijfeld nog iets mee moeten
//        maar daar ben ik nu te moe voor weltrusten. Gr Kai
//        + vraag morgen ff die try, catch, en throw aan Hugo Gr Kai
// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is. //NOTE: hoe dan?
>>>>>>> 5f04027d8427830532af9be6de3c9c119be8f0e4

if (isset($_SESSION['email'])) {
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

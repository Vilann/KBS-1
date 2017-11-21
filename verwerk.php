<?php
// Filter_input is een functie die kijkt of de informatie bestaat/aan (hier niet) gespecificeerde regels voldoet.
if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
    $db = "mysql:host=localhost;dbname=ZHTC;port=3306"; //de database opzoeken
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

    $pdo = null;
}
// Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is.

if (isset($_SESSION['email'])) {
    print($_SESSION['email']);
} else {
    print("Je hebt het niet goed ingevuld, ga terug!");
}

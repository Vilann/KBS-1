<?php
/*
Het registratieformulier en loginformulier hebben allebei een verstuurknop met een naam, login en registreer.
De buitenste if-statements kijken welke van de 2 gebruikt is. Bij login wordt het eerste gebruikt, de loginfunctionaliteit.
Bij registreren wordt het tweede blok gebruikt.
 */
$privatekey = "6Ld7nTsUAAAAALPpQKrdXPI3nJnSF11aSBmvx6HF";

function generate_token()
{
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    return $token;
}
function foute_inlogpoging()
{
    include("includes/dbconnect.php");
    // Foute inlogpoging registreren
    $ip= $_SERVER['REMOTE_ADDR'];

    $stmt=$pdo->prepare("Insert into loginpoging(ip) VALUES (?)");
    $stmt->execute(array($ip));
    // drie foute pogingen zet session failed op true
    $stmt=$pdo->prepare("SELECT Count(*) as failed
      FROM   loginpoging
      WHERE  tijd > Date_sub(Now(), INTERVAL 15 minute) and  ip=?");
    $stmt->execute(array($ip));
    $pogingen = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pogingen['failed']>=3) {
        session_start();
        $_SESSION['failed']=true;
    }
}

if (isset($_POST['login'])) {
    // allereerst wordt er gekeken of de email en het wachtwoord overeen komen.
    // Filter_input is een functie die kijkt of de informatie bestaat.
    // en of de info aan (hier niet) gespecificeerde regels voldoet.
    //
    // Filter_input zorgt ervoor dat 1) de informatie gefilterd wordt en 2) de informatie 'veilig' is. //NOTE: hoe dan?

    if (($email = filter_input(INPUT_POST, 'email')) && ($ww = filter_input(INPUT_POST, 'wachtwoord'))) {
        include 'includes/dbconnect.php';
        // We halen het wachtwoord op van het lid met het lidID dat bij het emailadres staat.
        $stmt = $pdo->prepare("SELECT DISTINCT l.lidID, l.voornaam, l.wachtwoord, c.commissievoorzitter, d.dispuutvoorzitter, b.bestuurslidID,
          CASE WHEN c.commissievoorzitter = l.lidID THEN 'yes'
          	 WHEN d.dispuutvoorzitter = l.lidID THEN 'yes'
               WHEN b.bestuurslidID = l.lidID THEN 'yes'
               ELSE null
               END AS toegangAdmin
          FROM lid l
          LEFT JOIN commissie c ON c.commissievoorzitter = l.lidID
          LEFT JOIN dispuut d ON d.dispuutvoorzitter = l.lidID
          LEFT JOIN bestuur b ON b.bestuurslidID = l.lidID
          WHERE emailadres = ?");
        $stmt->execute(array($email));
        // Kijken of een email bestaat
        if ($stmt->rowCount() == 1) {
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
            // password_verify is een functie om een gehasht wachtwoord dat gemaakt is met password_hash()
            // Kijken of het wachtwoord bij de email hoort
            if (password_verify($ww, $info["wachtwoord"])) {
                session_start();
                if ($info['toegangAdmin'] == "yes") {
                    $adminRechten = array("Beheer"=>$info['bestuurslidID'], "Dispuut"=>$info['dispuutvoorzitter'], "Commissie"=>$info['commissievoorzitter']);
                    $_SESSION['admin'] = $adminRechten;
                }
                $_SESSION['lid'] = $info['lidID'];
                $_SESSION['voornaam'] = $info['voornaam'];
                $ip= $_SERVER['REMOTE_ADDR'];
                $stmt=$pdo->prepare("DELETE FROM loginpoging WHERE ip=?");
                $stmt->execute(array($ip));
            } else {
                foute_inlogpoging();
                // TODO: Foutinformatie op login.php en terugsturen
                $errors = true;
            }
        } else {
            foute_inlogpoging();
            // print("Het emailadres bestaat niet");
            // // TODO: foutinformatie op login.php en terugsturen
            $errors = true;
            // //fout inlogpoging registreren
        }
        $pdo = null;

        if ($errors) {
            session_start();
            $_SESSION["error"] = "wachtwoord,Het emailadres of wachtwoord is niet correct ingevuld";
            header("Location: login");
            // anders voert het de gegevens in ($insert), en daarna het emailadres ($emailinsert)
        }
    }


    // Testcode om te kijken of de sessie werkt
    if (isset($_SESSION['voornaam'])) {
        header("Location: index");
    } else {
        print("Je hebt het niet goed ingevuld, ga terug!");
    }
}
if (isset($_POST['registreer'])) {

  // Het gedeelte voor de 'if' regelt de captcha.
    // Eerst halen we de response van de knop op registreer.php
    $captcha = $_POST['g-recaptcha-response'];
    // Dan maken we met curl, want file_get_contents werkt op de een of andere manier niet, een request volgens de recaptcha api van google.
    $ch = curl_init("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // De response, dus of het goed gegaan is of niet, wordt opgeslagen in $response.
    $response = curl_exec($ch);
    curl_close($ch);

    // Als laatst moeten we zorgen dat we de gegevens kunnen gebruiken. json_decode zet het json bestand om in een class.
    $result  = json_decode($response);

    // Nu kunnen we eindelijk kijken of het een geldige response is, dwz het is geen bot.
    session_start();
    if ($result->success) {
        // kijken of elke not-null waarde is ingevuld in het formulier
        if (isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['geboortedatum']) && isset($_POST['adres']) && isset($_POST['postcode'])
      && isset($_POST['woonplaats']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['iban']) && isset($_POST['noodnummer']) && isset($_POST['maat'])) {
            // Als de errors variabele na alle checks fout is, wordt de gebruiker teruggestuurd naar de registratiepagina.
            // TODO: validate emailadres, validate rekeningnummer, validate noodnummer, validate wachtwoord
            $errors = false;

            // Input aanpassen zodat we het lekker kunnen gebruiken
            $voornaam = strtolower($_POST['voornaam']);
            $achternaam = strtolower($_POST['achternaam']);
            $tussenvoegsel = !empty($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : null;
            $medicatie = !empty($_POST['medicatie']) ? $_POST['medicatie'] : null;
            $dieetwensen = !empty($_POST['dieetwensen']) ? $_POST['dieetwensen'] : null;
            $opmerking = !empty($_POST['opmerking']) ? $_POST['opmerking'] : null;
            // Een lid krijgt een zhtc-emailadres, dat is 'voornaam'.'achternaam'@zhtc.nl
            // Dit wordt samen met het eigen emailadres opgeslagen, dus een lid heeft 2 emailadressen
            // NOTE: door zhtc aangegeven dat het niet meer hoeft
            // $ZHTCemailadres = $voornaam . "." . $achternaam . "@zhtc.nl";

            // Als het geslacht niet in de array voorkomt, dan is er met het formulier geknoeid en accepteren we het niet.
            // TODO: fix dit
            if (!in_array($_POST['gender'], array('man', 'vrouw', 'anders'))) {
                $errors = true;
                $errormess = "gender,Kies een geslacht uit de lijst.";
            }


            // als de geboortedatum nieuwer dan vandaag - 16 is, is er geknoeid met de geboortedatum
            if ($_POST['geboortedatum'] > date('Y-m-d', strtotime("-16 year"))) {
                $errors = true;
                $errormess = "geboortedatum,Je moet in ieder geval 16 jaar of ouder zijn.";
            }
            // kijk om het ingevulde emailadres geldig is

            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && strpos($_POST["email"], '.')) {
                include('includes/dbconnect.php');
                $email = $_POST['email'];
                $stmt = $pdo->prepare("SELECT * FROM lid WHERE emailadres = ?");
                $stmt->execute(array($email));

                if ($stmt->RowCount()==1) {
                    $errors = true;
                    $errormess = "email,Het ingevulde emailadres bestaat al.";
                }
                //
            } else {
                $errors = true;
                $errormess = "email,Het ingevulde emailadres is niet geldig.";
            }

            if ($_POST["wachtwoord"] == $_POST["herhaalwachtwoord"]) {
                if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST["wachtwoord"]) && !(strlen($_POST["wachtwoord"]) < 8)) {
                    //
                    $encryptedww = password_hash($_POST["wachtwoord"], PASSWORD_BCRYPT);
                } else {
                    $errors = true;
                    $errormess = "wachtwoord,Het wachtwoord is niet veilig genoeg.";
                }
            } else {
                $errors = true;
                $errormess = "herhaalwachtwoord,De ingevoerde wachtwoorden komen niet overeen.";
            }
            // Als er errors zijn gevonden, gaat het (nu nog) terug naar de homepage
            // TODO: Betere errors
            if ($errors) {
                session_start();
                $_SESSION["error"] = $errormess;
                header("Location: registreer");
                // anders voert het de gegevens in ($insert), en daarna het emailadres ($emailinsert)
            } else {
                include 'includes/dbconnect.php';
                $token = generate_token();

                //zet de juiste error reporting zodat fouten kunnen worden opgevangen
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $insert = $pdo->prepare("INSERT INTO lid (voornaam, tussenvoegsel, achternaam, geboortedatum,
                                      adres, woonplaats, postcode, geslacht,
                                      emailadres, rekeningnummer, noodnummer, shirtmaat,
                                      medicatie, dieetwensen, opmerking, wachtwoord, aanmaakdatum, token)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                // str_replace haalt alle spaties uit de postcode zodat het altijd 6 tekens is
                $insert->execute(array($voornaam, $tussenvoegsel, $achternaam, $_POST["geboortedatum"],
                                 $_POST["adres"],$_POST["woonplaats"],str_replace(' ', '', $_POST["postcode"]),$_POST["gender"],
                                 $_POST["email"],$_POST["iban"],$_POST["noodnummer"],$_POST["maat"],
                                 $medicatie,$dieetwensen,$opmerking,$encryptedww ,date("Y-m-d"), $token));

                // PDO::lastInsertID() geeft het laatste id terug die gemaakt is. Dat is dus de id van de bovenstaande query.
                // $insertID = $pdo->lastInsertId();

                // Hier voeren we het emailadres in in de emailadres tabel, met de id.
                // NOTE: niet nodig
                // $emailinsert = $pdo->prepare("INSERT INTO emailadres VALUES (?, ?)");
                // $emailinsert->execute(array($ZHTCemailadres, $insertID));

                // TODO: mooie pagina maken met verdere instructies
                // TODO: betaling
                if ($insert->RowCount()/* && $emailinsert->RowCount() */) {
                    include 'includes/mail.php';
                    $naam = $voornaam . $tussenvoegsel . $achternaam;
                    mail_bevestigen($email, $token, $naam);
                    header("Location: registreer?succes");
                } else {
                    print("Er is iets fout gegaan met registreren");
                }
            }
        } else {
            print_r($_POST);
        }
    } else {
        $_SESSION['captchamelding'] = "Er is iets fout gegaan met de verificatie van de captcha, probeer opnieuw!";
        header('Location: registreer');
    }
}
if (isset($_POST['edit'])) {
    // kijken of elke not-null waarde is ingevuld in het formulier
    if (isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['geboortedatum']) && isset($_POST['adres']) && isset($_POST['postcode'])
  && isset($_POST['woonplaats']) && isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['iban']) && isset($_POST['noodnummer']) && isset($_POST['maat'])) {
        // Als de errors variabele na alle checks fout is, wordt de gebruiker teruggestuurd naar de registratiepagina.
        // TODO: validate emailadres, validate rekeningnummer, validate noodnummer, validate wachtwoord
        $errors = false;

        // Input aanpassen zodat we het lekker kunnen gebruiken
        $voornaam = strtolower($_POST['voornaam']);
        $achternaam = strtolower($_POST['achternaam']);
        $tussenvoegsel = !empty($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : null;
        $medicatie = !empty($_POST['medicatie']) ? $_POST['medicatie'] : null;
        $dieetwensen = !empty($_POST['dieetwensen']) ? $_POST['dieetwensen'] : null;
        $opmerking = !empty($_POST['opmerking']) ? $_POST['opmerking'] : null;

        // Een lid krijgt een zhtc-emailadres, dat is 'voornaam'.'achternaam'@zhtc.nl
      // Dit wordt samen met het eigen emailadres opgeslagen, dus een lid heeft 2 emailadressen
      // NOTE: door zhtc aangegeven dat het niet meer hoeft
      // $ZHTCemailadres = $voornaam . "." . $achternaam . "@zhtc.nl";
    }
}
if ((isset($_POST['contact']))) {
    error_reporting(E_ALL);

    // Het gedeelte voor de 'if' regelt de captcha.
    // Eerst halen we de response van de knop op contact.php
    $captcha = $_POST['g-recaptcha-response'];
    // Dan maken we met curl, want file_get_contents werkt op de een of andere manier niet, een request volgens de recaptcha api van google.
    $ch = curl_init("https://www.google.com/recaptcha/api/siteverify?secret=".$privatekey."&response=".$captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // De response, dus of het goed gegaan is of niet, wordt opgeslagen in $response.
    $response = curl_exec($ch);
    curl_close($ch);

    // Als laatst moeten we zorgen dat we de gegevens kunnen gebruiken. json_decode zet het json bestand om in een class.
    $result  = json_decode($response);

    // Nu kunnen we eindelijk kijken of het een geldige response is, dwz het is geen bot.
    session_start();
    if ($result->success) {
        if (($naam = filter_input(INPUT_POST, 'naam')) && ($emailadres = filter_input(INPUT_POST, 'email')) && ($bericht = filter_input(INPUT_POST, 'bericht'))) {
            if (filter_var($emailadres, FILTER_VALIDATE_EMAIL) && strpos($emailadres, '.')) {
                include("includes/mail.php");
                mail_contact($emailadres, $naam, $bericht);
                $_SESSION['captchamelding'] = "Uw bericht is verstuurd. Binnen enkele momenten zal er een mail verstuurd worden ter bevestiging.";
            } else {
                $_SESSION['captchamelding'] = "Dit is geen geldig emailadres";
            }
        } else {
            $_SESSION['captchamelding'] = "U heeft iets niet goed ingevuld";
        }
    } else {
        $_SESSION['captchamelding'] = "Er is iets fout gegaan met de verificatie van de captcha, probeer opnieuw!";
    }
    header("Location: contact");
}

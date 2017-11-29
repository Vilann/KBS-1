<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Contact</title>
        <?php include 'includes/header.php'; ?>


    <body>
        <h1>Contactformulier</h1>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2427.997172364323!2d6.100033315984932!3d52.515390244322994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7df3c9a5bcfe1%3A0x907105d2484be27f!2sAlgemene+Studentenvereniging+ZHTC!5e0!3m2!1snl!2snl!4v1511780795999" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        

        <form Method="POST" Action='contact.php'>
          <table>
            <tr>
              <td><label for="contactmail">Emailadres:</label></td>
              <td><input id="contactmail" type="mail" name="contactmail" placeholder="Uwmailadres@voorbeeld.com" required></td>
            </tr>
            <tr>
              <td><label for="contactnaam">Naam:</label></td>
              <td><input id="contactnaam" type="text" name="contactnaam" placeholder="Uw naam" required></td>
            </tr>
            <tr>
              <td><label for="contactbericht">Bericht:</label></td>
              <td><textarea id="contactbericht" name="contactbericht" placeholder="Uw vragen, opmerkingen of tips" required></textarea></td>
            </tr>
          </table>
            <input type="submit" name="verzend" value="Verzend">
        </form>

        <?php
        if (isset($_POST['verzend']) && isset($_POST['contactmail']) && isset($_POST['contactnaam']) && isset($_POST['contactbericht'])) {
            $naam = $_POST['contactnaam'];
            $emailadres = $_POST['contactmail'];
            $bericht = $_POST['contactbericht'];
            $zhtcmailadres = "Iemands@emailadres.com";
            $onderwerp = "Een mail van $naam";
            $mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
            mail($zhtcmailadres, $onderwerp, $mailbericht);
            print("hoho klopt ... $mailbericht");
        };

        ?>




    </body>
</html>

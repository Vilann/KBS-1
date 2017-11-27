<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Contact</title>
        <?php include 'includes/header.php'; ?>


    <body>
        <h1>Contactformulier</h1>
        
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2427.997172364323!2d6.100033315984932!3d52.515390244322994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7df3c9a5bcfe1%3A0x907105d2484be27f!2sAlgemene+Studentenvereniging+ZHTC!5e0!3m2!1snl!2snl!4v1511780795999" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        <div >Test Banana</div>

        <form Method="POST" Action='contactverwerk.php'>

            <label for="contactmail">Emailadres:</label>
            <input id="contactmail" type="mail" name="contactmail" placeholder="Uwmailadres@voorbeeld.com">
            <label for="contactnaam">Naam:</label>
            <input id="contactnaam" type="text" name="contactnaam" placeholder="Uw naam">
            <label for="contactbericht">Bericht:</label>
            <input id="contactbericht" type="textarea" name="contactbericht" placeholder="Uw vragen, opmerkingen of tips">
            <input type="submit" name="Verzend" value="Verzend">
        </form>



    </body>
</html>

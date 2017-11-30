<?php include('includes/beveiligd.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Registreren</title>
    <?php include 'includes/header.php' ?>

    <h1>Registreer</h1>
    <p>Hier kun je je inschrijven voor ZHTC. Bij opgave ga je akkoord met onze
      <b>privacyvoorwaarden</b> en ga je ermee akkoord dat we &euro;25
      contributie per halfjaar van je rekening halen.</p>
      <p class="belangrijk">De velden met een * zijn verlicht.</p>

    <form action="verwerk" method="post">
        <table>
        <tr>
            <td> <label for="voornaam">* Voornaam:</label> </td>
            <td> <input id="voornaam" type="text" name="voornaam" placeholder="Voornaam" required> </td>
          </tr>
          <tr>
            <td> <label for="tussenvoegsel">Tussenvoegsel:</label> </td>
            <td> <input id="tussenvoegsel" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> </td>
          </tr>
          <tr>
            <td> <label for="achternaam">* Achternaam:</label> </td>
            <td> <input id="achternaam" type="text" name="achternaam" placeholder="Achternaam" required> </td>
          </tr>
          <tr>
            <td> <label for="geboortedatum">* Geboortedatum:</label> </td>
            <td> <input id="geboortedatum" type="date" name="geboortedatum" max=<?php print('"' . date('Y-m-d', strtotime("-16 year")) . '"'); ?> required></td>
          </tr>
          <tr>
            <td> <label for="adres">* Adres:</label> </td>
            <td> <input id="adres" type="text" name="adres" placeholder="Thomas á Kempisstraat 13" required> </td>
          </tr>
          <tr>
            <td> <label for="postcode">* Postcode</label> en <label for="woonplaats">woonplaats</label>: </td>
            <td> <input id="postcode" type="text" name="postcode" placeholder="1234 AB" required> </td>
            <td> <input id="woonplaats" type="text" name="woonplaats" placeholder="Zwolle" required> </td>
          </tr>
          <tr>
            <td> <label for="geslacht">* Geslacht:</label> </td>
            <td>
                 <input type="radio" name="gender" value="man" required> Man <br>
                 <input type="radio" name="gender" value="vrouw"> Vrouw <br>
                 <!-- helaas heren, geen gevechtshelikopter -->
                 <input type="radio" name="gender" value="anders"> geen van bovenstaande <br>
            </td>
            <!-- NOTE: ik heb de radiobuttons verneukt Gr Kai?> -->
          </tr>
          <tr>
            <td> <label for="email">* Emailadres:</label> </td>
            <td> <input id="email" type="email" name="email" placeholder="lid@zhtc.nl" required> </td>
          </tr>
          <tr>
            <td> <label for="rekening">* Rekeningnummer:</label> </td>
            <td> <input id="rekening" type="text" name="iban" placeholder="NL12RABO0123456789" required> </td>
            <!-- NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai -->
          </tr>
          <tr>
            <td> <label for="noodnummer">* Noodnummer:</label> </td>
            <td> <input id="noodnummer" type="tel" name="noodnummer" placeholder="06 123 45 678" required> </td>
          </tr>
          <tr>
            <td><label for="maat">* T-shirtmaat:</label> </td>
            <td> <input type="radio" name="maat" value="xs" required > XS
                 <input type="radio" name="maat" value="s"> S
                 <input type="radio" name="maat" value="m"> M
                 <input type="radio" name="maat" value="l"> L
                 <input type="radio" name="maat" value="xl"> XL
                 <input type="radio" name="maat" value="xxl"> XXL
            </td>
          </tr>
          <tr>
            <td> <label for="medicatie">Medicatie:</label> </td>
            <td><textarea id="medicatie" name="medicatie" placeholder="Ik gebruik deze medicatie"></textarea></td>
          </tr>
          <tr>
            <td> <label for="dieetwensen">Dieetwensen:</label> </td>
            <td> <textarea id="dieetwensen" type="text" name="dieetwensen" placeholder="Ik ... lust geen chocola. Ik ... ben allergisch voor gluten"></textarea> </td>
          </tr>
          <tr>
            <td> <label for="opmerking">Opmerking:</label> </td>
            <td> <textarea id="opmerking" type="text" name="opmerking" placeholder="Wil je nog wat kwijt?"></textarea> </td>
          </tr>
        </table>
        <input type="submit" value="registreer" name="registreer">
    </form>

  </body>
</html>

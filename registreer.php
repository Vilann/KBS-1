<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <?php include 'includes/header.php' ?>

    <h1>Registreer</h1>
    <p>Hier kun je je inschrijven voor ZHTC. Bij opgave ga je akkoord met onze
      <b>privacyvoorwaarden</b> en ga je ermee akkoord dat we &euro;25
      <!-- http://www.homepage-maken.nl/htmlcursus/htmltekens.php NOTE: tip van de dag gr Kai-->
      contributie per halfjaar van je rekening halen.</p>

    <form action="verwerk.php" method="post">
        <table>
        <tr>
            <td> <label for="voornaam">Naam:</label> </td>
            <td> <input id="voornaam" type="text" name="naam" placeholder="Voornaam" required> </td>
          </tr>
          <tr>
            <td> <label for="tussenvoegsel">Tussenvoegsel:</label> </td>
            <td> <input id="tussenvoegsel" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> </td>
          </tr>
          <tr>
            <td> <label for="achternaam">Achternaam:</label> </td>
            <td> <input id="achternaam" type="text" name="achternaam" placeholder="Achternaam" required> </td>
          </tr>
          <tr>
            <td> <label for="geboortedatum">Geboortedatum:</label> </td>
            <td> <input id="geboortedatum" type="date" name="Geboortedatum" max="<?php$date = strtotime("-16 year"); print(date('Y-m-d', $date));?>"></td>
          </tr>
          <tr>
            <td> <label for="adres">Adres:</label> </td>
            <td> <input id="adres" type="text" name="adres" placeholder="Thomas á Kempisstraat 13" required> </td>
          </tr>
          <tr>
            <td> Postcode en woonplaats: </td>
            <td> <input type="text" name="postcode" placeholder="1234 AB"> </td>
            <td> <input type="text" name="woonplaats" placeholder="Zwolle"> </td>
          </tr>
          <tr>
            <td> <label for="geslacht">Geslacht:</label> </td>
            <td>
              <input type="radio" name="gender" value="man" required> Man <br>
                 <input type="radio" name="gender" value="vrouw"> Vrouw <br>
                 <input type="radio" name="gender" value="lgbt"> lgbt <br>
                 <input type="radio" name="gender" value="gevechtshelikopter"> gevechtshelikopter <br>
                 <input type="radio" name="gender" value="geen van bovenstaande"> geen van bovenstaande <br>
            </td>
            <?php // NOTE: ik heb de radiobuttons verneukt Gr Kai ?>
          </tr>
          <tr>
            <td> Emaildres: </td>
            <td> <input type="email" name="email" placeholder="lid@zhtc.nl" required> </td>
          </tr>
          <tr>
            <td> Rekeningnummer: </td>
            <td> <input type="text" name="iban" placeholder="NL12RABO0123456789" required> </td>
            <?php // NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai ?>
          </tr>
          <tr>
            <td> Noodnummer: </td>
            <td> <input type="tel" name="noodnummer" placeholder="06 123 45 678"> </td>
          </tr>
          <tr>
            <td> T-shirtmaat: </td>
            <td> <input type="radio" name="maat" value="xs" required > XS
                 <input type="radio" name="maat" value="s"> S
                 <input type="radio" name="maat" value="m"> M
                 <input type="radio" name="maat" value="l"> L
                 <input type="radio" name="maat" value="xl"> XL
                 <input type="radio" name="maat" value="xxl"> XXL
            </td>
          </tr>
          <tr>
            <td> Medicatie: </td>
            <td><textarea name="medicatie" placeholder="Medicatie"></textarea></td>
          </tr>
          <tr>
            <td> Dieetwensen: </td>
            <td> <textarea type="text" name="dieetwensen" placeholder="vlees en veel, lactose tollerant, liever kips leverworst dan gewone leverworst"></textarea> </td>
          </tr>
          <tr>
            <td> Opmerking: </td>
            <td> <textarea type="text" name="opmerking" placeholder="jullie hebben een hele coole getinte man als lid, wie is die toffe gozer?"></textarea> </td>
          </tr>
          <input type="hidden" name="ZHTC-emailadress" value="voornaam.achternaam@zhtc.nl">
          <?php // TODO: de info voor de email ergens vandaan toveren Gr Kai?>
        </table>
        <?php // NOTE: door op deze knop te drukken wordt al deze info gestopt in de value registreer. *zie verwerk.php Gr Kai?>
        <input type="submit" value="registreer" name="registreer">
    </form>

  </body>
</html>

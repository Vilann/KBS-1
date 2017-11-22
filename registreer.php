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
            <td> Naam: </td>
            <td> <input type="text" name="naam" placeholder="Voornaam"> </td>
          </tr>
          <tr>
            <td> Tussenvoegsel: </td>
            <td> <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> </td>
          </tr>
          <tr>
            <td> Achternaam: </td>
            <td> <input type="text" name="achternaam" placeholder="Achternaam"> </td>
          </tr>
          <tr>
            <td> Geboortedatum: </td>
            <td> <input type="date" name="Geboortedatum"> </td>
          </tr>
          <tr>
            <td> Adres: </td>
            <td> <input type="text" name="adres" placeholder="Thomas á Kempisstraat 13"> </td>
          </tr>
          <tr>
            <td> Postcode en woonplaats: </td>
            <td> <input type="text" name="postcode" placeholder="1234 AB"> </td>
            <td> <input type="text" name="woonplaats" placeholder="Zwolle"> </td>
          </tr>
          <tr>
            <td> Geslacht: </td>
            <td> <input type="radio" name="Man"> Man <br>
                 <input type="radio" name="Vrouw"> Vrouw <br>
                 <input type="radio" name="lgbt"> lgbt <br>
                 <input type="radio" name="gevechtsheli"> gevechtshelikopter <br>
                 <input type="radio" name="geen van bovenstaande"> geen van bovenstaande <br>
            </td>
            <?php // NOTE: ik heb de radiobuttons verneukt Gr Kai ?>
          </tr>
          <tr>
            <td> Emaildres: </td>
            <td> <input type="email" name="email" placeholder="lid@zhtc.nl"> </td>
          </tr>
          <tr>
            <td> Rekeningnummer: </td>
            <td> <input type="text" name="iban" placeholder="NL12RABO0123456789"> </td>
            <?php // NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai ?>
          </tr>
          <tr>
            <td> Noodnummer: </td>
            <td> <input type="tel" name="noodnummer" placeholder="06 123 45 678"> </td>
          </tr>
          <tr>
            <td> T-shirtmaat: </td>
            <td> <input type="radio" name="maatxs"> XS
                 <input type="radio" name="maats"> S
                 <input type="radio" name="maatm"> M
                 <input type="radio" name="maatl"> L
                 <input type="radio" name="maatxl"> XL
                 <input type="radio" name="maatxxl"> XXL
            </td>
          </tr>
          <tr>
            <td> Medicatie: </td>
            <td> <input type="text" name="noodnummer" placeholder="pillen en veel"> </td>
          </tr>
          <tr>
            <td> Dieetwensen: </td>
            <td> <input type="text" name="dieetwensen" placeholder="vlees en veel, lactose tollerant, liever kips leverworst dan gewone leverworst"> </td>
          </tr>
          <tr>
            <td> Opmerking: </td>
            <td> <input type="text" name="opmerking" placeholder="jullie hebben een hele coole getinte man als lid, wie is die toffe gozer?"> </td>
          </tr>
          <input type="hidden" name="ZHTC-emailadress" value="voornaam.achternaam@zhtc.nl">
          <?php // TODO: de info voor de email ergens vandaan toveren Gr Kai?>
        </table>
        <?php // NOTE: door op deze knop te drukken wordt al deze info gestopt in de value registreer. *zie verwerk.php Gr Kai?>
        <input type="submit" value="registreer" name="registreer">
    </form>

  </body>
</html>

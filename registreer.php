<?php include('includes/beveiligd.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Registreren</title>
    <?php include 'includes/header.php' ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1>Registreer</h1>
          <p>Hier kun je je inschrijven voor ZHTC. Bij opgave ga je akkoord met onze
            <b>privacyvoorwaarden</b> en ga je ermee akkoord dat we &euro;25
            contributie per halfjaar van je rekening halen.</p>
            <p class="belangrijk">De velden met een * zijn verlicht.</p>
        </div>
      <div class="col-sm-12 col-xs-12 col-md-6">
    <form action="verwerk" method="post">
<<<<<<< HEAD
          <!--<div class="form-group row">
            <label for="inputPassword" class="col-sm-4 col-form-label">* Naam:</label>
            <div class="col-sm-8">
              <div class="row">
                <div class="col-12 px-0">
                  <input type="text" class="form-control" placeholder="Voornaam">
                </div>
              </div>
            </div>
            <label for="inputPassword" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-8">
              <div class="row">
                <div class="col-3 px-0">
                  <input type="text" class="form-control" placeholder="Tussenvgsl">
                </div>
                <div class="col-9 px-0">
                  <input type="text" class="form-control" placeholder="Achternaam">
                </div>
              </div>
            </div>
          </div> -->
          <div class="form-group row">
              <label for="voornaam" class="col-sm-4 col-form-label">* Voornaam:</label>
              <div class="col-sm-8 px-0">
                <input  id="voornaam" type="text" class="form-control" name="voornaam" placeholder="Voornaam" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="tussenvoegsel" class="col-sm-4 col-form-label">* Tussenvoegsel:</label>
              <div class="col-sm-3 px-0">
                <input  id="tussenvoegsel" type="text" class="form-control" name="tussenvoegsel" placeholder="Tussenvoegsel" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="achternaam" class="col-sm-4 col-form-label">* achternaam:</label>
              <div class="col-sm-8 px-0">
                <input  id="achternaam" type="text" class="form-control" name="achternaam" placeholder="Achternaam" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="geboortedatum" class="col-sm-4 col-form-label">* geboortedatum:</label>
              <div class="col-sm-8 px-0">
                <input  id="geboortedatum" type="date" class="form-control" name="geboortedatum" placeholder="geboortedatum" max=<?php print('"' . date('Y-m-d', strtotime("-16 year")) . '"'); ?> required>
              </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-4 col-form-label">* Locatie:</label>
            <div class="col-sm-8">
              <div class="row">
                <div class="col-12 px-0">
                  <input type="text" class="form-control" placeholder="Adres">
                </div>
              </div>
            </div>
            <label for="inputPassword" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-8">
              <div class="row">
                <div class="col-8 px-0">
                  <input type="text" class="form-control" placeholder="Woonplaats">
                </div>
                <div class="col-4 px-0">
                  <input type="text" class="form-control" placeholder="Postcode" >
                </div>
              </div>
            </div>
          </div>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-legend col-sm-4">* Geslacht</legend>
              <div class="col-sm-8">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="man" checked>
                    Man
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="vrouw">
                    Vrouw
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="gender" value="anders">
                    Geen van bovenstaande
                  </label>
                </div>
              </div>
            </div>
          </fieldset>
          <div class="form-group row">
              <label for="rekening" class="col-sm-4 col-form-label">* Rekeningnummer:</label>
              <div class="col-sm-8 px-0">
                <input  id="rekening" type="text" class="form-control" name="rekening" placeholder="NL12RABO0123456789" required>
              </div>
              <!-- NOTE: http://formvalidation.io/validators/iban/ ff checken #javascirpt Gr Kai -->
          </div>
          <div class="form-group row">
              <label for="noodnummer" class="col-sm-4 col-form-label">* Noodnummer:</label>
              <div class="col-sm-8 px-0">
                <input  id="noodnummer" type="text" class="form-control" name="noodnummer" placeholder="06 123 45 678" required>
              </div>
          </div>
          <div class="form-group row">
            <label for="tshirt" class="col-sm-4 col-form-label">* T-shirtmaat:</label>
            <div class="col-sm-8 px-0">
              <select id="tshirt" class="form-control" name="maat" required>
                <option selected disabled>Kies T-shirtmaat...</option>
                <option value="xs"> XS </option>
                <option value="s"> S </option>
                <option value="m"> M </option>
                <option value="l"> L </option>
                <option value="xl"> XL </option>
                <option value="xxl"> XXL </option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="Medicatie:" class="col-sm-4">Medicatie:</label>
            <div class="col-sm-8 px-0">
              <textarea class="form-control" id="Medicatie" name="medicatie" rows="4" placeholder="Ik gebruik deze medicatie"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="dieetwensen:" class="col-sm-4">Dieetwensen:</label>
            <div class="col-sm-8 px-0">
              <textarea class="form-control" id="dieetwensen" name="dieetwensen" rows="4" placeholder="Ik ... lust geen chocola. Ik ... ben allergisch voor gluten"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="opmerking:" class="col-sm-4">Opmerking:</label>
            <div class="col-sm-8 px-0">
              <textarea class="form-control" id="opmerking" rows="4" name="opmerking" placeholder="Wil je nog wat kwijt?"></textarea>
            </div>
          </div>
          <div class="form-group row">
              <label for="email" class="col-sm-4 col-form-label">* Emailadres:</label>
              <div class="col-sm-8 px-0">
                <input  id="email" type="email" class="form-control is-invalid" name="email" placeholder="voorbeeld@email.nl" required>
                <div class="invalid-feedback">
                  Gelieve een geldig emailadres in te vullen.
                </div>
              </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="inputPassword1">* Wachtwoord:</label>
              <div class="col-sm-8 px-0">
              <input type="password" id="inputPassword1" class="form-control" name="wachtwoord" aria-describedby="passwordHelpBlock">
              <small id="passwordHelpBlock" class="form-text text-muted">
              Je wachtwoord moet 8-60 karakters lang zijn, moet letters en nummers bevatten, en mag geen spaties bevatten.
              </small>
            </div>
          </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label" for="inputPassword2">* Herhaal wachtwoord:</label>
                <div class="col-sm-8 px-0">
                <input type="password" id="inputPassword2" class="form-control" name="herhaalwachtwoord">
              </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-9 offset-sm-4 px-0">
              <input class="btn btn-outline-primary" type="submit" name="registreer" value="Registreer">
            </div>
          </div>
          <!-- NOTE: door op deze knop te drukken wordt al deze info gestopt in de value registreer. *zie verwerk Gr Kai -->
=======
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
>>>>>>> d7da3c48ebbc173c91cc2e987dcbcaaba0181c6a
    </form>
  </div>
  </div>
  </div>
  </body>
</html>

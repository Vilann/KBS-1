<!DOCTYPE html>
<html>
  <head>
    <title></title>

    <?php include 'includes/header.php' ?>
    <h1>Log in</h1>
    <form action="verwerk.php" method="post">
      <table>
        <tr>
          <td><label for="Naam">E-mail: </label></td>
          <td><input id="Naam" type="email" name="naam" placeholder="ZHTC-emailadres"></td>
        </tr>
        <tr>
          <td><label for="Wachtwoord">Wachtwoord: </label></td>
          <td><input id="Wachtwoord" type="password" name="wachtwoord" value=""></td>
        </tr>
      </table>
      <br>
      <input type="submit" name="Verstuur">

      <p>
        <b>Nog geen lid?</b> <br>
        Wil jij lid worden van ZHTC? <br>
        Klik <a href="registreer.php">hier</a> <!-- TODO: website invullen -->
      </p>
    </form>
  </body>
</html>

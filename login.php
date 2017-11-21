<!DOCTYPE html>
<html>
  <head>
    <title></title>

    <?php include 'includes/header.php' ?>
    <h1>Log in</h1>
    <form action="verwerk.php" method="post">
      <table>
        <tr>
          <td><label for="email">E-mail: </label></td>
          <td><input id="email" type="email" name="email" placeholder="ZHTC-emailadres"></td>
        </tr>
        <tr>
          <td><label for="Wachtwoord">Wachtwoord: </label></td>
          <td><input id="Wachtwoord" type="password" name="wachtwoord" value=""></td>
        </tr>
      </table>
      <br>
      <input type="submit" name="Verstuur" value="login">

      <p>
        <b>Nog geen lid?</b> <br>
        Wil jij lid worden van ZHTC? <br>
        Klik <a href="registreer.php">hier</a> <!-- TODO: website invullen -->
      </p>
    </form>
  </body>
</html>

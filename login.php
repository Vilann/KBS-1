<?php
include('includes/beveiliging.php');
beveilig_lid();
if (isset($_SESSION['lid'])) {
    header("Location: index");
} else {
    ?>
<!DOCTYPE html>
<html>
  <head>
    <title>ZHTC - Login</title>

    <?php include 'includes/header.php' ?>
    <h1>Log in</h1>
    <form action="verwerk" method="post">
      <table>
        <tr>
          <td><label for="email">E-mail: </label></td>
          <td><input id="email" type="email" name="email" placeholder="Je eigen emailadres" required></td>

        </tr>
        <tr>
          <td><label for="Wachtwoord">Wachtwoord: </label></td>
          <td><input id="Wachtwoord" type="password" name="wachtwoord" value="" required></td>
        </tr>
      </table>
      <br>
      <input type="submit" name="login" value="login">

      <p>
        <b>Nog geen lid?</b> <br>
        Wil jij lid worden van ZHTC? <br>
        Klik <a href="registreer">hier</a>
      </p>
    </form>
  </body>
</html>
<?php
}
 ?>

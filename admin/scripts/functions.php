<?php
$username = $_POST['naam'];

echo $username;
            //Hier staat de functie om nieuwe polls toe te voegen.
            //Kijk of er niks leeg is gepost
            if(isset($_GET['as'])){
              print("test");
              if($_GET['as'] == "voorzitter"){
                $testvar = $_GET['naam'];
                print($_GET['naam']);
              }
                die($_GET['naam']);
            }
            print("ga werken!");
            die("ejej");
 ?>

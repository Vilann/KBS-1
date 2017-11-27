<?php

if (isset($_POST['verzend']) || isset($_POST['contactmail'])|| isset($_POST['contactnaam'])|| isset($_POST['contactbericht']) ) {


  $naam = $_POST['contactnaam'];
  $emailadres = $_POST['contactmail'];
  $bericht = $_POST['contactbericht'];
  $zhtcmailadres = "Iemands@emailadres.com";
  $onderwerp = "Een mail van $naam";
  $mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
    mail($zhtcmailadres, $onderwerp, $mailbericht);
      print ("hoho klopt ... $mailbericht");
};



//|| empty ($emailadres) || (empty ($bericht))

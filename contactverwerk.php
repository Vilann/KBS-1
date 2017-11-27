<?php

if (isset($_POST['verzend'])) {

};

$naam = $_POST['contactnaam'];
$emailadres = $_POST['contactmail'];
$bericht = $_POST['contactbericht'];
$zhtcmailadres = "Iemands@emailadres.com";
$onderwerp = "Een mail van $naam";
$mailbericht = "$naam heeft het volgende verstuurd: $bericht het emailadres van $naam is $emailadres";
if ((!empty($naam)) || (!empty($emailadres)) || (!empty($bericht))) {



    print ("hoho klopt");

    mail($zhtcmailadres, $onderwerp, $mailbericht);
}

//|| empty ($emailadres) || (empty ($bericht))
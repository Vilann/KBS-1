<?php
define("NOREPLY_HEADER", "From: noreply@zhtc.nl");
function mail_contact($afzender, $verzendernaam, $tekst)
{
    // Dit is voor de mail naar ZHTC, ze krijgen de mail vanaf het emailadres dat opgegeven is.
    $zhtc_contactmail = "jelle.santema@gmail.com"; // NOTE: pas dit aan naar secretariaat@zhtc.nl als we het live gooien!

    $to = $zhtc_contactmail;
    $subject = "Nieuwe mail van " . $verzendernaam;
    $message = $verzendernaam . " heeft dit ingevuld op het contactformulier:\n" . $tekst;
    $headers = "From: " . trim($afzender);

    // mail($to, $subject, $message, $headers);
    if (mail($to, $subject, $message, $headers)) {

      // Dit is voor de bevestiging naar degene die de mail gestuurd had.
        $to = $afzender;
        $subject = "Wij hebben uw mail ontvangen!";

        $message = "Beste " . $verzendernaam . ", \n
Dit is een geautomatiseerde bevestiging dat wij het contactformulier succesvol ontvangen hebben!
Ter herinnering, dit is wat u gestuurd heeft: \n\n" . $tekst .
"\n\nWij zullen zo snel mogelijk contact met u opnemen. \n
Met vriendelijke groet,
Secretariaat ZHTC

P.S. Dit is een noreply email-adres, hier kan niet op gereageerd worden.
";
        if (mail($to, $subject, $message, NOREPLY_HEADER)) {
        }
    }
}
function mail_bevestigen($to, $token, $name)
{
    $message =" Beste $voornaam,

Bedankt voor uw registratie op ZHTC.nl.


Klik op onderstaande link om uw registratie te voltooien en uw account te activeren:
<a>$token</a>




 Als u zich niet aangemeld heeft voor een account mag u deze e-mail als niet verzonden beschouwen

Bedankt!
Secretariaat ZHTC
P.S. Dit is een noreply email-adres, hier kan niet op gereageerd worden.
";
    $subject = "Activeren account ZHTC.nl ";
    mail($to, $subject, $message, NOREPLY_HEADER);
}

<?php

/*
Dit bestand bevat 2 functies voor beveiliging.
beveilig_lid is voor beveiliging van pagina's tegen leden.
Dit geldt nu alleen nog voor login en registreer, maar het is uitbreidbaar naar alle paginas waar bevoegdheden voor nodig zijn.

beveilig_nietlid is om paginas die voor alle leden inzichtbaar zijn, maar niet voor niet-leden te beschermen.
Vooralsnog is het alleen gebruikt op account, maar ook bijvoorbeeld de ideeënbox en polls horen hier bij.

Om ze te gebruiken: include dit bestand en roep de functie aan!

 */

session_start();
function beveilig_lid()
{
    if (isset($_SESSION['lid'])) {
        header('Location: index');
    }
}

function beveilig_nietlid()
{
    if (!isset($_SESSION['lid'])) {
        header('Location: index');
    }
}

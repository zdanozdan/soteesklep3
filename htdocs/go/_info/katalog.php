<?php
/**
 * katalog PDF
 * 
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$config->google['title'] = "Mikran - sklep - katalog produktow PDF";
$config->google['description'] = "Katalog produktow: protetyka, stomatologia, ortodoncja, dezynfekcja w formacie PDF albo on-line";
$config->google['keywords'] = "katalog, protetyka, ortodoncja";

$page = 0;
if (! empty($_REQUEST['page'])) {
    $page=$_REQUEST['page'];
}

if(!preg_match("/[0-9]+/",$_REQUEST['page']) && isset($_REQUEST['page']))
{
Header( "HTTP/1.1 404 Not Found" );
Header( "Location: /katalog-mikran-do-pobrania/nie-znaleziono-strony");
}

if($page > 154)
{
Header( "HTTP/1.1 404 Not Found" );
Header( "Location: /katalog-mikran-do-pobrania/nie-znaleziono-strony");
}

// naglowek
$theme->head();

$theme->page_open("","","","","","","katalog_pdf");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

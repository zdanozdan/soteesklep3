<?php
/**
 * Generowanie odpowiednich linkow dla kazdego partnera
 * Wywolanie funkcji link4partner z klasy GenLinks
 * 
 * @author piotrek@sote.pl
 * @version $Id: links.php,v 1.5 2005/01/20 15:00:02 maroslaw Exp $
 * @param $_REQUEST['partners'] - jesli $_REQUEST['partners']="on" to generuj linki dla wszystkich partnerow
 * @param $_REQUEST['item']['partner_name'] - numer partnera w tablicy $data  
* @package    partners
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/metabase.inc");
// end naglowek php

global $database;

// sprawdzam czy sa jakies rekordy w tabeli partners
$check=$database->sql_select("id","partners","");

require_once ("./include/links.inc.php");

$genlinks = new GenLinks;                 // definicja klasy

$theme->head();
$theme->page_open_head();

include("include/menu.inc.php");          // dolacz menu

// naglowek
$theme->bar($lang->partners_links);

print "<BR><BR>";

if (! empty($check)) {                    // jesli istnieja jakies rekordy w tabeli partners
    include("html/links.html.php");

    if(!empty($_REQUEST['partners'])) {
        $all="on";
    } else {
        if(!empty($_REQUEST['item']['partner_name'])) {
            $all=$_REQUEST['item']['partner_name'];
            $all=$data[$all];
        } else $all="on";
    }

// generuj linki dla wybranego badz wszystkich partnerow
$genlinks->link4partner($all);

} else print "<b>$lang->partners_attention</b><BR>$lang->partners_no_records"; // w przeciwnym wypadku pokaz komunikat o braku rekordow

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

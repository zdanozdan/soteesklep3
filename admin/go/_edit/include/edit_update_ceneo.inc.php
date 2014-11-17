<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z ceneoPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_ceneo.inc.php,v 2.2 2006/08/16 10:20:55 lukasz Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
	die ("Forbidden");
}

require_once("include/metabase.inc");
global $database;
global $id;

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
	$item=&$_REQUEST['item'];
} else {
	//die ("Forbidden: Unknown item");
	$item = array("ceneo_export" => 0);
}

// zaakutalizuj informacje o tym czy produkt jest eksportowany w glownej tablicy produktow
$database->sql_update("main","id=$id",array("ceneo_export"=>@$item['ceneo_export']));
?>

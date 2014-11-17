<?php
/**
* Dodaj nowega walute
*
* @author m@sote.pl
* /@modified_by m@sote.pl
* $Id: add.php,v 1.4 2005/02/24 14:00:40 scalak Exp $
* @package currency
*/

$global_database=true;
$global_secure_test=true;
global $country_error;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../../../include/head.inc");

$theme->head_window();
$theme->bar($lang->delivery_zone_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

$mod_table->add("delivery_zone","",array
			(
				"name"=>"check_name",
				"country"=>"check_country",
			),$lang->delivery_zone_form_errors
);

/*
* Zapisz dane w pliku.
*/
require_once ("./include/save.inc.php");

$theme->foot_window();

include_once ("include/foot.inc");
?>

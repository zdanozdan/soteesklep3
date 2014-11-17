<?php
/**
* Edycja waluty
*
* @author m@sote.pl
* @version $Id: edit.php,v 1.4 2005/07/19 08:30:57 scalak Exp $
* @package currency
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../../../include/head.inc");
require_once ("include/metabase.inc");

$theme->head_window();
$theme->bar($lang->delivery_volume_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->update("delivery_volume","",array
			(
				"name"=>"string",
				"range_max"=>"range_max",
			),$lang->delivery_volume_form_errors
);

$theme->foot_window();

include_once ("include/foot.inc");
?>

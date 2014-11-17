<?php
/**
* Edycja stef dostawy
*
* @author rdiak@sote.pl
* @version $Id: edit.php,v 1.7 2005/07/19 08:31:09 scalak Exp $
* @package zone
*/

$global_database=true;
$global_secure_test=true;
global $country_error;
global $id_zone;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../../../include/head.inc");
require_once ("include/metabase.inc");

$theme->head_window();
$theme->bar($lang->delivery_zone_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->update("delivery_zone","",array
			(
				"name"=>"check_name",
				"country"=>"check_country",
			),$lang->delivery_zone_form_errors
);

$theme->foot_window();

include_once ("include/foot.inc");
?>

<?php
/**
* Dodaj nowega walute
*
* @author m@sote.pl
* /@modified_by m@sote.pl
* $Id: add.php,v 1.4 2005/04/22 10:55:04 scalak Exp $
* @package currency
*/

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../../../include/head.inc");

$theme->head_window();
$theme->bar($lang->delivery_volume_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

$mod_table->add("delivery_volume","",array
			(
				"name"=>"string",
				"range_max"=>"range_max_add",
			),$lang->delivery_volume_form_errors
);

$theme->foot_window();

include_once ("include/foot.inc");
?>

<?php
/**
* Edycja waluty
*
* @author m@sote.pl
* @version $Id: edit.php,v 2.11 2005/04/13 12:30:49 maroslaw Exp $
* @package    currency
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../include/head.inc");

$__edit=true;

$theme->head_window();
$theme->bar($lang->currency_update_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->update("currency","currency",array
(
"currency_name"=>"string",
"currency_val"=>"price"),
$lang->currency_form_errors
);

/**
* Zapisz dane w pliku.
*/
require_once ("./include/save.inc.php");
$theme->foot_window();

include_once ("include/foot.inc");
?>

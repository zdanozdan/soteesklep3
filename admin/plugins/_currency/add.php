<?php
/**
* Dodaj nowega walute
*
* @author m@sote.pl
* /@modified_by m@sote.pl
* $Id: add.php,v 2.9 2005/04/01 10:29:17 maroslaw Exp $
* @version    $Id: add.php,v 2.9 2005/04/01 10:29:17 maroslaw Exp $
* @package    currency
*/

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../include/head.inc");

$theme->head_window();
$theme->bar($lang->currency_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;
$mod_table->add("currency","currency",array
(
"currency_name"=>"currency_name",
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

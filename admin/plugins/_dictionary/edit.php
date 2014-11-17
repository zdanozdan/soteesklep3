<?php
/**
 * PHP Template:
 * Edytuj rekord z tabeli dictionary
 * 
 * @author piotrek@sote.pl
 * @version $Id: edit.php,v 2.6 2005/01/20 14:59:47 maroslaw Exp $
* @package    dictionary
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/metabase.inc");

$mydatabase = new my_Database;

$theme->head_window();
$theme->bar($lang->dictionary_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("dictionary","",array("wordbase"=>"string"),
                   $lang->dictionary_form_errors
                   );


$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

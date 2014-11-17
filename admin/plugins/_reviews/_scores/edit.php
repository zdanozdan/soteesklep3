<?php
/**
 * PHP Template:
 * Edytuj rekord z tabeli reviews
 * 
 * @author m@sote.pl
 * @version $Id: edit.php,v 1.3 2005/01/20 15:00:09 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

$theme->head_window();
$theme->bar($lang->scores_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("scores","",array("score_amount"=>"scores",
                                     "scores_number"=>"scores"),
                   $lang->scores_form_errors
                   );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

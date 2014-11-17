<?php
/**
 * PHP Template:
 * Edytuj rekord z tabeli reviews
 * 
 * @author m@sote.pl
 * \@template_version Id: edit.php,v 2.1 2003/03/13 11:28:49 maroslaw Exp
 * @version $Id: edit.php,v 1.6 2005/10/20 06:44:45 krzys Exp $
* @package    reviews
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// end naglowek php

$theme->head_window();
$theme->bar($lang->reviews_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("reviews","",array("user_id"=>"user_id"),
                   $lang->reviews_form_errors
                   );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

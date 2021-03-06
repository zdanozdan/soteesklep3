<?php
/**
* Edytuj rekord z tabeli newsedit_groups
*
* @author  m@sote.pl
* \@template_version Id: edit.php,v 2.4 2004/02/12 10:47:50 maroslaw Exp
* @version $Id: edit.php,v 1.7 2005/07/18 07:17:30 lukasz Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;


$theme->head_window();
$theme->bar($lang->newsedit_groups_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("newsedit_groups","",array(
	"name"=>"string",
	"multi"=>"multi",
	),
	$lang->newsedit_groups_form_errors
);

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

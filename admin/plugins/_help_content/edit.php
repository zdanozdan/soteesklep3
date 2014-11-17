<?php
/**
 * Edytuj rekord z tabeli help_content
 * 
 * @author  lech@sote.pl
 * \@template_version Id: edit.php,v 2.4 2004/02/12 10:47:50 maroslaw Exp
 * @version $Id: edit.php,v 1.6 2005/01/20 14:59:52 maroslaw Exp $
* @package    help_content
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;


$theme->head_window();
$theme->bar($lang->help_content_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("help_content","",array("title"=>"string",
                                      "html"=>"null",
                                      "author"=>"string",
                                      ),
                   $lang->help_content_form_errors
                   );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

<?php
/**
 * Edytuj rekord z tabeli promotions
 * 
 * @author  m@sote.pl
 * \@template_version Id: edit.php,v 2.3 2003/06/20 12:41:22 maroslaw Exp
 * @version $Id: edit.php,v 1.3 2005/01/20 15:00:07 maroslaw Exp $
* @package    promotions
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/ftp.inc.php");
require_once ("./include/file.inc.php");

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;

$theme->head_window();
include_once ("./include/menu_edit_add.inc.php");
$theme->bar($lang->promotions_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("promotions","",array("name"=>"string",
                                         "discount"=>"discount"
                                        ),
                   $lang->promotions_form_errors
                   );


//# zapisz wartosci tablicy w pliku configuracyjnym 
// include_once ("./include/user_config.inc.php"); 

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

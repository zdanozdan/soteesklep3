<?php
/**
 * PHP Template:
 * Edytuj rekord z tabeli vat
 * 
 * @author m@sote.pl
 * \@template_version Id: edit.php,v 2.1 2003/03/13 11:28:49 maroslaw Exp
 * @version $Id: edit.php,v 1.3 2005/01/20 14:59:33 maroslaw Exp $
* @package    options
* @subpackage vat
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

$theme->head_window();
$theme->bar($lang->vat_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("vat","",array("vat"=>"vat"),
                   $lang->vat_form_errors
                   );


//# zapisz wartosci tablicy w pliku configuracyjnym 
// include_once ("./include/user_config.inc.php"); 

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

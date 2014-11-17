<?php
/**
 * Edytuj rekord z tabeli main_keys_ftp
 * 
 * @author  m@sote.pl
 * \@template_version Id: edit.php,v 2.3 2003/06/20 12:41:22 maroslaw Exp
 * @version $Id: edit.php,v 1.3 2005/01/20 14:59:54 maroslaw Exp $
* @package    main_keys
* @subpackage main_keys_ftp
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

$theme->head_window();
$theme->bar($lang->main_keys_ftp_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("main_keys_ftp","",array("ftp"=>"string",
                                      "user_id_main"=>"string"),
                   $lang->main_keys_ftp_form_errors
                   );


//# zapisz wartosci tablicy w pliku configuracyjnym 
// include_once ("./include/user_config.inc.php"); 

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

<?php
/**
 * Dodaj rekord do tabeli main_keys
 * 
 * @author  m@sote.pl
 * \@template_version Id: add.php,v 2.3 2003/07/29 08:40:19 maroslaw Exp
 * @version $Id: add.php,v 1.4 2005/01/20 14:59:53 maroslaw Exp $
* @package    main_keys
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
// require_once("include/gen_user_config.inc.php");

$theme->head_window();
$theme->bar($lang->main_keys_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("main_keys","",array("user_id_main"=>"user_id_main",
                                     "order_id"=>"order_id"),
                $lang->main_keys_form_errors
                );

//# zapisz wartosci tablicy w pliku configuracyjnym
// include_once ("./include/user_config.inc.php");

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

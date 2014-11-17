<?php
/**
 * PHP Template:
 * Dodaj rekord do tabeli discounts
 * 
 * @author m@sote.pl
 * \@template_version Id: add.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: add.php,v 2.3 2005/01/20 14:59:48 maroslaw Exp $
* @package    discounts
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

$theme->head_window();
$theme->bar($lang->discounts_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("discounts","",array("idc"=>"string",
                                   "idc_name"=>"string"),
                $lang->discounts_form_errors
                );

//# zapisz wartosci tablicy w pliku configuracyjnym
// include_once ("./include/user_config.inc.php");

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

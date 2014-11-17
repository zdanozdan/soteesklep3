<?php
/**
 * Dodaj rekord do tabeli edit_producer
 * 
 * @author  m@sote.pl
 * \@template_version Id: add.php,v 2.2 2003/06/14 21:59:35 maroslaw Exp
 * @version $Id: add.php,v 1.4 2005/01/20 14:59:23 maroslaw Exp $
* @package    edit_producer
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
$theme->bar($lang->edit_producer_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("producer","",array("producer"=>"producer"),
                $lang->edit_producer_form_errors
                );

//# zapisz wartosci tablicy w pliku configuracyjnym
// include_once ("./include/user_config.inc.php");

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

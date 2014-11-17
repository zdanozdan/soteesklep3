<?php
/**
* Konfiguracja sklepu, ró¿ne elementy z config.inc.php itp. 
* Skrypt odczytuje dane z formularza i zapisuje odpowiednie warto¶ci w pliku konfiguracyjnym u¿ytkownika.
* Plik do którego zapisywane s± dane: config/auto_config/user_config.inc.php
*
* @author  krzys@sote.pl
* @version $Id: index.php,v 1.4 2005/02/03 11:35:21 maroslaw Exp $
* @package configure
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();
include_once ("./include/menu.inc.php");
include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

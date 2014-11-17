<?php
/**
* Aktualizacja lang'ów w bazie danych na podstwiea danych z plików lang.inc.php. Info + link do aktualizacji.
*
* System odczytuja wszystkie definicje zmiennych zapisanych w lang.inc.php 
* i wpisuje je do bazy. Przed importem poprzednie dane s± kasowane. Kasowanie
* nie powoduje utraty wcze¶niej wpisanych danych, gdy¿ ka¿da zmiana orpócz zapisania w bazie
* jest zapisywana w odpowiednim pliku, dlatego te¿ przy kolejnym imporcie w bazie bêd± aktualne dane.
* Modu³ ten s³u¿y do uaktualnienia listy langów np. po wprowadzeniu modyfikacji, dodaniu jakiego¶ nowego modu³u,
* mowych wpisów lub zmian w plikahc lang.inc.php.
*
* @author  m@sote.pl
* @version $Id: update.php,v 1.3 2005/01/20 14:59:25 maroslaw Exp $
* @package    lang_editor
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
/* Klasa LangEditor */ 
require_once("./include/lang_editor.inc.php"); 

$theme->head();
$theme->page_open_head();

$theme->bar($lang->lang_editor_update_title);
print "<p />\n";
print $lang->lang_editor_update_info;
print "<p />\n";

print "<center>\n";
$buttons->button($lang->lang_editor_update_button,"update2.php");
print "</center>\n";

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");

?>

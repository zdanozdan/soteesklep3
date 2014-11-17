<?php
/**
 * Optymalizacja danych, aktualizacja kategorii, dostepnosci itp.
 * wybor rodzaju optymalizacji, informacja
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 2.6 2005/01/20 14:59:29 maroslaw Exp $
* @package    opt
 */

$global_database=true;
$__secure_test=true;$global_secure_test=&$__secure_test;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();
include_once("./include/menu.inc.php");
$theme->bar($lang->bar_title['opt']);

include_once ("./html/opt.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

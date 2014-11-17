<?php
/**
* Modul, ktory importuje aktulane kursy walut ze strony nbp
*
* @author  krzys@sote.pl
* @version $Id: nbp.php,v 2.6 2005/01/20 14:59:46 maroslaw Exp $
* @package    currency
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../include/head.inc");

/** Obsluga generowania pliku konfiguracyjnego uzytkwonika */
require_once("include/gen_user_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->currency_nbp_bar);
print "<p>";

include_once("include/get_values.inc.php");


$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

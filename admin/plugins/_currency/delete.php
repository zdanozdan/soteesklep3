<?php
/**
 * Usun zaznaczone waluty
 *
 * @author m@sote.pl
 * @version $Id: delete.php,v 2.11 2006/03/22 13:45:34 lechu Exp $
* @package    currency
 */

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../include/head.inc");
/** obsluga generowania pliku konfiguracyjnego uzytkwonika */
require_once("include/gen_user_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->bar_title['currency']);
print "<p>";

// sprawd¼ czy mo¿na usun±æ dane rekordy
require_once ("./include/delete_check.inc.php");
$del_check =& new Currency_Delete_Check();

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete =& new Delete;
$delete->deleteAllCheck("currency","id",$del_check);

/**
* Zapisz dane w pliku.
*/
$_REQUEST['update'] = true;
require_once ("./include/save.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

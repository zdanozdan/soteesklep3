<?php
/**
* Usuñ zaznaczone do usuniêcia transakcje.
*
* @author m@sote.pl
* @version $Id: delete.php,v 2.6 2005/01/20 14:59:34 maroslaw Exp $
* @package    order
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->delivery_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("./include/delete.inc.php");
if (! empty($_REQUEST['del'])) {
    foreach ($_REQUEST['del'] as $id=>$val) {
        if (! empty($val)) {
            DeleteOrder::delete($id);
        }
    }
}
$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

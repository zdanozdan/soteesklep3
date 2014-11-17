<?php
/**
* Skrypt usuwaj±cy zaznaczone do usuniêcia statusy transakcji.
*
* @author  m@sote.pl
* @version $Id: delete.php,v 2.4 2005/01/20 14:59:36 maroslaw Exp $
* @package    order
* @subpackage status
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³owek skryptu
*/
require_once ("../../../../include/head.inc");
require_once ("./include/delete.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("../lang/_$config->lang/lang.inc.php");
include_once ("../include/menu_top.inc.php");

//include_once ("../include/menu.inc.php");
include_once ("./include/menu.inc.php");
$theme->bar($lang->order_status_bar);

print "<p>";

if (! empty($_REQUEST['del'])) {
    $del=$_REQUEST['del'];
    // lista produktow do usuniecia
    while (list($id,) = each($del)) {
        if (! empty($id)) {
            $delete->delete($id);
        }
    }
} else {
    print "<center>".$lang->delete_empty."</center>";
}


$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

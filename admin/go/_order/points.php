<?php
/**
 * Wprowadzanie przelicznika punktow. Ilo¶æ punktów nadawane klientowi za ka¿de 100 "z³" zakupów.
 *
 * @author  m@sote.pl
 * @version $Id: points.php,v 2.5 2005/01/20 14:59:35 maroslaw Exp $
* @package    order
 */
 
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();

if ((! empty($_POST['update']))  && ($_POST['update']==true)){
    require_once("./include/update_points.inc.php");
}

// menu z linkami (wyszukianie, lista transkacji itp)
include_once("./include/menu.inc.php");
$theme->bar($lang->order_info_title);

$theme->theme_file("points.html.php");

$theme->page_open_foot();
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

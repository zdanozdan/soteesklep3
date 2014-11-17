<?php
/**
* @version    $Id: menu.html.php,v 1.3 2004/12/20 18:01:21 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
?>
Podreczne menu boom boom

<?php
global $theme,$lang;
print ("<CENTER>");
require_once ("include/set_icons.inc.php");
$set_icons = new SetIcons;
$icons=array();
$set_icons->add($icons,"edit.png","/go/_text/",$lang->icons['text']);
$set_icons->add($icons,"news.gif","/plugins/_newsletter/_users/index.php",$lang->icons['newsletter']);
$set_icons->add($icons,"discount.png","/plugins/_discounts/index.php",$lang->icons['discounts']);
$set_icons->add($icons,"partners.png","/plugins/_partners/index.php",$lang->icons['partners']);
$set_icons->add($icons,"clients.png","/go/_users/",$lang->icons['customers']);
$set_icons->add($icons,"promo.gif","/plugins/_promotions/index.php",$lang->icons['promotions']);
$set_icons->add($icons,"trans.gif","/go/_order/",$lang->icons['orders']);
$theme->table_list($icons,1,100);
print ("</CENTER");
?>

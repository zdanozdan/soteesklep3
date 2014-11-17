<?php
/**
* @version    $Id: left.html.php,v 1.1 2005/12/12 14:55:24 krzys Exp $
* @package    themes
* @subpackage base_theme
*/
$this->win_top($lang->left_choose_category,180,1,1);
include_once ("include/category_show.inc");
$this->win_bottom();
?>
<BR>
<?php
$this->win_top($lang->bar_title['promotion'],180,1,1);
print ("<CENTER>");
$rand_prod->show_products("promotion",$config->random_on_page['promotion']);
print ("</CENTER>");
$this->win_bottom();
?>
<br>
<?php
global $shop;
$shop->currency->currencyList();
?>
<br>
<?php
$this->win_top(@$lang->bar_title["info"],180,0,1);
$this->file("left_window.html","");
$this->win_bottom();
?>

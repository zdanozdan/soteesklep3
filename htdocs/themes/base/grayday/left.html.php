<?php
/**
* @version    $Id: left.html.php,v 1.5 2005/12/30 09:30:31 krzys Exp $
* @package    themes
* @subpackage grayday
*/
$box_width = 160;
?>
<table style="height: 100%" width="171" bgcolor="<?php echo $config->theme_config['colors']['color_1']; ?>" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" height="100%" valign="top" align="center">
<?php $this->search_form("vertical"); ?>
<br>
<?php
$this->win_top($lang->left_choose_category,$box_width,1,1);
include_once ("include/category_show.inc");
$this->win_bottom($box_width);
?>
<br />
<br />
<?php
$this->win_top($lang->bar_title['promotion'],$box_width,1,1);
print ("<CENTER>");
$rand_prod->show_products("promotion",$config->random_on_page['promotion']);
print ("</CENTER>");
$this->win_bottom($box_width);
?>
<br />
<br />
<?php
$this->win_top(@$lang->bar_title["info"],160,0,1);
$this->file("left_window.html","");
$this->win_bottom(160);
?>
<?php
global $__start_page, $prefix;
if ($__start_page==true) {
?>
<table align="center" valign=bottom border="0">
  <tr> 
    <td align="left"> 
      <?php
      global $shop;
      $shop->currency->currencyList();
      ?>
    </td>
  </tr>
</table>
<?php
}
?>

    </td>
    <td bgcolor="<?php echo $config->theme_config['colors']['input_border']; ?>" height="100%"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
  </tr>
</table>

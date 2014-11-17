<?php
/**
* @version    $Id: right.html.php,v 1.8 2005/12/30 09:28:24 krzys Exp $
* @package    themes
* @subpackage blueday
*/
$box_width = 164;
?>
<table height="100%" width="176" bgcolor="<?php echo $config->theme_config['colors']['color_1']; ?>" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td bgcolor="<?php echo $config->theme_config['colors']['input_border']; ?>" height="100%"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
        <td width="100%" align="center" height="100%" valign="top">
         
<?php
global $config;
if ($config->catalog_mode==0){ 
$this->basketLink();
$this->wishlistLink();
?>
            <img src="<?php $this->img(''); ?>" width="1" height="7">
<?php
}
//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if (((@$config->catalog_mode==0) && ($config->newsletter==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['newsletter']==1))){
    $this->newsletter();
?>
            <img src="<?php $this->img(''); ?>" width="1" height="7">
<?php
}
?>
<?php
$this->win_top($lang->bar_title["newcol"],$box_width,1,1);
print ("<CENTER>");
$rand_prod->show_products("newcol",$config->random_on_page['newcol']);
print ("</CENTER>");
$this->win_bottom($box_width);
?>
<?php
global $shop;
//$shop->currency->currencyList();
?>
<?php
global $__start_page, $prefix;
if ($__start_page==true) {
?>
<table align="center" valign=bottom border="0">
  <tr> 
    <td align="right"> 
      <div align=right> 
        <?php $this->show_themes();?>
      </div>
    </td>
  </tr>
</table>
<?php
}
?>
<br>
<?php
$this->win_top(@$lang->bar_title["info"],160,0,1);
$this->file("right_window.html","");
$this->win_bottom(160);
?>     
    </td>
  </tr>
</table>


<?php
/**
* @version    $Id: right.html.php,v 1.2 2004/12/20 18:01:02 maroslaw Exp $
* @package    themes
*/
?>
<table height="100%" width="176" bgcolor="#e7e7e8" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td bgcolor="#bfbfbf" height="100%"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
        <td width="100%" align="center" height="100%" valign="top">
            
<?php
global $config;
$this->basketLink();
?>
            <img src="<?php $this->img(''); ?>" width="1" height="7">
<?php

//sprawdzenie czy opcja newsletter jest wybrana przez administratora
if ($config->newsletter==1){
    $this->newsletter();
?>
            <img src="<?php $this->img(''); ?>" width="1" height="7">
<?php
}
?>
<?php
$this->win_top($lang->bar_title["newcol"],175,1,1);
print ("<CENTER>");
$rand_prod->show_products("newcol",2);
print ("</CENTER>");
$this->win_bottom(175);
?>
<?php
global $shop;
//$shop->currency->currencyList();
?>
    </td>
  </tr>
</table>

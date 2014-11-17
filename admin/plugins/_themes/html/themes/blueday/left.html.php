<?php
/**
* @version    $Id: left.html.php,v 1.2 2004/12/20 18:01:01 maroslaw Exp $
* @package    themes
*/
?>
<table style="height: 100%" width="171" bgcolor="#e7e7e8" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" height="100%" valign="top">
<?php
$this->win_top($lang->left_choose_category,170,1,1);
include_once ("include/category_show.inc");
$this->win_bottom(170);
?>
<br />
<br />
<?php
$this->win_top($lang->bar_title['promotion'],170,1,1);
print ("<CENTER>");
$rand_prod->show_products("promotion",3);
print ("</CENTER>");
$this->win_bottom(170);
?>
<br />
<br />
<?php
//$this->win_top(@$lang->bar_title["info"],180,0,1);
//$this->file("left_window.html","");
//$this->win_bottom();
?>
    </td>
    <td bgcolor="#bfbfbf" height="100%"><img src="<?php $this->img(''); ?>" width="1" height="1"></td>
  </tr>
</table>

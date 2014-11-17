<?php
/**
* @version    $Id: main.html.php,v 1.4 2004/12/20 17:58:46 maroslaw Exp $
* @package    options
*/

print ("<CENTER>");
require_once ("include/set_icons.inc.php");
$set_icons = new SetIcons;
$icons=array();
$set_icons->add($icons,"deliver.png","/go/_options/_delivery/index.php",$lang->icons['delivery']);
$set_icons->add($icons,"aable.gif","/go/_options/_available/index.php",$lang->icons['availability']);
$set_icons->add($icons,"vat.png","/go/_options/_vat/index.php",$lang->icons['vat']);
if (in_array("currency",$config->plugins)) { 
	$set_icons->add($icons,"course.gif","/plugins/_currency/",$lang->icons['currency']);
}	

$theme->table_list($icons,4,100);
print ("</CENTER");

?>
<!--
<p>
<table align=center>
<tr>
  <td align=center><?php $theme->icon("deliver.png","/go/_options/_delivery/index.php",$lang->icons['delivery']);?></td> 
  <td align=center><?php $theme->icon("aable.gif","/go/_options/_available/index.php",$lang->icons['availability']);?></td>
  <td align=center><?php $theme->icon("vat.png","/go/_options/_vat/index.php",$lang->icons['vat']);?></td>

  <?php if (in_array("currency",$config->plugins)) { ?>
  <td align=center><?php $theme->icon("course.gif","/plugins/_currency/",$lang->icons['currency']);?></td>	
  <?php } ?>


</tr>
</table>
-->

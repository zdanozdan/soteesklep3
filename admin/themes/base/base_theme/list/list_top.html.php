<?php
/**
* @version    $Id: list_top.html.php,v 1.2 2004/12/20 18:01:26 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
global $config;
if ($config->nccp==0x1388) {
?>
<TABLE border=0>
 <TR>
  <TD align=left>
   <?php print $lang->choose;?>:
  </TD>
  <TD>
    <a href='<?php print $rrlinks->short;?>'>
    <u><?php print $lang->short_list;?></u></a> |
    <a href='<?php print $rrlinks->long;?>'><u><?php print $lang->full_list; ?></u></a>
  </TD>
<?php
}
?>
<?php
// ----- start producer -----
if (in_array("producer_list",$config->plugins)) {
    global $producer_list;
    if (method_exists($producer_list,"show")) {    
        print "<TR><TD>$lang->producers:</TD>";
        print "<TD>";
        $producer_list->show();
        print "</TD></TR>";
    }
}
// ----- end producer -----
?>

<?php
// ----- start order_by_list -----
if (in_array("order_by_list",$config->plugins)) {
    global $order_by_list;
    if (method_exists($order_by_list,"show")) {
        print "<TR><TD>";
        print "$lang->sort:</TD>";
        print "<TD>";
        $order_by_list->show();
        print "</TD></TR>";
    }
}
// ----- end order_by_list -----
?>
  </TD>
 </TR>
</TABLE>
<P>

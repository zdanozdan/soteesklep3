<!-- list_top.top.html -->
<?php
/**
* HTML v4.01
*
* @author rp@sote.pl
* @version    $Id: list_top.html.php,v 1.1 2006/09/27 21:53:23 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<div id="block_top_list">

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="30px">
<?php
// ----- start producer -----
if ((in_array("choose_list",$config->plugins)) && ($config->cd!=1)) {
    print "  <tr>";
    echo   '<td align="left"><b>'.$lang->choose.':</b>&nbsp;&nbsp;';
    print "<a rel=\"nofollow\" href=\"".$rrlinks->short."\">".$lang->short_list."</a>&nbsp;&nbsp;&nbsp;&nbsp;<a rel=\"nofollow\" href=\"".$rrlinks->long."\">".$lang->full_list."</a></td>";
}
?>


<?php
// ----- start order_by_list -----
if ((in_array("order_by_list",$config->plugins)) && ($config->cd!=1)) {
    global $order_by_list;
    if (method_exists($order_by_list,"show")) {
        echo   '<td><div style="text-align: right;"><b>'.$lang->sort.':</b>&nbsp;&nbsp;';
        $order_by_list->show();
        print "</div></td>";
        print "  </tr>";
    }
}
// ----- end order_by_list -----
?>
  
</table>
</div>


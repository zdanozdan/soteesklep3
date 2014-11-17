<?php
/**
 * Wstaw liste sortowania tabeli order_register
 *
 * @author  p@sote.pl
 * @version $Id: order_register.inc.php,v 1.2 2004/12/20 18:00:26 maroslaw Exp $
* @package    partners
 */ 


print "<TABLE border=0>";
// ----- start order_by_list -----
if (in_array("order_by_list",$config->plugins)) {
    require_once ("./include/order_by_list_register.inc");
    global $order_by_list_register;
    if (method_exists($order_by_list_register,"show")) {
        print "<TR><TD>";
        print "$lang->sort:</TD>";
        print "<TD>";
        $order_by_list_register->show();
        print "</TD></TR>";
    }
}
// ----- end order_by_list -----
print "</TABLE>";
?>

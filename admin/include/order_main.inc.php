<?php
/**
 * Wstaw liste sortowania tabeli main
 *
 * @author  m@sote.pl
 * @version $Id: order_main.inc.php,v 2.3 2004/12/20 17:59:24 maroslaw Exp $
* @package    admin_include
 */ 


print "<TABLE>";
// ----- start producer -----
if ((in_array("producer_list",$config->plugins))  && (! empty($__get_idc))){
    include_once ("./include/producers.inc.php");      // lista producentow w danej kategorii
    global $producer_list;
    if (method_exists($producer_list,"show")) {    
        print "<TR><TD>$lang->producers:</TD>";
        print "<TD>";
        $producer_list->show();
        print "</TD></TR>";
    }
}
// ----- end producer -----

// ----- end order_by_list -----
print "</TABLE>";
?>

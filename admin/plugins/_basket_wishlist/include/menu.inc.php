<?php
/**
* Menu modu³u polecania produktów
* 
* @author  m@sote.pl lech@sote.pl
* @version    $Id: menu.inc.php,v 1.1 2005/12/09 14:26:42 lechu Exp $
* @package    _basket_wishlist
*/
/*
print "<table><tr>\n";
print "<td>"; $buttons->button($lang->menu_tabs['assoc_rules1'],"/plugins/_assoc_rules/index.php"); print "</td>\n";
print "<td>"; $buttons->button($lang->menu_tabs['assoc_rules2'],"/plugins/_assoc_rules/index2.php"); print "</td>\n";
print "</tr></table>\n";
*/

if (@$__no_head!=1) {
    
    print "<div align=right>";
    
    
    $buttons->menu_buttons(array(
            $lang->menu['main'] => "index.php",
            $lang->menu['help'] => "/plugins/_help_content/help_show.php?id=49  onClick=\"open_window(300,500);\" target=window",
        )
    );
    
    print "</div>";
}
?>

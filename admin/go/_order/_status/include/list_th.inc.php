<?php
/**
* Nazwy elementow (kolumn) nad lsita statustow transakcji
*
* @author  m@sote.pl
* @version $Id: list_th.inc.php,v 2.3 2004/12/20 17:58:52 maroslaw Exp $
* @package    order
* @subpackage status
*/

/**
* Nag³owek tabeli listy statusów.
*
* @return string HTML
*/ 
function order_status_list_th() {
    global $lang,$theme;
    
    $o="<table align=center>\n";
    $o.="<tr bgcolor=$theme->bg_bar_color_light>\n";
    $o.="<th>".$theme->nameOrder($lang->id,1)."</th>\n";
    $o.="<th></th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_status_list['name'],2)."</th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_status_list['send_mail'],3)."</th>\n";
    $o.="<th>$lang->trash</th>\n";
    $o.="</tr>\n";
    
    return $o;
} // end delivery_list_th()

?>

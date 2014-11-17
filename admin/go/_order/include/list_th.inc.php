<?php
/**
* Nazwy elementow nad lista transakcji
* 
* @author  m@sote.pl
* @version $Id: list_th.inc.php,v 2.6 2005/12/07 13:46:43 lukasz Exp $
* @package    order
*/

/**
* \@global bool $__disable_trash true - nie pokazuj pola "usun"
*/

/**
* Nag³owek tabeli listy transkacji.
*
* @return string HTML
*/
function order_list_th() {
    global $__disable_trash;
    global $lang;
    global $config,$theme, $__no_head, $_print_mode;
    
    
    $o="<p />";
    if(!$_print_mode)
    	$o.="<table align=center>\n";
    else {
    	$o.="<table align=center border=1 cellspacing=0 cellpadding=2>\n";
    	$theme->bg_bar_color_light = "white";
    }
    
    /**
    * wyszukiwanie przy liscie
    */
    /*
    $o.="<tr>\n";
    $o.="<td><input type=text size=6 name=search[id]></td>\n";
    $o.="<td></td>\n";
    $o.="<td><input type=text size=10 name=search[date]></td>\n";
    $o.="<td><input type=text size=8 name=search[amount]></td>\n";
    $o.="<td><input type=text size=6 name=search[status]></td>\n";
    $o.="<td><input type=text size=8 name=search[payed]></td>\n";
    if (in_array("confirm_online",$config->plugins)) {
        $o.="<td><input type=text size=8 name=search[payed_online]></td>\n";
    }
    $o.="<td><input type=text size=12 name=search[payment]></td>\n";    
    $o.="<td><input type=submit value=".$lang->search."></td>\n";
    $o.="</tr>\n";
    */
    
    $o.="<tr bgcolor=$theme->bg_bar_color_light><th>".$theme->nameOrder("ID",1)."</th>\n";
    if(!$_print_mode)
	    $o.="<th>&nbsp;</th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_list['date'],2)."</th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_list['amount'],3)."</th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_list['status'],4)."</th>\n";
    $o.="<th>".$theme->nameOrder($lang->order_list['paid'],5)."</th>\n";
    if (in_array("confirm_online",$config->plugins)) {
        $o.="<th>".$theme->nameOrder($lang->order_list['paid_online'],6)."</th>\n";
    }
    $o.="<th>".$theme->nameOrder($lang->order_list['payment'],7)."</th>\n";   
    if ((@$__disable_trash!=true) && (!$_print_mode)) {
        $o.="<th>$lang->trash</th>";
    }
    $o.="<th></th>\n";
    $o.="</tr>\n";
    
    return $o;
} // end order_list_th()

?>

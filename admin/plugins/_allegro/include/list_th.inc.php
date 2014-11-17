<?php
/**
* Nazwy elementow nad lista - lista dostawcow
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 1.1 2006/04/12 11:45:28 scalak Exp $
* @package soteesklep
*/

function allegro_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>".$theme->nameOrder($lang->id,1)."</th>";
	$o.="<th>".$theme->nameOrder($lang->allegro_list['allegro_product_name'],2)."</th>";
	$o.="<th>".$theme->nameOrder($lang->allegro_list['allegro_price_start'],3)."</th>";
	$o.="<th>".$theme->nameOrder($lang->allegro_list['allegro_send'],4)."</th>";
	$o.="<th>$lang->allegro_send</th>";
	$o.="<th>$lang->trash</th>";
	$o.="</tr>\n";
	
	return $o;
} // end allegro_list_th()
?>
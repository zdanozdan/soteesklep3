<?php
/**
* Nazwy elementow nad lista - lista dostawcow
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 2.1 2004/06/03 12:05:18 maroslaw Exp $
* @package soteesklep
*/

function delivery_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>".$theme->nameOrder($lang->id,1)."</th>";
	$o.="<th></th>";
	$o.="<th>".$theme->nameOrder($lang->delivery_list['name'],2)."</th>";
	$o.="<th>".$theme->nameOrder($lang->delivery_list['nofee'],3)."</th>";
	$o.="<th>".$theme->nameOrder($lang->delivery_list['brutto_price'],4)."</th>";
	$o.="<th>".$theme->nameOrder($lang->delivery_list['order'],5)."</th>";
	$o.="<th>$lang->trash</th>";
	$o.="</tr>\n";
	
	return $o;
} // end delivery_list_th()
?>
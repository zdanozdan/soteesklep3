<?PHP

/**
* Nazwy elementow nad lista - lista walut
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 1.1 2004/11/22 10:44:22 scalak Exp $
* @package currency
*/

/** Funkcja wyswietlaj±ca nazwy elementów nad list± walut */ 
function delivery_zone_list_th() {
	global $lang,$theme;
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light><th>".$theme->nameOrder("ID",1)."</th>\n";
	$o.="<th></th>\n";
	$o.="<th>".$theme->nameOrder($lang->delivery_zone_cols['zone'],2)
	."</th><th>".$theme->nameOrder($lang->delivery_zone_cols['country'],3)
	."</th><th>".$lang->trash.
	"</th></tr>";
	return $o;
	
	return;
} // end currency_listh_th
?>    
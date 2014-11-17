<?PHP

/**
* Nazwy elementow nad lista - lista walut
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 1.2 2005/02/09 13:56:01 scalak Exp $
* @package currency
*/

/** Funkcja wyswietlaj±ca nazwy elementów nad list± walut */ 
function delivery_volume_list_th() {
	global $lang,$theme;
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light><th>".$theme->nameOrder("ID",1)."</th>\n";
	$o.="<th></th>\n";
	$o.="<th>".$theme->nameOrder($lang->delivery_volume_cols['name'],2)
	."</th><th>".$theme->nameOrder($lang->delivery_volume_cols['range_max'],3)
	."</th><th>".$lang->trash.
	"</th></tr>";
	return $o;
	
	return;
} // end currency_listh_th
?>    
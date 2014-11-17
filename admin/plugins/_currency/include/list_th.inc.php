<?php
/**
* @package    currency
*/

/**
* Nazwy elementow nad lista - lista walut
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 2.4 2004/12/20 17:59:31 maroslaw Exp $
* @package currency
*/

/** Funkcja wyswietlaj±ca nazwy elementów nad list± walut */ 
function currency_list_th() {
	global $lang,$theme;
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light><th>".$theme->nameOrder("ID",1)."</th>\n";
	$o.="<th></th>\n";
	$o.="<th>".$theme->nameOrder($lang->currency_cols['currency_name'],2)
	."</th><th>".$theme->nameOrder($lang->currency_cols['currency_val'],3)
	."</th><th>".$theme->nameOrder($lang->currency_cols['date_update'],4)
	."</th><th>".$lang->trash.
	"</th></tr>";
	return $o;
	
	return;
} // end currency_listh_th
?>

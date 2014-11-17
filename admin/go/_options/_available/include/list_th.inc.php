<?PHP
/**
* Nazwy elementow nad lista - lista dostepnosci
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 2.4 2005/11/25 11:50:32 lechu Exp $
* @package    options
* @subpackage available
*/

function available_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>".$theme->nameOrder($lang->id,1)."</th>";
	$o.="<th></th>";
	$o.="<th>".$theme->nameOrder($lang->available_list['name'],2)."</th>";
	$o.="<th bgcolor='#dddddd'>".$lang->available_list['num_from']."</th>";
	$o.="<th bgcolor='#dddddd'>".$lang->available_list['num_to']."</th>";
	$o.="<th>$lang->trash</th>";
	$o.="</tr>\n";
	
	return $o;
} // end available_list_th()
?>

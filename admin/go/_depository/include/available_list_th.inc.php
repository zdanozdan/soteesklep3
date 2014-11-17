<?PHP
/**
* Nazwy elementow nad lista - lista dostepnosci
*
* @author  krzys@sote.pl
* @version $Id: available_list_th.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
* @package    options
* @subpackage available
*/

function available_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>".$theme->nameOrder($lang->id,1)."</th>";
	$o.="<th>".$theme->nameOrder($lang->available_list['name'],2)."</th>";
	$o.="<th>" . $lang->available_list['from'] . "</th>";
	$o.="<th>" . $lang->available_list['to'] . "</th>";
	$o.="</tr>\n";
	
	return $o;
} // end available_list_th()
?>

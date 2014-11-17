<?PHP
/**
* Nazwy elementow nad lista - lista grup (newsletter)
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 2.4 2004/12/20 18:00:14 maroslaw Exp $
* @package    newsletter
* @subpackage groups
*/

/**
* Nag³ówek listy
*
* @return string
*/
function groups_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>$lang->id</th>";
	$o.="<th></th>";
	$o.="<th>".$lang->groups_list['name']."</th>";
	$o.="<th>".$lang->groups_list['number']."</th>";
	$o.="<th>$lang->trash</th>";
	$o.="</tr>\n";
	
	return $o;
} // end group_list_th()
?>

<?php
/**
* Nazwy elementow nad lista - lista uzytkownikow (newsletter)
*
* @author  krzys@sote.pl
* @version $Id: list_th.inc.php,v 2.5 2004/12/20 18:00:20 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

/**
* Nag³ówek listy adresów e-mail.
*
* @return string nag³ówek w formacie HTML, elelemnt tablicy
*/
function newsletter_list_th() {
	global $lang,$theme;
	
	$o="<table align=center>";
	$o.="<tr bgcolor=$theme->bg_bar_color_light>";
	$o.="<th>".$theme->nameOrder("ID",1)."</th>\n";
	$o.="<th></th>";
	$o.="<th>".$theme->nameOrder($lang->newsletter_list['email'],2)."</th>";
	$o.="<th>".$theme->nameOrder($lang->newsletter_list['register_date'],3)."</th>";
	$o.="<th>".$theme->nameOrder($lang->newsletter_list['status'],4)."</th>";
	$o.="<th>".$theme->nameOrder($lang->newsletter_list['lang'],5)."</th>";
	$o.="<th>$lang->trash</th>";
	$o.="</tr>\n";
	
	return $o;
} // end newsletter_list_th() {

?>

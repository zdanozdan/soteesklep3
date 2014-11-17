<?php
/**
* Generowanie naglowka listy rekordow list_th
*
* @author m@sote.pl
* @version $Id: list_th.inc.php,v 2.3 2004/12/20 17:57:48 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

/**
* Nag³ówek listy rekordów.
* 
* \@global array  $lang->admin_users_type_cols nazwy pol formularza
* \@global string $theme->bg_bar_color_light   kolor tla naglowka tabeli
* @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
*/
function list_th() {
    global $lang;
    global $theme;
    
    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->admin_users_type_cols['type']."</th>\n";
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->delete</th>\n";
    $o.="</tr>";
    
    return $o;
} // end list_th()
?>

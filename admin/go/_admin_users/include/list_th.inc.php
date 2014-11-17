<?php
/**
* Generowanie naglówka listy rekordow list_th.
*
* @author m@sote.pl
* @version $Id: list_th.inc.php,v 2.3 2004/12/20 17:57:52 maroslaw Exp $
* @package    admin_users
*/

/**
* Generuj nag³ówek listy rekorów na li¶cie.
*
* \@global array  $lang->admin_users_cols                      nazwy pol formularza
* \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
* \@return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
* @ignore
*/
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->admin_users_cols['login']."</th>\n";
    $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->admin_users_cols['type']."</th>\n";
    $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->admin_users_cols['active']."</th>\n";
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->delete</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

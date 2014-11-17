<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * \@template_version Id: list_th.inc.php,v 2.1 2003/03/13 11:28:56 maroslaw Exp
 * @version $Id: list_th.inc.php,v 1.2 2004/12/20 17:59:43 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
 */

/**
 * \@global array  $lang->discounts_groups_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->discounts_groups_cols_row);
    foreach ($lang->discounts_groups_cols_row as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>$col</th>\n";
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->delete</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

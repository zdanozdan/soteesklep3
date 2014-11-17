<?php
/**
 * Generowanie naglowka listy rekordow list_th
 *
 * @author  m@sote.pl
 * \@template_version Id: list_th.inc.php,v 2.3 2003/06/14 22:03:13 maroslaw Exp
 * @version $Id: list_th.inc.php,v 1.4 2004/12/20 18:00:45 maroslaw Exp $
* @package    promotions
 */

/**
 * \@global array  $lang->promotions_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->promotions_cols);$i=1;
    foreach ($lang->promotions_cols_list as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
        $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

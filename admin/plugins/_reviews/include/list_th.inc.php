<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * @version $Id: list_th.inc.php,v 1.7 2004/12/20 18:00:52 maroslaw Exp $
* @package    reviews
 */

/**
 * \@global array  $lang->reviews_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->reviews_cols);$i=1;
    foreach ($lang->reviews_cols as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
    $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

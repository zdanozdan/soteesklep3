<?php
/**
 * Generowanie naglowka listy rekordow list_th
 *
 * @author  lech@sote.pl
 * \@template_version Id: list_th.inc.php,v 2.5 2004/02/12 11:02:01 maroslaw Exp
 * @version $Id: list_th.inc.php,v 1.2 2004/12/20 17:59:51 maroslaw Exp $
* @package    help_content
 */

/**
 * \@global array  $lang->help_content_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->help_content_cols);$i=0;
    foreach ($lang->help_content_cols_list as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
        $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

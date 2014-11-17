<?php
/**
 * Generowanie naglowka listy rekordow list_th
 *
 * @author  
 * @template_version Id: list_th.inc.php,v 2.5 2004/02/12 11:02:01 maroslaw Exp
 * @version $Id: list_th.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
 * @package soteesklep
 */

/**
 * @global array  $lang->depository_cols                      nazwy pol formularza
 * @global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->depository_cols);$i=0;
    foreach ($lang->depository_cols_list as $col) {
        $j = $i;
        if($j == 0)
            $j = 1;
        if ($i != 1) {
            $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$j)."</th>\n";
        }
        else {
            $o.="<th bgcolor=$theme->bg_bar_color_light>&nbsp;</th>\n";
        }
        $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>
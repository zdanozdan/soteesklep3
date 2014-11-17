<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * \@template_version Id: list_th.inc.php,v 2.1 2003/03/13 11:28:56 maroslaw Exp
 * @version $Id: list_th.inc.php,v 1.2 2005/06/29 09:48:46 lechu Exp $
* @package    ask4price
* \@ask4price
 */

/**
 * \@global array  $lang->vat_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
global $dbedit;
 
function list_th() {

    global $lang;
    global $theme;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->ask4price_cols);$i=1;
    foreach ($lang->ask4price_cols as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
        $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

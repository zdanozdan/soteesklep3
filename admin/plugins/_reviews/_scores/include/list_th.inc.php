<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * @version $Id: list_th.inc.php,v 1.4 2006/03/06 15:17:59 lukasz Exp $
* @package    reviews
* @subpackage scores
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
    reset($lang->scores_cols);$i=1;
	foreach ($lang->scores_cols as $key=>$col) {
    	if ($key!="score_average") {
	        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
    	} else {
    		$o.="<th bgcolor=$theme->bg_bar_color_light>".$col."</th>\n";
    	}
    $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";

    return $o;
} // end list_th()
?>

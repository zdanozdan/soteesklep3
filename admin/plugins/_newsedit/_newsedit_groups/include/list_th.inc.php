<?php
/**
* Generowanie naglowka listy rekordów list_th
*
* @author  m@sote.pl
* \@template_version Id: list_th.inc.php,v 2.4 2004/02/12 10:37:03 maroslaw Exp
* @version $Id: list_th.inc.php,v 1.3 2004/12/20 18:00:07 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

/**
* Nag³owek listy newsów
*
* \@global array  $lang->newsedit_groups_cols              nazwy pol formularza
* \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
* @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
*/
function list_th() {
    global $lang;
    global $theme;
    
    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    reset($lang->newsedit_groups_cols);$i=0;
    foreach ($lang->newsedit_groups_cols_list as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$theme->nameOrder($col,$i)."</th>\n";
        $i++;
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->trash</th>\n";
    $o.="</tr>";
    
    return $o;
} // end list_th()
?>

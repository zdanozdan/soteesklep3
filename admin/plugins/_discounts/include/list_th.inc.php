<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * \@template_version Id: list_th.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: list_th.inc.php,v 2.5 2004/12/20 17:59:46 maroslaw Exp $
* @package    discounts
 */

/**
 * \@global array  $lang->discounts_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli 
 * <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 */
function list_th() {
    global $lang;
    global $theme;
    global $__row_type;
        
    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    if ($__row_type!="producer") {  
        $o.="<th bgcolor=$theme->bg_bar_color_light>";
        $o.=$lang->discounts_th['category'];
        $o.="</th>\n";    
        $o.="<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>\n"; 
    }
    if ($__row_type!="category") {
        $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->discounts_th['producer']."</th><th></th>\n";
    }
    $o.="<th bgcolor=$theme->bg_bar_color_light>".$lang->discounts_th['products']."</th>\n";
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->delete</th>\n";
    $o.="</tr>";
    
    
    return $o;
} // end list_th()
?>

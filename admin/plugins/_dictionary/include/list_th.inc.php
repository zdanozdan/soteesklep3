<?php
/**
 * PHP Template:
 * Generowanie naglowka listy rekordow list_th
 *
 * @author m@sote.pl
 * \@template_version Id: list_th.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: list_th.inc.php,v 2.5 2005/03/14 14:05:33 lechu Exp $
* @package    dictionary
 */

/**
 * \@global array  $lang->dictionary_cols                      nazwy pol formularza
 * \@global string $theme->bg_bar_color_light               kolor tla naglowka tabeli
 * @return string HTML <tr><th>nazwa</th><th>...</th></tr> naglowek tabeli listy rekordow
 * \@lang
 */
function list_th() {
    global $lang;
    global $theme;
    global $config;

    $o="<table align=center border=0>";
    $o."<tr bgcolor=$theme->bg_bar_color_light>";
    
    reset($lang->dictionary_cols);
    foreach ($lang->dictionary_cols as $col) {
        $o.="<th bgcolor=$theme->bg_bar_color_light>$col</th>\n";
    }
    
    reset($config->langs_names);
    while (list($clang,$clang_name) = each($config->langs_names)) {
        if($config->langs_active[$clang]) {
            $ls = $config->langs_symbols[$clang];
        if ($clang!=$config->lang_id)
            $o.="<th bgcolor=$theme->bg_bar_color_light>".$clang_name."</th>\n";
        }
    }
    reset($config->languages);
    /*
    foreach ($config->languages as $clang) {
        if ($clang!=$config->base_lang) $o.="<th bgcolor=$theme->bg_bar_color_light>".$config->languages_names[$clang]."</th>\n";
    }
    */
    $o.="<th bgcolor=$theme->bg_bar_color_light>$lang->delete</th>\n";
    $o.="</tr>";

    return $o;
} 
// end list_th()
?>

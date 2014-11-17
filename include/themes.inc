<?php
/**
 * Lista dostepnych tematow wygladu sklepu
* @version    $Id: themes.inc,v 2.2 2004/12/20 18:02:57 maroslaw Exp $
* @package    include
 */
class AdminThemes {
    /**
     * Wstaw linki tekstowe do tematow
     */
    function show($start="<li><u>",$end="</u><br>") {
        global $config;

        reset($config->themes);
        foreach ($config->themes as $theme_name) {
            if ($config->theme==$theme_name) {
                print "$start<a href='/go/_themes/?theme=$theme_name'><b><u>$theme_name</u></b></a>$end";                
            } else {
                print "$start<a href='/go/_themes/?theme=$theme_name'>$theme_name</a>$end";
            }
        }
    } // end show()
} // end class AdminTheme

$admin_themes = new AdminThemes;
?>

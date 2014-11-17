<?php
/**
* Nag³ówek tabeli HTML - listy klientów.
*
* @author  m@sote.pl
* @version $Id: list_points_th.inc.php,v 2.1 2005/10/20 06:31:58 krzys Exp $
* @package    users
*/

/**
* Nag³ówek listy klientów.
* @return string HTML
*/
function users_points_list_th() {
    global $lang,$theme;
    
    $o='';
    $o.="<table border=\"0\" cellspacing=\"4\" align=center>\n";
    $o.="<tr bgcolor='$theme->bg_bar_color_light'>\n";
    $o.="<th>".$lang->user_points['action']."</th>\n";
    $o.="<th>".$lang->user_points['points']."</th>\n";
    $o.="<th>".$lang->user_points['time']."</th>\n";
    $o.="<th>".$lang->user_points['description']."</th>\n";
    $o.="<th>".$lang->user_points['order']."</th>\n";
    $o.="<th>".$lang->user_points['product']."</th>\n";
    $o.="</tr>\n";
    
    return $o;
} // end users_list_th()
?>
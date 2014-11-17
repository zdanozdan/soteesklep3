<?php
/**
* Nag³ówek tabeli HTML - listy klientów.
*
* @author  m@sote.pl
* @version $Id: list_th.inc.php,v 2.2 2004/12/20 17:59:15 maroslaw Exp $
* @package    users
*/

/**
* Nag³ówek listy klientów.
* @return string HTML
*/
function users_list_th() {
    global $lang,$theme;
    
    $o='';
    $o.="<table align=center>\n";
    $o.="<tr bgcolor='$theme->bg_bar_color_light'>\n";
    $o.="<th>".$lang->users['id']."</th>\n";
    $o.="<th></th>\n";
    $o.="<th>".$lang->users['login']."</th>\n";
    $o.="<th>".$lang->users['name']."</th>\n";
    $o.="<th>".$lang->users['surname']."</th>\n";
    $o.="<th>".$lang->users['date_add']."</th>\n";
    $o.="<th>".$lang->users['email']."</th>\n";
    $o.="<th>".$lang->trash."</th>\n";
    $o.="</tr>\n";
    
    return $o;
} // end users_list_th()
?>

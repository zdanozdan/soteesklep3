<?php
/**
* Lista nag³ówkowa tabeli z newsami
*
* @author  m@sote.pl
* @version $Id: list_th.inc.php,v 2.3 2004/12/20 18:00:10 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/


/**
* Nag³owek listy newsów.
*
* @return string $o kod HTML
*/
function newsedit_list_th() {
    global $lang,$theme;
    
    $o="<table align=center>";
    $o.="<tr bgcolor=$theme->bg_bar_color_light><th>".$theme->nameOrder("ID",1)."</th>".
    "<th>"."</th>".
    "<th>".$theme->nameOrder($lang->newsedit_cols['subject'],2)."</th>".
    "<th>".$theme->nameOrder($lang->newsedit_cols['date_add'],3)."</th>".
    "<th>".$theme->nameOrder($lang->newsedit_cols['active'],4)."</th>".
    "<th>".$theme->nameOrder($lang->newsedit_cols['ordercol'],5)."</th>".
    "<th>".$theme->nameOrder($lang->newsedit_cols['id_newsedit_groups'],6)."</th>".
    "<th>".$lang->trash."</th>".
    "</tr>";
    return $o;
    
} // end delivery_list_th()

?>

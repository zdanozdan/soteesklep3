<?php
/**
* Klasa prezentacji wiersza rekordu z tabeli promotions
*
* @author  m@sote.pl
* \@template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
* @version $Id: row.inc.php,v 1.3 2004/12/20 18:00:46 maroslaw Exp $
* @package    promotions
*/

class Rec {
    var $data=array();
}

class ModTableRow {
    
    function record($result,$i) {
        global $db;
        global $theme;
        
        $rec = new Rec;
        
        //# jesli potrzebujemy odczytac date z bazy, to ponizszy kod odczytuje date timestamp z bazy i zamienia ja na format yyyy-mm-dd
        // require_once ("include/date.inc");
        // $my_date = new MyDate;
        // $rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd($db->FetchResult($result,$i,"date_update"));
        
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['active']=$theme->yesNo($db->FetchResult($result,$i,"active"));
        $rec->data['lang']=$db->FetchResult($result,$i,"lang");
        // end
        
        include ("./html/row.html.php");
        
        return;
    } // end record()
    
} // end class Row
?>

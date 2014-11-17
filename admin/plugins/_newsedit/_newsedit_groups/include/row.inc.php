<?php
/**
* Klasa prezentacji wiersza rekordu z tabeli newsedit_groups
*
* @author  m@sote.pl
* \@template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
* @version $Id: row.inc.php,v 1.4 2004/12/20 18:00:08 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

/**
* Klasa pomocnicza, pusta.
*/
class Rec {
    var $data=array();
}

class ModTableRow {
    
    /**
    * Odczytaj dane rekordu z tabeli, wy¶wietl wiersz w formacie HTML.
    *
    * @param mixed $result wynik zapytania z bazy danych
    * @param int   $i      wiersz wyniku zapytania SQL
    *
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        
        $rec = new Rec;
                
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        // end
        
        include ("./html/row.html.php");
        
        return;
    } // end record()
    
} // end class Row
?>

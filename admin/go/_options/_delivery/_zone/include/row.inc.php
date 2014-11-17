<?php
/**
 * Wyswietlenie wiersza waluty z bazy
 *
 * @author m@sote.pl
 * @version $Id: row.inc.php,v 1.1 2004/11/22 10:44:22 scalak Exp $
 * @package currency
 */

/** Pobranie z bazy danych  
*@package currency
*/
class Rec {
    var $data=array();
}
/** Wyswietlenie wiersza waluty z bazy 
*@package currency 
*/
class ModTableRow {
    function record($result,$i) {
        global $db;
        global $theme;

        require_once ("include/date.inc");
        $my_date = new MyDate;

        $rec = new Rec;
	
	// config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['country']=$db->FetchResult($result,$i,"country");

        $theme->delivery_zone_row($rec);
        // end
	
	
        return;
    } // end record()
    
} // end class Row
?>
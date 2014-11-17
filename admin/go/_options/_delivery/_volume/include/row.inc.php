<?php
/**
 * Wyswietlenie wiersza waluty z bazy
 *
 * @author m@sote.pl
 * @version $Id: row.inc.php,v 1.2 2005/02/09 13:56:01 scalak Exp $
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
        $rec->data['range_max']=$db->FetchResult($result,$i,"range_max");
        $theme->delivery_volume_row($rec);
        // end
        return;
    } // end record()
    
} // end class Row
?>
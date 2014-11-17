<?php
/**
 * Wyswietlenie wiersza waluty z bazy
 *
 * @author m@sote.pl
 * @version $Id: row.inc.php,v 2.4 2004/12/20 17:59:32 maroslaw Exp $
* @package    currency
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
        $rec->data['currency_name']=$db->FetchResult($result,$i,"currency_name");
        $rec->data['currency_val']=$db->FetchResult($result,$i,"currency_val");
        $rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd($db->FetchResult($result,$i,"date_update"));

        $theme->currency_row($rec);
        // end
	
	
        return;
    } // end record()
    
} // end class Row
?>

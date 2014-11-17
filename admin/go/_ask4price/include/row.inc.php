<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli vat
 * 
 * @author m@sote.pl lech@sote.pl
 * @version $Id: row.inc.php,v 1.1 2005/06/29 08:28:26 lechu Exp $
* @package    ask4price
* \@ask4price
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
        $rec->data['request_id']=$db->FetchResult($result,$i,"request_id");
        $rec->data['name_company']=$db->FetchResult($result,$i,"name_company");
        $rec->data['email']=$db->FetchResult($result,$i,"email");
        $rec->data['id_users']=$db->FetchResult($result,$i,"id_users");
        $rec->data['date_add']=$db->FetchResult($result,$i,"MIN(date_add)");
        $rec->data['active']=$db->FetchResult($result,$i,"active");
	// end

	include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

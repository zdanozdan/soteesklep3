<?php
/**
 * Klasa prezentacji wiersza rekordu z tabeli depository
 * 
 * @author  
 * @template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: row.inc.php,v 1.2 2005/11/25 12:20:12 lechu Exp $
 * @package soteesklep
 */

class Rec {
    var $data=array();
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme, $deliverers;

        $rec = new Rec;
        
        //# jesli potrzebujemy odczytac date z bazy, to ponizszy kod odczytuje date timestamp z bazy i zamienia ja na format yyyy-mm-dd
        // require_once ("include/date.inc");
        // $my_date = new MyDate;
        // $rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd($db->FetchResult($result,$i,"date_update"));
	
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id_main']=$db->FetchResult($result,$i,"user_id_main");
        $rec->data['num']=$db->FetchResult($result,$i,"num");
        $rec->data['min_num']=$db->FetchResult($result,$i,"min_num");
        $rec->data['diff']=$db->FetchResult($result,$i,"diff");
        $rec->data['id_deliverer']=$db->FetchResult($result,$i,"id_deliverer");
        $rec->data['deliverer'] = @$deliverers[$rec->data['id_deliverer']];
        $rec->data['id_main'] = $db->FetchResult($result,$i,"id_main");
        $rec->data['name_main'] = $db->FetchResult($result,$i,"name_main");
	// end

	include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>
<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli discounts_groups
 * 
 * @author m@sote.pl
 * \@template_version Id: row.inc.php,v 2.1 2003/03/13 11:28:53 maroslaw Exp
 * @version $Id: row.inc.php,v 1.4 2004/12/20 17:59:43 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
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
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['group_name']=$db->FetchResult($result,$i,"group_name");
        $rec->data['default_discount']=$db->FetchResult($result,$i,"default_discount");
        $rec->data['group_amount']=$db->FetchResult($result,$i,"group_amount");
        $rec->data['calculate_period']=$db->FetchResult($result,$i,"calculate_period");
        // end
        
        // start happy hour
        $rec->data['start_date']=$db->FetchResult($result,$i,"start_date");
        $rec->data['end_date']=$db->FetchResult($result,$i,"end_date");
        // end happy hour
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

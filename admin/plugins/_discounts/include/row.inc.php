<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli discounts
 * 
 * @author m@sote.pl
 * \@template_version Id: row.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: row.inc.php,v 2.4 2004/12/20 17:59:47 maroslaw Exp $
* @package    discounts
 */

class Rec {
    var $data=array();
}

require_once ("./include/discounts.inc.php");
global $discounts;
if (empty($discounts)) {
    $discounts = new Discounts;
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;
        global $discounts;

        $rec = new Rec;
        
        //# jesli potrzebujemy odczytac date z bazy, to ponizszy kod odczytuje date timestamp z bazy i zamienia ja na format yyyy-mm-dd
        // require_once ("include/date.inc");
        // $my_date = new MyDate;
        // $rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd($db->FetchResult($result,$i,"date_update"));
	
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['idc']=$db->FetchResult($result,$i,"idc");
        $rec->data['idc_name']=$db->FetchResult($result,$i,"idc_name");
        $rec->data['discount']=$discounts->get_discount($db->FetchResult($result,$i,"discount"));
        $rec->data['discount_cat']=$discounts->get_discount($db->FetchResult($result,$i,"discount_cat"));
        $rec->data['discount_producer']=$discounts->get_discount($db->FetchResult($result,$i,"discount_producer"));
        $rec->data['id_producer']=$db->FetchResult($result,$i,"id_producer");
        $rec->data['producer_name']=$db->FetchResult($result,$i,"producer_name"); 
        // end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

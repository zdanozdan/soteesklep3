<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli vat
 * 
 * @author m@sote.pl
 * \@template_version Id: row.inc.php,v 2.1 2003/03/13 11:28:53 maroslaw Exp
 * @version $Id: row.inc.php,v 1.2 2004/12/20 17:58:45 maroslaw Exp $
* @package    options
* @subpackage vat
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
        $rec->data['vat']=$db->FetchResult($result,$i,"vat");
	// end

	include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

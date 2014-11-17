<?php
/**
 * Klasa prezentacji wiersza rekordu z tabeli edit_category
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: row.inc.php,v 1.2 2004/12/20 17:58:10 maroslaw Exp $
* @package    edit_category
 */

class Rec {
    var $data=array();
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;
        global $__deep;

        $rec = new Rec;
        
        //# jesli potrzebujemy odczytac date z bazy, to ponizszy kod odczytuje date timestamp z bazy i zamienia ja na format yyyy-mm-dd
        // require_once ("include/date.inc");
        // $my_date = new MyDate;
        // $rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd($db->FetchResult($result,$i,"date_update"));
	
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data["category$__deep"]=$db->FetchResult($result,$i,"category$__deep");
        $rec->data['active']=$db->FetchResult($result,$i,"active");
        // end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

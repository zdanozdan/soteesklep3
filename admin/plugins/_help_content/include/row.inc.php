<?php
/**
 * Klasa prezentacji wiersza rekordu z tabeli help_content
 * 
 * @author  lech@sote.pl
 * \@template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: row.inc.php,v 1.3 2004/12/20 17:59:52 maroslaw Exp $
* @package    help_content
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
        $rec->data['title']=$db->FetchResult($result,$i,"title");
        $rec->data['html']=$db->FetchResult($result,$i,"html");
        $rec->data['author']=$db->FetchResult($result,$i,"author");
        $rec->data['title_en']=$db->FetchResult($result,$i,"title_en");
        $rec->data['html_en']=$db->FetchResult($result,$i,"html_en");
	// end

	include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli reviews
 * 
 * @author m@sote.pl
 * @version $Id: row.inc.php,v 1.8 2005/10/20 06:45:08 krzys Exp $
* @package    reviews
 */

class Rec {
    var $data=array();
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;
                
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['id_product']=$db->FetchResult($result,$i,"id_product");
        $rec->data['description']=$db->FetchResult($result,$i,"description");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['state']=$db->FetchResult($result,$i,"state");
        $rec->data['score']=$db->FetchResult($result,$i,"score");
        $rec->data['author']=$db->FetchResult($result,$i,"author");
        $rec->data['lang']=$db->FetchResult($result,$i,"lang");
	    $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
	    $rec->data['author_id']=$db->FetchResult($result,$i,"author_id");
	// end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

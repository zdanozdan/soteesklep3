<?php
/**
 * PHP Template:
 * Klasa prezentacji wiersza rekordu z tabeli reviews
 * 
 * @author m@sote.pl
 * @version $Id: row.inc.php,v 1.2 2004/12/20 18:00:50 maroslaw Exp $
* @package    reviews
* @subpackage scores
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
        $rec->data['score_amount']=$db->FetchResult($result,$i,"score_amount");
        $rec->data['scores_number']=$db->FetchResult($result,$i,"scores_number");
        // end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

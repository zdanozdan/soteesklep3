<?php
/**
 * Klasa prezentacji wiersza rekordu z tabeli main_keys
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: row.inc.php,v 1.3 2004/12/20 18:00:03 maroslaw Exp $
* @package    main_keys
 */

class Rec {
    var $data=array();
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;
        global $my_crypt;

        $rec = new Rec;
        
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id_main']=$db->FetchResult($result,$i,"user_id_main");
        $rec->data['main_key']=$db->FetchResult($result,$i,"main_key");
        $rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
        
        $main_key=$db->FetchResult($result,$i,"main_key");
        $rec->data['main_key']=$my_crypt->endecrypt("",$main_key,"de");
        // end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

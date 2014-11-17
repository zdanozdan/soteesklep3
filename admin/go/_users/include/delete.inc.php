<?php
/**
 * Usun produkt i kategorie, jesli wybrany produkt, jest ostatnim produktem z danej kategorii
* @version    $Id: delete.inc.php,v 2.2 2004/12/20 17:59:15 maroslaw Exp $
* @package    users
 */
class Delete {    
    /**
     * Usun rekord
     */
    function delete($id="") {
        global $lang,$db;
        
        if (empty($id)) return;
         
        $query="SELECT id FROM users WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $order_id=$db->FetchResult($result,0,"id");

                    // usun produkt
                    $query="DELETE FROM users WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            print "&nbsp; &nbsp; $id -".$lang->deleted."<br>";                    
                        } else die ($db->Error());
                    } else die ($db->Error());
                } else {
                    print $lang->delete_not_found." id=$id<BR>";
                } 
            } else die ($db->Error());
        } else die ($db->Error());
        
        return;
    }
}

$delete = new Delete;

?>

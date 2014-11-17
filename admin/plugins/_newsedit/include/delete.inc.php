<?php
/**
 * Usuñ zaznaczone newsy.
 *
 * @author  m@sote.pl
 * @version $Id: delete.inc.php,v 2.3 2004/12/20 18:00:09 maroslaw Exp $
 *
 * @verfied 2004-03-19 m@sote.pl
* @package    newsedit
 */
 
class Delete {    
    
    /**
     * Usuñ produkt
     *
     * @param int $id ID produktu
     * @return none
     */
    function delete($id="") {
        global $lang,$db;
        
        if (empty($id)) return;
        
        $query="SELECT name FROM available WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $name=$db->FetchResult($result,0,"name");

                    // usun produkt
                    $query="DELETE FROM available WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {                        
                        $db->QuerySetText($prepared_query,1,$id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            print "&nbsp; &nbsp; $name -".$lang->deleted."<br>";                    
                        } else die ($db->Error());
                    } else die ($db->Error());
                } else {
                    print $lang->delete_not_found." id=$id<BR>";
                } 
            } else die ($db->Error());
        } else die ($db->Error());
        
        return;
    } // end delete()
} // end class Delete

$delete =& new Delete;

?>

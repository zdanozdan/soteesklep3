<?php
/**
 * Usun produkt i kategorie, jesli wybrany produkt, jest ostatnim produktem z danej kategorii
 */
class Delete {    
    /**
     * Usun produkt
     */
    function delete($id="") {
        global $lang,$db;
        
        if (empty($id)) return;
        
        $query="SELECT name FROM delivery WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $name=$db->FetchResult($result,0,"name");

                    // usun produkt
                    $query="DELETE FROM delivery WHERE id=?";
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
    }
}

$delete = new Delete;

?>
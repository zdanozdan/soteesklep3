<?php
/**
* Usun produkty wg danych ze zmeinnej formularza del[ID]
*
* @author  m@sote.pl
* @version $Id: delete.inc.php,v 2.3 2004/12/20 17:58:02 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

class Delete {
    
    /**
    * Usun produkty z tabeli main
    *
    * @param int $del tablica z id usuwanych produktow
    * @return none
    */
    function main($del) {
        // lista produktow do usuniecia
        while (list($id,) = each($del)) {
            if (! empty($id)) {
                $this->delete_main($id);
            }
        } // end while
        
        return(0);
    } // end main
    
    /**
    * Usun produkt z tabneli main
    *
    * @param int $id id usuwanego produktu
    * @return none
    */
    function delete_main($id) {
        global $db;
        
        // usun produkt
        $query="DELETE FROM main WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // produkt skasowany poprawnie
            } else die ($db->Error());
        } else die ($db->Error());
        
        return (0);
    } // end delete_main()
    
} // end class Delete
?>

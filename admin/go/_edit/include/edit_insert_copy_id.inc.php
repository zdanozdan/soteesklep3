<?php
/**
 * Dodaj kopie produktu o tym samym ID
 *
 * @author  m@sote.pl
 * @version $Id: edit_insert_copy_id.inc.php,v 2.4 2004/12/20 17:58:03 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    edit
 */

class EditCopy {

    /**
     * Dodaj kopie produktu z tym samym ID
     *
     * @param  int  $id id produkty opiowanego
     *
     * @return int  nowe id produktu
     * @access public
     */
    function user_id($id) {
        global $db;

        if (! ereg("^[0-9]+$",$id)) return false;

        // skasuj dane tabeli main_tmp
        $query="DELETE FROM main_tmp";
        $result=$db->Query($query);
        if ($result!=0) {
            // OK, tabela main_tmp skasowana
        } else die ($db->Error());
        
        // skopiuj produkt z main->main_tmp
        $query="INSERT INTO main_tmp SELECT * FROM main WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // dane skopiowane
            }
        } else die ($db->Error());

        // odczytaj max (id) z tabeli main
        $query="SELECT max(id) AS max FROM main LIMIT 1";
        $result=$db->Query($query);
        if ($result!=0) {
            $max_id=$db->FetchResult($result,0,"max");
            // zwieksz id z main 
            $max_id++;
        } else die ($db->Error());

        // nadaj nowe ID produktowi w main_tmp
        $query="UPDATE main_tmp SET id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$max_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // dane poprawnie zaktualizowane
            } else die ($db->Error());
        } else die ($db->Error());

        // skopiuj produkt z main_tmp do main
        $query="INSERT INTO main SELECT * FROM main_tmp";
        $result=$db->Query($query);
        if ($result!=0) {
            // produkt poprawnie skopiowany z tym samym user_id i nowym id
        } else die ($db->Error());

        return $max_id;
    } // end user_id()
    
} // end class EditCopy
?>

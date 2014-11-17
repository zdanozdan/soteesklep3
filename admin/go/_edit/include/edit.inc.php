<?php
/**
* Klasa funkcji zwiazanych z dodawaniem i edycj± produktu.
*
* @author  m@sote.pl
* @version $Id: edit.inc.php,v 2.4 2004/12/20 17:58:02 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

class EditProduct {
    
    /**
    * Aktualizuj dane kategorii w tabelach category$i
    *
    * @param array &$item dane produktu (kategorii) $item['category1'], $item['id_category1'],->5
    *
    * @access public
    * @return none
    */
    function updateCategory(&$item) {
        global $db;
        
        for ($i=1;$i<=5;$i++) {
            $item["id_category$i"]=$this->_updateId("category$i",$item["category$i"]);
        }
        
        return (0);
    } // end update_category()
    
    /**
    * Aktualizuj dane w tablicy producenta (w tabeli producer)
    *
    * @param array &$item dane produktu  $item['producer'], $item['id_producer']
    *
    * @access public
    * @return none
    */
    function updateProducer(&$item) {
        $item["id_producer"]=$this->_updateId("producer",$item["producer"]);
        return (0);
    } // end updateProducer()
    
    /**
    * Sprawdz czy wprowadzone kategorie sa w tabelach catrtory1,category2,...,category5,producer
    * jesli tak, to odcztaj odpowiednie numery kategorii i wprowadz je do main
    * jesli nie, to dodaj te kategorie do odpowiednich tabel i numery wprowadzonych kategorii
    * wstaw do main
    *
    * @param string $column nazwa tabeli,kolumny kategorii (producenta)
    * @param string $value  wartosc pola
    *
    * @access private
    * @return int $id numer id kategorii
    */
    function _updateId($column,$value) {
        global $db;
        
        if (empty($value)) return NULL;
        
        // sprawdz czy wprowadzona nowa kategorie
        $query="SELECT $column,id FROM $column WHERE $column=?";        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$value);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $id=$db->FetchResult($result,0,"id");                    
                    return $id;
                } else {
                    // nie ma takiej kategorii, dodajemy nowa kategorie do odpowiedniej tabeli
                    $query="INSERT INTO $column ($column) VALUES (?)";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$value);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            // odczytaj numer id dodanego rekordu
                            $query="SELECT max(id) AS max FROM $column";
                            $result=$db->Query($query);
                            if ($result!=0) {
                                $id=$db->FetchResult($result,0,"max");
                                return $id;
                            } else {
                                die ($db->Error());
                            } // end $result
                        } else {
                            die ($db->Error());
                        } // end $result
                    } else {
                        die ($db->Error());
                    } // end prepared_query
                } // end $num_rows
            } else {
                die ($db->Error());
            } // end $result
        } else {
            die($db->Error());
        } // end $prepared_query
        
        return (0);
    } // end update_id()
    
        
    
} // end EditProduct

?>

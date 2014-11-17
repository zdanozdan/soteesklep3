<?php
/**
 * Dodaj nowa walute
 *
 * @author m@sote.pl
 * /@global string $table nazwa tabeli do ktorej dodajemy rekord
 * @version $Id: insert.inc.php,v 2.5 2005/04/01 08:35:33 maroslaw Exp $
 * @return int $this->id
* @package    currency
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO currency (id,currency_name,currency_val) VALUES (?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetInteger($prepared_query,1,$this->data['id']);
    $db->QuerySetText($prepared_query,2,$this->data['currency_name']);
    $db->QuerySetText($prepared_query,3,$this->data['currency_val']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());


/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszarku okreslone jako 
// config
... tu edytujemy
// end
 
*/
?>

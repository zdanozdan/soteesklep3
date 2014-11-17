<?php
/**
 * PHP Template:
 * Dodaj nowy rekord do tabeli discounts wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author m@sote.pl
 * \@global string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: insert.inc.php,v 2.2 2004/12/20 17:59:46 maroslaw Exp $
 * @return int $this->id
* @package    discounts
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO discounts (idc,idc_name) VALUES (?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['idc']);
    $db->QuerySetText($prepared_query,2,$this->data['idc_name']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->discounts_record_add;
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

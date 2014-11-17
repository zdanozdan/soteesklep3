<?php
/**
 * PHP Template:
 * Dodaj nowy rekord do tabeli vat wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author m@sote.pl
 * \@global string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.1 2003/03/13 11:28:51 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.2 2004/12/20 17:58:44 maroslaw Exp $
 * @return int $this->id
* @package    options
* @subpackage vat
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO vat (vat) VALUES (?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['vat']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->vat_record_add;
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

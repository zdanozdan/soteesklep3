<?php
/**
 * Dodaj nowa walute
 *
 * @author m@sote.pl
 * /@global string $table nazwa tabeli do ktorej dodajemy rekord
 * @version $Id: insert.inc.php,v 1.2 2005/02/24 14:00:43 scalak Exp $
 * @package currency
 * @return int $this->id
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;
global $_REQUEST;
// dodaj rekord
// config
$query="INSERT INTO delivery_zone (name,country) VALUES (?,?)";
// end

$country=serialize(@$_REQUEST['item']['country']);

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$country);
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
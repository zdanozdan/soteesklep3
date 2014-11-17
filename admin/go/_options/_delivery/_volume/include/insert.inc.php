<?php
/**
 * Dodaj nowa jednostke objetosci
 *
 * @author rdiak@sote.pl
 * @version $Id: insert.inc.php,v 1.2 2005/02/09 13:56:01 scalak Exp $
 * @package volume
 * @return int $this->id
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;
// dodaj rekord
// config
$query="INSERT INTO delivery_volume (name,range_max) VALUES (?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetInteger($prepared_query,2,$this->data['range_max']);
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
    } else {
    	die ($db->Error());
    }
} else die ($db->Error());

?>
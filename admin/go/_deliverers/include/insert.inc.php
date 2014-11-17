<?php
/**
 * Dodaj nowy rekord do tabeli deliverers wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  lech@sote.pl
 * @global  string $table nazwa tabeli do ktorej dodajemy rekord
 * @template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.1 2005/11/18 15:29:34 lechu Exp $
 * @package soteesklep
 * @return  int $this->id
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO deliverers (name,email) VALUES (?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$this->data['email']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->deliverers_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>

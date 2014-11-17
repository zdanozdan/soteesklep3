<?php
/**
 * Dodaj nowego dostawce
 * @return int $id
* @version    $Id: insert_available.inc.php,v 2.4 2005/11/25 11:50:32 lechu Exp $
* @package    options
* @subpackage available
 */

if ($global_secure_test!=true) die ("Bledne wywolanie");

// dodaj dostawce
// odczytaj numer id dodanego dostawcy
$query="INSERT INTO available (name,user_id,num_from,num_to) VALUES (?,?,?,?)";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$available['name']);
    $db->QuerySetInteger($prepared_query,2,$available['user_id']);
    $db->QuerySetText($prepared_query,3,'-1');
    $db->QuerySetText($prepared_query,4,'-1');
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM available";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>

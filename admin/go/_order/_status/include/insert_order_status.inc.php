<?php
/**
* Dodaj nowy status transakcji do bazy (INSERT).
*
* @author  m@sote.pl
* @version $Id: insert_order_status.inc.php,v 2.3 2004/12/20 17:58:51 maroslaw Exp $
* @package    order
* @subpackage status
*/

/**
* \@global int $id
*/
if ($global_secure_test!=true) die ("Bledne wywolanie");

// dodaj dostawce
// odczytaj numer id dodanego dostawcy
$query="INSERT INTO order_status (name,user_id) VALUES (?,?)";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$order_status['name']);
    $db->QuerySetInteger($prepared_query,2,$order_status['user_id']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) AS max FROM order_status LIMIT 1";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {                
                $id=$db->FetchResult($result_id,0,"max");
            } else die ("Error: add record");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());
?>

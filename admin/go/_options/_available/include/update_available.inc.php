<?php
/**
* @version    $Id: update_available.inc.php,v 2.4 2005/11/25 11:50:32 lechu Exp $
* @package    options
* @subpackage available
*/

if ($global_secure_test!=true) die ("Bledne wywolanie");

$query="UPDATE available SET name=?, user_id=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$available['name']);
    $db->QuerySetText($prepared_query,2,$available['user_id']);
    $db->QuerySetText($prepared_query,3,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>

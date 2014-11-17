<?php
/**
* Aktualizuj dane waluty/kurs
*
* @author m@sote.pl
* @version $Id: update.inc.php,v 1.2 2005/02/09 13:56:01 scalak Exp $
* @package currency
*/

global $db;
if (@$this->secure_test!=true) die ("Bledne wywolanie");


// config
$query="UPDATE delivery_volume SET name=?, range_max=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$this->data['range_max']);
    $db->QuerySetText($prepared_query,3,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {                
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>
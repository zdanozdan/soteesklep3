<?php
/**
* Aktualizuj dane waluty/kurs
*
* @author m@sote.pl
* @version $Id: update.inc.php,v 2.4 2004/12/20 17:59:33 maroslaw Exp $
* @package    currency
*/

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE currency SET currency_name=?, currency_val=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['currency_name']);
    $db->QuerySetText($prepared_query,2,$this->data['currency_val']);
    $db->QuerySetText($prepared_query,3,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {                
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

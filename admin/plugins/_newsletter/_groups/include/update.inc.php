<?php
/**
* Aktualizacja danych grupy
*
* @author  rdiak@sote.pl
* @version $Id: update.inc.php,v 2.6 2004/12/20 18:00:15 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

global $db;

if (@$this->secure_test!=true) die ("Forbidden");

// config
$query="UPDATE newsletter_groups SET user_id=?, name=? WHERE id=? ";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetInteger($prepared_query,1,$this->data['user_id']);
    $db->QuerySetText($prepared_query,2,$this->data['name']);
    $db->QuerySetInteger($prepared_query,3,$this->id);
    // end
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

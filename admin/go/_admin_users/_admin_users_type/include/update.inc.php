<?php
/**
 * Aktualizuj dane w tabeli admin_users_type
 * 
 * @author m@sote.pl
 * @version $Id: update.inc.php,v 2.3 2004/12/20 17:57:49 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
 */

global $db;
global $config;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE admin_users_type SET type=?";
foreach ($config->admin_perm as $perm) {
    $query.=",p_$perm=?";
}
$query.=" WHERE id=?";
// end


$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['type']);
    $i=2;
    foreach ($config->admin_perm as $perm) {
        $db->QuerySetText($prepared_query,$i,my(@$this->data["p_$perm"]));  
        $i++;
    }
    $db->QuerySetText($prepared_query,$i,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->admin_users_type_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>

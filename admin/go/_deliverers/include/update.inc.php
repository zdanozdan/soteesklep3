<?php
/**
 * Aktualizuj dane w tabeli deliverers
 * 
 * @author  lech@sote.pl
 * @template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.1 2005/11/18 15:29:34 lechu Exp $
 * @package soteesklep
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE deliverers SET name=?, email=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$this->data['email']);  
    $db->QuerySetText($prepared_query,3,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->deliverers_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>
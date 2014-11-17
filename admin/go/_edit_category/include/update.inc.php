<?php
/**
 * Aktualizuj dane w tabeli edit_category
 * 
 * @author  m@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.3 2005/12/29 14:12:18 lechu Exp $
* @package    edit_category
 */

global $db;
global $__deep;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE category$__deep SET category$__deep=?, ord_num=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data["category"]);
    $db->QuerySetText($prepared_query,2,$this->data["ord_num"]);
    $db->QuerySetText($prepared_query,3,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_category_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

// aktualizuj we wszystkich produktach
if ($this->data['change_all']==1) {
    $query="UPDATE main SET category$__deep=? WHERE id_category$__deep=$this->id";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$this->data["category"]);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // kategorie zostaly zaktualizowane
        } else die ($db->Error());
    } else die ($db->Error());
} // end if
?>

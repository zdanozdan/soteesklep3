<?php
/**
 * Aktualizuj dane w tabeli edit_producer
 * 
 * @author  m@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.2 2004/12/20 17:58:14 maroslaw Exp $
* @package    edit_producer
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE producer SET producer=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['producer']);
    $db->QuerySetText($prepared_query,2,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_producer_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

// aktualizuj we wszystkich produktach
if ($this->data['change_all']==1) {
    $query="UPDATE main SET producer=? WHERE id_producer=$this->id";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$this->data["producer"]);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // kategorie zostaly zaktualizowane
        } else die ($db->Error());
    } else die ($db->Error());
} // end if
?>

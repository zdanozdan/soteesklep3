<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli vat
 * 
 * @author m@sote.pl
 * \@template_version Id: update.inc.php,v 2.1 2003/03/13 11:28:55 maroslaw Exp
 * @version $Id: update.inc.php,v 1.2 2004/12/20 17:58:45 maroslaw Exp $
* @package    options
* @subpackage vat
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE vat SET vat=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['vat']);
    $db->QuerySetText($prepared_query,2,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->vat_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszarku okreslone jako 
// config
... tu edytujemy
// end
 
*/
?>

<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli scores
 * 
 * @author m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version $Id: update.inc.php,v 1.2 2004/12/20 18:00:50 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE scores SET score_amount=?, scores_number=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,@$this->data['score_amount']);
    $db->QuerySetText($prepared_query,2,@$this->data['scores_number']);
    $db->QuerySetText($prepared_query,3,@$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->scores_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>

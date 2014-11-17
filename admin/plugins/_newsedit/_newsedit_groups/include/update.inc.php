<?php
/**
* Aktualizuj dane w tabeli newsedit_groups
*
* @author  m@sote.pl
* \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
* @version $Id: update.inc.php,v 1.6 2004/12/20 18:00:08 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

global $db;

if (@$this->secure_test!=true) die ("Forbidden");

// config
$query="UPDATE newsedit_groups SET name=?,template_info=?,template_row=?,multi=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,@$this->data['template_info']);
    $db->QuerySetText($prepared_query,3,@$this->data['template_row']);
    if (empty($this->data['multi'])) $this->data['multi']=0;
    $db->QuerySetInteger($prepared_query,4,$this->data['multi']);
    $db->QuerySetText($prepared_query,5,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->newsedit_groups_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

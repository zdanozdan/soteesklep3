<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli discounts_groups
 * 
 * @author m@sote.pl
 * \@template_version Id: update.inc.php,v 2.1 2003/03/13 11:28:55 maroslaw Exp
 * @version $Id: update.inc.php,v 1.6 2005/03/29 15:21:14 lechu Exp $
* @package    discounts
* @subpackage discounts_groups
 */

global $db, $mdbd;

if (@$this->secure_test!=true) die ("Bledne wywolanie");
if (ereg("Happy hour",$this->data['group_name'])) {
    $res = $mdbd->select("user_id", "discounts_groups", "group_name='Happy hour' AND user_id <> ?", array($this->data['user_id'] => 'int'), '', 'array');
    if($mdbd->num_rows > 0) {
        die($lang->discounts_groups_happyhour_override_error);
    }
}

// config
$query="UPDATE discounts_groups SET user_id=?, group_name=?, default_discount=?, public=?, photo=?, group_amount=?, calculate_period=?, start_date=?, end_date=? WHERE id=?";
// end

if(empty($this->data['photo'])) {
    global $database;
    require_once ("include/metabase.inc");
    $this->data['photo']=$database->sql_select("photo","discounts_groups","id=$this->id");
}

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['user_id']);
    $db->QuerySetText($prepared_query,2,$this->data['group_name']);  
    $db->QuerySetText($prepared_query,3,$this->data['default_discount']); 
    $db->QuerySetText($prepared_query,4,@$this->data['public']); 
    $db->QuerySetText($prepared_query,5,$this->data['photo']);
    $db->QuerySetText($prepared_query,6,@$this->data['group_amount']);
    $db->QuerySetText($prepared_query,7,@$this->data['calculate_period']);
    
    // start happy hour
    $db->QuerySetText($prepared_query,8,@$this->data['start_date']);
    $db->QuerySetText($prepared_query,9,@$this->data['end_date']);
    // stop happy hour
    
    $db->QuerySetText($prepared_query,10,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->discounts_groups_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

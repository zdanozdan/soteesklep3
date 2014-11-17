<?php
/**
* Aktualizuj dane adresu e-mail
*
* @author  rdiak@sote.pl
* @version $Id: update.inc.php,v 2.6 2004/12/20 18:00:21 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

global $db;

if (@$this->secure_test!=true) die ("Forbidden");

$email_md5=md5($this->data['email'].$config->salt);
// config
$query="UPDATE newsletter SET email=?, date_remove=CURRENT_DATE, active=?, status=?, md5=?, groups=?, lang=? WHERE id=? ";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['email']);
    $db->QuerySetInteger($prepared_query,2,$this->data['active']);
    $db->QuerySetInteger($prepared_query,3,$this->data['status']);
    $db->QuerySetText($prepared_query,4,$email_md5);
    $db->QuerySetText($prepared_query,5,@$this->data['groups']);
    $db->QuerySetText($prepared_query,6,@$this->data['lang']);
    $db->QuerySetInteger($prepared_query,7,$this->id);
    // end
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

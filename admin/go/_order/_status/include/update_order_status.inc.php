<?php
/**
* Aktualizu dane statusu w bazie (UPDATE).
*
* @author  m@sote.pl
* @version $Id: update_order_status.inc.php,v 2.4 2004/12/20 17:58:52 maroslaw Exp $
* @package    order
* @subpackage status
*/

if ($global_secure_test!=true) die ("Forbidden");

$query="UPDATE order_status SET name=?, user_id=?, send_mail=?, mail_title=?, mail_content=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$order_status['name']);
    $db->QuerySetText($prepared_query,2,$order_status['user_id']);
    $db->QuerySetText($prepared_query,3,@$order_status['send_mail']);
    $db->QuerySetText($prepared_query,4,$order_status['mail_title']);
    $db->QuerySetText($prepared_query,5,$order_status['mail_content']);
    $db->QuerySetText($prepared_query,6,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>

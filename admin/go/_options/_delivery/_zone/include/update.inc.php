<?php
/**
* Aktualizuj dane waluty/kurs
*
* @author m@sote.pl
* @version $Id: update.inc.php,v 1.2 2005/02/24 12:31:57 scalak Exp $
* @package currency
*/

global $db;
global $_REQUEST;
if (@$this->secure_test!=true) die ("Bledne wywolanie");

if(!empty($_REQUEST['item']['country'])) {
	$country=serialize($_REQUEST['item']['country']);
} else {
	$country='';
}
// config
$query="UPDATE delivery_zone SET name=?, country=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$country);
    $db->QuerySetText($prepared_query,3,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {                
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>
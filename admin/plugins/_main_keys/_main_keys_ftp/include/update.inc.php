<?php
/**
 * Aktualizuj dane w tabeli main_keys_ftp
 * 
 * @author  m@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.3 2004/12/20 17:59:57 maroslaw Exp $
* @package    main_keys
* @subpackage main_keys_ftp
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE main_keys_ftp SET ftp=?, active=?, user_id_main=?, demo=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,@$this->data['ftp']);
    $db->QuerySetText($prepared_query,2,@$this->data['active']);  
    $db->QuerySetText($prepared_query,3,@$this->data['user_id_main']);  
    $db->QuerySetText($prepared_query,4,@$this->data['demo']);  
    $db->QuerySetText($prepared_query,5,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->main_keys_ftp_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

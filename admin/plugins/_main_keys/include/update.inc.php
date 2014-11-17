<?php
/**
 * Aktualizuj dane w tabeli main_keys
 * 
 * @author  m@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.4 2004/12/20 18:00:03 maroslaw Exp $
* @package    main_keys
 */

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE main_keys SET user_id_main=?, order_id=?, main_key=?, url=?, main_key_md5=? WHERE id=?";
// end

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// generuj link do pliku/opcjonalnie, ustaw $this->data['url']
require_once ("./include/url.inc.php");

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $crypt_main_key=$my_crypt->endecrypt("",$this->data['main_key']);           // koduj kod do produktu

    $db->QuerySetText($prepared_query,1,$this->data['user_id_main']);
    $db->QuerySetText($prepared_query,2,$this->data['order_id']);  
    $db->QuerySetText($prepared_query,3,$crypt_main_key);
    $db->QuerySetText($prepared_query,4,@$this->data['url']);  
    $db->QuerySetText($prepared_query,5,@$this->data['main_key_md5']);  
    
    $db->QuerySetText($prepared_query,6,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->main_keys_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>

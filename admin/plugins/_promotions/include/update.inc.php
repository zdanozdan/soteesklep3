<?php
/**
 * Aktualizuj dane w tabeli promotions
 * 
 * @author  m@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.4 2004/12/20 18:00:47 maroslaw Exp $
* @package    promotions
 */

global $db;

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

// config
$query="UPDATE promotions SET name=?, active=?, discount=?,
                              code1=?, code2=?, code3=?, code4=?, code5=?,
                              code6=?, code7=?, code8=?, code9=?, code10=?,
                              amount=?, short_description=?, description=?, photo=?,
                              active_code=?,lang=?
        WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,@$this->data['name']);
    $db->QuerySetText($prepared_query,2,@$this->data['active']);  
    $db->QuerySetText($prepared_query,3,@$this->data['discount']);  
    for ($i=4;$i<14;$i++) {
        $db->QuerySetText($prepared_query,$i,$my_crypt->endecrypt("",@$this->data['code'.($i-3)]));
    }
    $db->QuerySetText($prepared_query,14,@$this->data['amount']);  
    $db->QuerySetText($prepared_query,15,@$this->data['short_description']);  
    $db->QuerySetText($prepared_query,16,@$this->data['description']);  
    $db->QuerySetText($prepared_query,17,@$this->data['photo']);  
    $db->QuerySetText($prepared_query,18,@$this->data['active_code']);  
    $db->QuerySetText($prepared_query,19,@$this->data['lang']);  
    $db->QuerySetText($prepared_query,20,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->promotions_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());
?>

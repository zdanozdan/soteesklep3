<?php
/**
 * Aktualizuj dane w tabeli depository
 * 
 * @author  
 * @template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
 * @package soteesklep
 */

global $db, $mdbd;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

$res = $mdbd->select("user_id_main", "depository", "user_id_main = ? AND id <> ?", array('1,' . $this->data['user_id_main'] => "text", '2,' . $this->id => "int"));
if ($mdbd->num_rows > 0) {
    die($lang->error_message['duplicate_depository']);
}

$res = $mdbd->select("id", "main", "user_id = ?", array($this->data['user_id_main'] => 'text'));
if ($mdbd->num_rows == 0) {
    die($lang->error_message['invalid_product_id']);
}

// config
$query="UPDATE depository SET user_id_main=?, num=?, min_num=?, id_deliverer=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['user_id_main']);
    $db->QuerySetText($prepared_query,2,$this->data['num']);  
    $db->QuerySetText($prepared_query,3,$this->data['min_num']);  
    $db->QuerySetText($prepared_query,4,$this->data['id_deliverer']);  
    $db->QuerySetText($prepared_query,5,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->depository_edit_update_ok;
        
        $num = $this->data['num'];
        if($num < 0)
            $num = 0;
        $user_id_main = $this->data['user_id_main'];
        global $config;
        $res2 = $mdbd->select("user_id,num_from,num_to","available", "1=1", array(), '', 'array');
        if(!empty($res2)) {
            if($num >= 0) {
                $av_id = 0;
                reset($res2);
                while (($av_id == 0) && (list($key, $val) = each($res2))) {
                    $a = $val['user_id'];
                    $from = $val['num_from'];
                    $to = $val['num_to'];
                    if($to != '*') {
                        if (($from <= $num) && ($num <= $to)) {
                            $av_id = $a;
                        }
                    }
                    else {
                        $last_id = $a;
                    }
                }
                if($av_id == 0) {
                    $av_id = $last_id;
                }
                $mdbd->update("main","id_available=$av_id", "user_id=?", array($user_id_main => "text"));
            }
        }

    } else die ($db->Error());
} else die ($db->Error());
?>
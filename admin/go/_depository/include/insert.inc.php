<?php
/**
 * Dodaj nowy rekord do tabeli depository wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  
 * @global  string $table nazwa tabeli do ktorej dodajemy rekord
 * @template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.2 2005/11/25 12:20:12 lechu Exp $
 * @package soteesklep
 * @return  int $this->id
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db, $mdbd;

$res = $mdbd->select("user_id_main", "depository", "user_id_main = ?", array($this->data['user_id_main'] => "text"));
if ($mdbd->num_rows > 0) {
    die($lang->error_message['duplicate_depository']);
}

$res = $mdbd->select("id", "main", "user_id = ?", array($this->data['user_id_main'] => 'text'));
if ($mdbd->num_rows == 0) {
    die($lang->error_message['invalid_product_id']);
}

// dodaj rekord
// config
$query="INSERT INTO depository (user_id_main, num, min_num, id_deliverer) VALUES (?,?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['user_id_main']);
    $db->QuerySetText($prepared_query,2,$this->data['num']);
    $db->QuerySetText($prepared_query,3,$this->data['min_num']);
    $db->QuerySetText($prepared_query,4,@$this->data['id_deliverer']);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM depository";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->depository_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            }
            else
                die ("Bledne dodanie rekordu");
        }
        else {
            die ($db->Error());
        }
        /**/
        $num = $this->data['num'];
        if($num < 0)
            $num = 0;
        $user_id_main = $this->data['user_id_main'];
        
        $res2 = $mdbd->select("user_id,num_from,num_to", "available", "1=1", array(), '', 'array');
        if(!empty($res2)) {
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
        /**/
    } else
        die ($db->Error());
    
    
} else die ($db->Error());
?>

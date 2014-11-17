<?php

/**
 * Enter description here...
 *
 */
class Depository {

    /**
     * Enter description here...
     *
     * @return Depository
     */
    function compute($depository_num,$user_id,$deliverer_id) {
        global $mdbd;
        global $config;

        if(is_numeric($depository_num)) {
            $res_depository = $mdbd->select("id", "depository", "user_id_main=?", array($user_id => 'text'), '', 'array');
            $min_num = $config->depository['general_min_num'];
            $num = (int)$depository_num;
            
            if($num < 0) $num = 0;
            
            $user_id_main = addslashes($user_id);
            $id_deliverer = addslashes($deliverer_id);
            if($mdbd->num_rows == 0) {
                $mdbd->insert("depository", "user_id_main, num, min_num, id_deliverer", "'$user_id_main', $num, $min_num, $id_deliverer");
            }
            else {
                $mdbd->update("depository", "num=$num, id_deliverer=$id_deliverer", "user_id_main=?", array($user_id_main => 'text'));
            }
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
                $item['id_available'] = $av_id;
            }
        }
        // end magazyn
        return  $av_id;
    } // end func Depository
} // end class Depository

?>

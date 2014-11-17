<?php

global $intervals;
global $mdbd;
$res = $mdbd->select("user_id_main,num", "depository", "1=1", array(), '', 'array');
if(!empty($res)) {
    for ($i = 0; $i < count($res); $i++) {
        $user_id_main = $res[$i]["user_id_main"];
        $num = $res[$i]["num"];
        if ($num < 0)
            $num = 0;
        $av_id = 0;
        reset($intervals);
        while (($av_id == 0) && (list($a, $val) = each($intervals))) {
            $from = $val['from'];
            $to = $val['to'];
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

?>
<?php
$intervals = $_REQUEST['form'];


// 1. Sprawdzenie poprawno�ci przedzia��w
reset($intervals);
$intervals_by_from = array();
$error_message = '';
while (list($key, $val) = each($intervals)) {
    if(!isset($intervals_by_from[$val['from']])) {
        $intervals_by_from[$val['from']] = $val['to'];
    }
    else {
        $error_message = $lang->error_message["duplicated_from_value"]; // 2 przedzia�y zaczynaj� si� od tej samej liczby
    }
}

if (empty($error_message)) {
    
    reset($intervals_by_from);
    ksort($intervals_by_from);
    if(!isset($intervals_by_from['0'])) {
        $error_message = $lang->error_message["no_from_zero_entry"]; // brak pierwszego przedzia�u (od zera)
    }
    
    if (empty($error_message)) {
        $prev_to = 'x';
        $inf_boundary = 0;
        while ((list($from, $to) = each($intervals_by_from)) && empty($error_message)) {
            if ((is_numeric($from)) && ((is_numeric($to) || ($to == '*'))) && (strpos($from, '.') === false) && (strpos($to, '.') === false)) {
                if($prev_to != 'x') {
                    $pto = $prev_to + 1;
                    if($from != $pto) {
                        $error_message = $lang->error_message["invalid_interval_boundaries"] . ": " . $prev_to . " &lt;-&gt; " . $from; // s�siaduj�ce przedzia�y nak�adaj� si� lub jest mi�dzy nimi wolne miejsce
                    }
                }
                if(empty($error_message)) {
                    if($to != '*') {
                        if($to < $from) {
                            $error_message = $lang->error_message["interval_from_gt_interval_to"]; // pocz�tek danego przedzia�u jest wi�kszy ni� jego koniec
                        }
                    }
                    else {
                        if ($inf_boundary == 1) {
                            $error_message = $lang->error_message["duplicated_inf_boundary"]; // dwukrotne wyst�pienie gwiazdki
                        }
                        $inf_boundary = 1;
                    }
                    $prev_to = $to;
                }
            }
            else {
                $error_message = $lang->error_message["invalid_data_format"]; // niepoprawny format danych wej�ciowych
            }
        }
        if (empty($error_message)) {
            if($inf_boundary == 0) {
                $error_message = $lang->error_message["no_to_inf_entry"]; // brak przedzia�u z gwiazdk�
            }
        }
    }
}

if (empty($error_message)) { // weryfikacja nie wykaza�a b��d�w 
    global $config;
    reset($intervals); // aktualizacja configa
    while (list($key, $val) = each($intervals)) {
        $config->depository_interval["$key"] = $val['from'] . ';' . $val['to'];
    }
    
    require_once("include/gen_user_config.inc.php");
    $ftp->connect();
    $depository_intervals = $config->depository_interval;
    $gen_config->gen(
        array
        (
        "depository_interval"=>$depository_intervals,
        )
    );
    $ftp->close();
    
    
    // aktualizacja dost�pno�ci produkt�w
    
    global $mdbd;
    $res = $mdbd->select("user_id_main,num", "depository", "1=1", array(), '', 'array');
    if(!empty($res)) {
        for ($i = 0; $i < count($res); $i++) {
            $user_id_main = $res[$i]["user_id_main"];
            $num = $res[$i]["num"];
            if($num >= 0) {
                $av_id = 0;
                reset($config->depository_interval);
                while (($av_id == 0) && (list($a, $val) = each($config->depository_interval))) {
                    $intv = explode(';', $val);
                    $from = $intv[0];
                    $to = $intv[1];
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
    }
}

?>
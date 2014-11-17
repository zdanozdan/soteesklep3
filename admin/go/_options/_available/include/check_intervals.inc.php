<?php

// Sprawdzenie poprawno¶ci przedzia³ów
global $intervals_by_from, $error_intervals_message, $lang;

if (empty($error_intervals_message)) {
    
    reset($intervals_by_from);
    ksort($intervals_by_from);
    if(!isset($intervals_by_from['0'])) {
        $error_intervals_message = $lang->error_message["no_from_zero_entry"]; // brak pierwszego przedzia³u (od zera)
    }
    
    if (empty($error_intervals_message)) {
        $prev_to = 'x';
        $inf_boundary = 0;
        while ((list($from, $to) = each($intervals_by_from)) && empty($error_intervals_message)) {
            if ((is_numeric($from)) && ($from >= 0)  && ((is_numeric($to) || ($to == '*'))) && (strpos($from, '.') === false) && (strpos($to, '.') === false)) {
                if($prev_to != 'x') {
                    $pto = $prev_to + 1;
                    if($from != $pto) {
                        $error_intervals_message = $lang->error_message["invalid_interval_boundaries"] . ": " . $prev_to . " &lt;-&gt; " . $from; // s±siaduj±ce przedzia³y nak³adaj± siê lub jest miêdzy nimi wolne miejsce
                    }
                }
                if(empty($error_intervals_message)) {
                    if($to != '*') {
                        if($to < $from) {
                            $error_intervals_message = $lang->error_message["interval_from_gt_interval_to"]; // pocz±tek danego przedzia³u jest wiêkszy ni¿ jego koniec
                        }
                    }
                    else {
                        if ($inf_boundary == 1) {
                            $error_intervals_message = $lang->error_message["duplicated_inf_boundary"]; // dwukrotne wyst±pienie gwiazdki
                        }
                        $inf_boundary = 1;
                    }
                    $prev_to = $to;
                }
            }
            else {
                $error_intervals_message = $lang->error_message["invalid_data_format"]; // niepoprawny format danych wej¶ciowych
            }
        }
        if (empty($error_intervals_message)) {
            if($inf_boundary == 0) {
                $error_intervals_message = $lang->error_message["no_to_inf_entry"]; // brak przedzia³u z gwiazdk±
            }
        }
    }
}


?>
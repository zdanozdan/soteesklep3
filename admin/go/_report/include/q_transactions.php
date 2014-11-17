<?php
/**
* Pozyskanie danych do wykresu
*
* Skrypt pobiera dane z bazy na podstawie przes³anych warto¶ci z formularza
* oraz generuje tytu³ wykresu
* @author  lech@sote.pl
* @version $Id: q_transactions.php,v 1.9 2005/12/06 14:09:26 lechu Exp $
* @package    report
*/

global $config,$lang;
$date_data = @$this->form_data["date_data"];
$producer_data = @$this->form_data["producer_data"];
$category_data = @$this->form_data["category_data"];
$amount_data = @$this->form_data["amount_data"];
$transaction_form = @$this->form_data["transaction_form"];
$series = array();

// zbieranie danych do zapytania i do tytu³u wykresu
if($transaction_form['division'] == 'd_1'){
    $division = $lang->report_months;
    $title_from = $lang->report_from." <b>" . $date_data[0]['m'] . "." . $date_data[0]['y'] . "</b><br>";
    $title_to   = $lang->report_to." <b>" . $date_data[1]['m'] . "." . $date_data[1]['y'] . "</b>";
    

    $date_start = mktime(0, 0, 0, $date_data[0]['m'], 1, $date_data[0]['y']);
    $date_stop  = mktime(0, 0, 0, $date_data[1]['m'], 1, $date_data[1]['y']);
    $date_it = $date_start;
    $offset = 1;
    while($date_it <= $date_stop){
        $series[date('Y-m', $date_it)] = 0;
        $date_it = mktime(0, 0, 0, $date_data[0]['m'] + $offset, 1, $date_data[0]['y']);
        $offset++;
    }

    $q_select = "CONCAT(YEAR( date_add ),'-' , MONTH( date_add )) as 'bar_name'";
    $q_date_from = "AND date_add >= '" . $date_data[0]['y'] . "-" . $date_data[0]['m'] . "-01'";
    $q_date_to   = "AND date_add < DATE_ADD('" . $date_data[1]['y'] . "-" . $date_data[1]['m'] . "-01', INTERVAL 1 MONTH)";
    $q_group_by = "YEAR( date_add ) , MONTH( date_add )";
    $q_order_by = "YEAR( date_add ) , MONTH( date_add )";
}
if($transaction_form['division'] == 'd_2'){
    $division = $lang->report_days;
    $title_from = $lang->report_from." <b>" . $date_data[2]['d'] . "." . $date_data[2]['m'] . "." . $date_data[2]['y'] . "</b><br>";
    $title_to   = $lang->report_to." <b>" . $date_data[3]['d'] . "." . $date_data[3]['m'] . "." . $date_data[3]['y'] . "</b>";

    $date_start = mktime(0, 0, 0, $date_data[2]['m'], $date_data[2]['d'], $date_data[2]['y']);
    $date_stop  = mktime(0, 0, 0, $date_data[3]['m'], $date_data[3]['d'], $date_data[3]['y']);
//    print_r($date_data);
    $date_it = $date_start;
    $offset = 1;
    $series = array();
    while($date_it <= $date_stop){
        $series[date('Y-m-d', $date_it)] = 0;
        $date_it = mktime(0, 0, 0, $date_data[2]['m'], $date_data[2]['d'] + $offset, $date_data[2]['y']);
        $offset++;
    }

    $q_select = "CONCAT(YEAR( date_add ), '-', MONTH( date_add ), '-', DAYOFMONTH( date_add )) as 'bar_name' ";
    $q_date_from = "AND date_add >= '" . $date_data[2]['y'] . "-" . $date_data[2]['m'] . "-" . $date_data[2]['d'] . "'";
    $q_date_to   = "AND date_add < DATE_ADD('" . $date_data[3]['y'] . "-" . $date_data[3]['m'] . "-" . $date_data[3]['d'] . "', INTERVAL 1 DAY)";
    $q_group_by = "YEAR( date_add ) , MONTH( date_add ), DAYOFMONTH( date_add )";
    $q_order_by = "YEAR( date_add ) , MONTH( date_add )";
}
if($transaction_form['division'] == 'd_3'){
    $division = $lang->report_days;
    $title_from = $lang->report_day." <b>" . $date_data[4]['d'] . "." . $date_data[4]['m'] . "." . $date_data[0]['y'] . "</b><br>";
    $title_to   = "";

    $offset = 0;
    while($offset < 24){
        $series[sprintf("%02d", $offset) . ':00'] = 0;
        $offset++;
    }
    $q_select = "CONCAT(HOUR( time_add ), ':00') as 'bar_name'";
    $q_date_from = "AND date_add = '" . $date_data[4]['y'] . "-" . $date_data[4]['m'] . "-" . $date_data[4]['d'] . "'";
    $q_date_to = '';
    $q_group_by = "YEAR( date_add ) , MONTH( date_add ), DAYOFMONTH( date_add ), HOUR( time_add )";
    $q_order_by = "HOUR( time_add )";
}

if($transaction_form['values'] == '1'){
    $val_type = $lang->report_number;
    $q_agregate = "COUNT( * )";
}
$currency = '';
if($transaction_form['values'] == '2'){
    $val_type = $lang->report_values_sum;
    $q_agregate = "SUM( total_amount )";
    $currency = ' [' . $config->currency . ']';
}




//  zapytanie
$query = "
SELECT $q_select , $q_agregate AS 'ile'
FROM order_register WHERE ((confirm=1 OR confirm_online=1) AND cancel=0)
$q_date_from
$q_date_to
GROUP BY $q_group_by
ORDER BY $q_order_by
";


//  tytu³ wykresu
$title = "
        <table width=100% cellpadding=2>
            <tr>
                <td style='font-family: verdana; font-size: 12px; font-weight: bold' valign=top>
                     &nbsp;".$lang->report_list." ".$val_type." ".$lang->report_division." ".$division." ".$currency."
                </td>
                <td nowrap rowspan=2 align=right valign=top>
                    $lang->report_period: $title_from
                           $title_to
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
";


// pobranie danych na podstawie zapytania
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    // wykonanie zapytania
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // ilo¶æ odpowiedzi
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // jest conajmniej 1 wynik
            for ($i=0;$i<$num_rows;$i++) {
                $date_row = $db->FetchResult($result,$i,"bar_name");

                $date_row_arr = explode('-', $date_row);
                if(count($date_row_arr) > 1){
                    for ($n = 0; $n < count($date_row_arr); $n++){
                        if (strlen($date_row_arr[$n]) == 1)
                            $date_row_arr[$n] = '0' . $date_row_arr[$n];
                    }
                    $date_row = implode('-', $date_row_arr);
                    $series[$date_row]= round($db->FetchResult($result,$i,"ile"), 2);
                }
                $date_row_arr = explode(':', $date_row);
                if(count($date_row_arr) > 1){
                    for ($n = 0; $n < count($date_row_arr); $n++){
                        if (strlen($date_row_arr[$n]) == 1)
                            $date_row_arr[$n] = '0' . $date_row_arr[$n];
                    }
                    $date_row = implode(':', $date_row_arr);
    //                echo "[$date_row]";
                    $series[$date_row]= round($db->FetchResult($result,$i,"ile"), 2);
                }
            }
        } else {
            // nie ma wyników
        }
    } else die ($db->Error());
} else die ($db->Error());

$data['title'] = $title;
$data['series'] = $series;
//print_r($series);
?>

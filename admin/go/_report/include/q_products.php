<?php
/**
* Pozyskanie danych do wykresu
*
* Skrypt pobiera dane z bazy na podstawie przes³anych warto¶ci z formularza
* oraz generuje tytu³ wykresu
* @author  lech@sote.pl
* @version $Id: q_products.php,v 1.6 2005/12/06 14:25:12 lechu Exp $
* @package    report
*/
global $lang;
 $date_data = @$this->form_data["date_data"];
 $producer_data = @$this->form_data["producer_data"];
 $category_data = @$this->form_data["category_data"];
 $amount_data = @$this->form_data["amount_data"];

if($date_data[0]['m'] == '')
    $date_data[0]['m'] = sprintf("%02d", date('m') - 1);
    
if(($producer_data['id'] != '') && ($producer_data['id'] != 0)){
    $ar_p = explode('|', $producer_data['id']);
    $producer_title = "Producent: <b>" . $ar_p[1] . "</b>";
}

if(($category_data['id'] != '') && ($category_data['id'] != 0)){
    $ar_c = explode('|', $category_data['id']);
    $category_title = "Kategoria: <b>" . $ar_c[1] . "</b>";
}

// wygenerowanie tytu³u do wykresu
$title = "
        <table width=100% cellpadding=2>
            <tr>
                <td style='font-family: verdana; font-size: 12px; font-weight: bold' valign=top>
                    &nbsp;".$lang->report_list." ".$amount_data['amount']." ". $lang->report_best."
                </td>
                <td nowrap rowspan=2 align=right valign=top>".
                     $lang->report_period.": ".$lang->report_from ." <b>" . $date_data[0]['d'] . "." . $date_data[0]['m'] . "." . $date_data[0]['y'] . "</b><br>
                           ".$lang->report_to ." <b>" . $date_data[1]['d'] . "." . $date_data[1]['m'] . "." . $date_data[1]['y'] . "</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;" . @$producer_title . "&nbsp;&nbsp;" . @$category_title . "</td>
            </tr>
            <tr>
                <td colspan=2>&nbsp;</td>
            </tr>
        </table>
";

// wygenerowanie zapytania
$q_date_from = "AND op.date_add >= '" . $date_data[0]['y'] . "-" . $date_data[0]['m'] . "-" . $date_data[0]['d'] . "'";
$q_date_to   = "AND op.date_add <= '" . $date_data[1]['y'] . "-" . $date_data[1]['m'] . "-" . $date_data[1]['d'] . "'";
$q_producer = '';
if($producer_data['id'] != 0){
    $ar_producer_id = explode('|', $producer_data['id']);
    $producer_id = $ar_producer_id[0];
    $q_producer = "AND op.id_producer = $producer_id";
}

$q_category = '';
if($category_data['id'] != 0){
    $ar_category_ids = explode('|', $category_data['id']);
    $ar_category_ids2 = explode('_', $ar_category_ids[0]);
    $id_category1 = $ar_category_ids2[0];
    $id_category2 = $ar_category_ids2[1];
    $q_category = "AND op.id_category1 = $id_category1 AND op.id_category2 = $id_category2";
}

$query = "SELECT op.name AS 'name', op.user_id_main AS 'user_id_main', SUM(op.num) AS 'ile' FROM order_products op, order_register og
    WHERE user_id_main IS NOT NULL
    AND og.order_id=op.order_id AND og.cancel=0 AND (og.confirm=1 OR og.confirm_online=1)
    AND user_id_main <> ''
    $q_date_from
    $q_date_to
    $q_producer
    $q_category
    GROUP BY user_id_main
    ORDER BY ile DESC LIMIT 0, " . $amount_data['amount'];

// pobranie danych na podstawie zapytania
$series = array();
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
                $prod_name = $db->FetchResult($result,$i,"name");
                $prod_id = $db->FetchResult($result,$i,"user_id_main");
                $series[$prod_name . "($prod_id)"]=$db->FetchResult($result,$i,"ile");
            }
        } else {
            // nie ma wyników
        }
    } else die ($db->Error());
} else die ($db->Error());

$data['title'] = $title;
$data['series'] = $series;

?>

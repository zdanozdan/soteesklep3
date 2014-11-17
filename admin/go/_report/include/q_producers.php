<?php
/**
* Pozyskanie danych do wykresu
*
* Skrypt pobiera dane z bazy na podstawie przes³anych warto¶ci z formularza
* oraz generuje tytu³ wykresu
* @author  lech@sote.pl
* @version $Id: q_producers.php,v 1.7 2005/12/06 14:25:12 lechu Exp $
* @package    report
*/
global $lang;
$date_data = @$this->form_data["date_data"];
$producer_data = @$this->form_data["producer_data"];
$category_data = @$this->form_data["category_data"];
$amount_data = @$this->form_data["amount_data"];

// wygenerowanie tytu³u do wykresu
$title = "
        <table width=100% cellpadding=2>
            <tr>
                <td style='font-family: verdana; font-size: 12px; font-weight: bold' valign=top>
                    &nbsp;".$lang->report_list." ". $amount_data['amount']." ". $lang->report_best_producers."
                </td>
                <td nowrap rowspan=2 align=right valign=top>".
                   $lang->report_period.": ".$lang->report_from ." <b>" .  $date_data[0]['d'] . "." . $date_data[0]['m'] . "." . $date_data[0]['y'] . "</b><br>
                           ".$lang->report_to ." <b>" .  $date_data[1]['d'] . "." . $date_data[1]['m'] . "." . $date_data[1]['y'] . "</b>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
";

// wygenerowanie zapytania
$q_date_from = "AND op.date_add >= '" . $date_data[0]['y'] . "-" . $date_data[0]['m'] . "-" . $date_data[0]['d'] . "'";
$q_date_to   = "AND op.date_add <= '" . $date_data[1]['y'] . "-" . $date_data[1]['m'] . "-" . $date_data[1]['d'] . "'";

$query = "SELECT op.producer AS 'producer', SUM(op.num) AS 'ile' FROM order_products op, order_register og
    WHERE op.user_id_main IS NOT NULL
    AND og.order_id=op.order_id AND og.cancel=0 AND (og.confirm=1 OR og.confirm_online=1)
    AND op.user_id_main <> ''
    $q_date_from
    $q_date_to
    GROUP BY op.id_producer
    ORDER BY ile DESC LIMIT 0, 100";

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
                $producer = $db->FetchResult($result,$i,"producer");
                $series[$producer]=$db->FetchResult($result,$i,"ile");
            }
        } else {
            // nie ma wyników
        }
    } else die ($db->Error());
} else die ($db->Error());

$data['title'] = $title;
$data['series'] = $series;

?>

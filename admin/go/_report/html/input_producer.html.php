<?php
/**
* Element formularza - lista rozwijana producentów do wyboru
*
* Lista producentów wygenerowana jest na podstawie zapytania do tabeli producer.
* Kolejne pola option maj± warto¶ci w postaci: IdProducenta|NazwaProducenta - zgodnie
* z warto¶ciami id i producer ka¿dego rekordu tabeli
*
* @author  lech@sote.pl
* @version $Id: input_producer.html.php,v 1.4 2004/12/20 17:59:02 maroslaw Exp $
* @package    report
*/

if(@$producer_data['id'] == '')
    $producer_data['id'] = 0;

$selected = array();
$selected[$producer_data['id']] = 'selected';

?>
<select name=producer_data[id] class="date" style='width: 151px;'>
    <option value=0 <?php echo @$selected[0]; ?>> - <?php print $lang->report_all;?> - </option>
<?php
$producer_data['id'] = addslashes($producer_data['id']);
$producers_query = "select id, producer from producer order by producer";
$prepared_query=$db->PrepareQuery($producers_query);
if ($prepared_query) {
    // wykonanie zapytania
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // ilo¶æ odpowiedzi
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // jest conajmniej 1 wynik
            for ($i=0;$i<$num_rows;$i++) {
                $prod_name = $db->FetchResult($result,$i,"producer");
                $prod_id = $db->FetchResult($result,$i,"id");
                
                echo "
    <option value='$prod_id|$prod_name' " . @$selected["$prod_id|$prod_name"] . ">$prod_name</option>\n";
            }
        } else {
            // nie ma wyników
        }
    } else die ($db->Error());
} else die ($db->Error());

?>
</select>

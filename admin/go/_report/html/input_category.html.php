<?php
/**
* Element formularza - lista rozwijana kategorii do wyboru
*
* Lista kategorii wygenerowana jest na podstawie zapytania do tabeli order_products.
* Kolejne pola option maj± warto¶ci w postaci: IdKategorii1_IdKategorii2 - zgodnie
* z warto¶ciami id_category1 i id_category2 ka¿dego rekordu tabeli
*
* @author  lech@sote.pl
* @version $Id: input_category.html.php,v 1.4 2004/12/20 17:59:02 maroslaw Exp $
* @package    report
*/

if(@$category_data['id'] == '')
$category_data['id'] = 0;

$selected = array();
$selected[$category_data['id']] = 'selected';

?>
<select name=category_data[id] class="date"  style='width: 151px;'>
    <option value=0 <?php echo @$selected[0]; ?>> - <?php print $lang->report_all;?> - </option>
<?php
$category_data['id'] = addslashes($category_data['id']);
$categories_query = "SELECT category1, id_category1, category2, id_category2 FROM order_products
    WHERE user_id_main IS NOT NULL
    AND user_id_main <> '' GROUP BY id_category1, id_category2
    order by category1, category2";
$prepared_query=$db->PrepareQuery($categories_query);
if ($prepared_query) {
    // wykonanie zapytania
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // ilo¶æ odpowiedzi
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // jest conajmniej 1 wynik
            for ($i=0;$i<$num_rows;$i++) {
                $ids_category = $db->FetchResult($result,$i,"id_category1") . '_' . $db->FetchResult($result,$i,"id_category2");
                $names_category = $db->FetchResult($result,$i,"category1") . '_' . $db->FetchResult($result,$i,"category2");

                echo "
    <option value='$ids_category|$names_category' " . @$selected["$ids_category|$names_category"] . ">$names_category</option>\n";
            }
        } else {
            // nie ma wyników
        }
    } else die ($db->Error());
} else die ($db->Error());

?>
</select>

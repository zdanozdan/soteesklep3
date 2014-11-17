<?php
/**
 * Formularz - wybor partnera i okresu  
 *
 * @author  pmalinski@sote.pl 
 * @version $Id: rake_off.html.php,v 1.3 2004/12/20 18:00:23 maroslaw Exp $
* @package    partners
 */

global $my_date;

include_once ("include/forms.inc.php");
$forms = new Forms;


$action="rake_off.php";

$forms->open($action,"");

$query="SELECT name FROM partners";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        
        if ($num_rows>0) {
            for ($i=0;$i<$num_rows;$i++) {
                $partner_name=$db->FetchResult($result,$i,"name");
                $data[$i+1]=$partner_name;
            }
        }
    } else die ($db->Error());
} else die ($db->Error());

print "<tr>";
print "<td align=center>$lang->partners_choose";
$forms->select("partner_name",@$_REQUEST['item']['partner_name'],$lang->partners_choose,$data,"1","","f_empty","f_empty");
print "</td></tr>";
print "<tr><td align=center><b>$lang->partners_date</b></td></tr>";
print "<tr><td>";
print "<table align=center border=0 cellspacing=3>
<tr>
  <td>$lang->search_from</td>";
print "<td>";print $my_date->days("from");print "</td>";
print "<td>";print $my_date->months("from");print "</td>";
print "<td>";print $my_date->years("from");print "</td>";
print "<td>";print $lang->search_to;print "</td>";
print "<td>";print $my_date->days("to");print "</td>";
print "<td>";print $my_date->months("to");print "</td>";
print "<td>";print $my_date->years("to");print "</td>";
print "</tr></table>";

print "</td></tr>";

print "<tr>";
print "<td>";
$forms->button_submit("submit_form",$lang->partners_compute_rake_off);
print "</td></tr>";

$forms->close();

?>

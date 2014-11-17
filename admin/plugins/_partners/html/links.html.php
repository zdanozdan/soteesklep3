<?php
/**
 * Formularz - wybor partnera i generowanie linku dla niego
 *
 * @author  pmalinski@sote.pl 
 * @version $Id: links.html.php,v 1.3 2005/07/29 10:24:32 lukasz Exp $
* @package    partners
 */

include_once ("include/forms.inc.php");
$forms = new Forms;


$action="links.php";

$forms->open($action,"");

/*if(!empty($_REQUEST['partners'])) {
    $default_name=$_REQUEST['partners'];
} else $default_name=0; */

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
print "<td>$lang->partners_choose</td>";
print "<td>";
$forms->select("partner_name","0",$lang->partners_choose,$data,"1","","f_empty","f_empty");
print "</td></tr>";

print "<tr>";
print "<td><input type=checkbox name=partners>".$lang->partners_select_all."</td>";
print "<td>";
$forms->button_submit("submit_form",$lang->partners_gen);
print "</td></tr>";

$forms->close();

?>

<?php
/**
 * Wybierz grupe rabatowa, pokaz liste dostepnych grup rabatowych w liscie rozwijanej
 *
 * \@global  int    $__discount_group id grupy wybranej przez uzytkownika z listy 
 * \@global  string $__select_action gdzie bedzie submitowany formularz zmiany grupy
 * \@session int    $__discount_group jw.
 *
 * @author  m@sote.pl
 * @version $Id: choose_group.inc.php,v 2.4 2004/12/20 17:59:45 maroslaw Exp $
* @package    discounts
 */

require_once ("include/metabase.inc");
require_once ("include/forms.inc.php");

$forms = new Forms;
$forms->item=false;
$forms->form_name="groupForm";

if (ereg("^[0-9]+$",@$_REQUEST['discount_group'])) {
    $__discount_group=$_REQUEST['discount_group'];
    $sess->register("__discount_group",$__discount_group);
} elseif (ereg("^[0-9]+$",@$_SESSION['__discount_group'])) {
    $__discount_group=$_SESSION['__discount_group'];
} else $__discount_group=0;

print "\n\n";
print "\t<form action=$__select_action name=groupForm method=GET>\n";

if (! empty($_REQUEST['page'])) {
    print "<input type=hidden name=page VALUE=".$_REQUEST['page'].">\n";
}

print "<table>\n";
print "<tr>\n";
print "\t<td>".$lang->discounts_main_menu['choose_group']."</td>";
print "\t<td>";

// odczytaj grupy rabatowe
$dgroups=array("0"=>"---");
$query="SELECT group_name,user_id FROM discounts_groups ORDER BY group_name";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        $i=0;
        while ($i<$num_rows) {
            $user_id=$db->FetchResult($result,$i,"user_id");
            $group_name=$db->FetchResult($result,$i,"group_name");   
            $dgroups[$user_id]=$group_name;
            $i++;
        } // end while
    } else $dgroups=array();
} else die ($db->Error());
// end

$forms->select("discount_group",@$__discount_group,"",$dgroups,"no","","f_empty","f_empty");
print "<input type=submit value='>'>";
print "\t</td>";


print "</tr>";
print "</table>\n";
print "</form>\n\n";
?>

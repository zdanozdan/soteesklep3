<?php
/**
 * PHP Template:
 * Formularz edycji rekordu
 *
 * @author m@sote.pl 
 * @version $Id: edit.html.php,v 1.13 2005/03/29 14:49:34 lechu Exp $
* @package    discounts
* @subpackage discounts_groups
 */

if(! empty($_POST['item']['calculate_period'])) {
    $calculate_period=$_POST['item']['calculate_period'];
} else $calculate_period=@$rec->data['calculate_period'];

if (empty($calculate_period)) {
    $calculate_period=1;
}

if ($calculate_period==1) {
    $checked1="checked";
} else $checked1="";

if ($calculate_period==2) {
    $checked2="checked";
} else $checked2="";

if ($calculate_period==3) {
    $checked3="checked";
} else $checked3="";


if (! empty($_POST['item']['group_name'])) {
    $rec->data['group_name']=$_POST['item']['group_name'];
}

include_once ("include/forms.inc.php");
$forms = new Forms;

global $lang;
$theme->frame_open($lang->discounts_configuration);

print "<table>\n";
print "<tr>\n";
print "<td valign=top>";

global $__edit;
if ($__edit=="edit") $disabled=1;
else {
    $disabled=0;
    global $database;
    $new_id=$database->sql_select("max(user_id)","discounts_groups");
    $new_id++;
    $rec->data['user_id']=$new_id;
}

print "<div align=right>";
$theme->add2Dictionary(@$rec->data['group_name']);
print "</div>";

$forms->open($action,@$this->id,"groupForm","multipart/form-data");
$forms->text("user_id",@$rec->data["user_id"],$lang->discounts_groups_cols["user_id"],4,$disabled);
if ($disabled==1) {
    $forms->hidden("user_id",@$rec->data['user_id']);
}
if (ereg("Happy hour",@$rec->data['group_name'])) {
    $forms->hidden("group_name",@$rec->data['group_name']);
    echo "<tr><td align=right valign=top>" . $lang->discounts_groups_cols["group_name"] . "
    </td><td>
    " . @$rec->data['group_name'] . "</td></tr>";
}
else {
    $forms->text("group_name",@$rec->data["group_name"],$lang->discounts_groups_cols["group_name"],20);
}
$forms->text("default_discount",@$rec->data["default_discount"],$lang->discounts_groups_cols["default_discount"]." %",4);

// start user_sales
if (in_array("user_sales",$config->plugins)) {
    $forms->text("group_amount",@$rec->data["group_amount"],$lang->discounts_groups_cols["group_amount"],10);
    print "<tr>";
    print "<td align=right>".$lang->discounts_groups_cols["calculate_period"]."</td>";
    print "<td><fieldset>"; 
    print "<input type=radio name=item[calculate_period] value=1 $checked1>$lang->discounts_groups_no_period<BR>";
    print "<input type=radio name=item[calculate_period] value=2 $checked2>$lang->discounts_groups_year<BR>";
    print "<input type=radio name=item[calculate_period] value=3 $checked3>$lang->discounts_groups_start_year";
    print "</fieldset></td>";
    print "</tr>";
}
// end user_sales

// start happy hour
if (in_array("happy_hour",$config->plugins)) {
    if (ereg("Happy hour",@$rec->data['group_name'])) {
        $forms->text("start_date",@$rec->data["start_date"],$lang->discounts_groups_cols["start_date"],20);
        $forms->text("end_date",@$rec->data["end_date"],$lang->discounts_groups_cols["end_date"],20);
    }
}
// end happy hour

$forms->checkbox("public",@$rec->data["public"],$lang->discounts_groups_cols["public"]);
$forms->file("photo",$lang->discounts_groups_cols['photo']);
$forms->submit("",$lang->edit_submit);
$forms->close();

print "</td>\n";
print "<td valign=top>\n";

// pokaz grafike zwiazana z grupa rabatowa
if (! empty($rec->data['photo'])) {
    global $DOCUMENT_ROOT;
    $file="$DOCUMENT_ROOT/photo/_discounts_groups/".$rec->data['photo'];
    if (file_exists($file)) {
        print "<img src=/photo/_discounts_groups/".$rec->data['photo'].">\n";
    }
}

print "</td>\n";
print "</tr>\n";
print "</table>\n";
$theme->frame_close();

?>

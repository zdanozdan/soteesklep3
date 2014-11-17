<?php
/**
 * Lista dostepnosci produktow w sklepie
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.9 2006/02/28 15:17:15 lechu Exp $
* @package    options
* @subpackage available
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

$intervals_changed = @$_REQUEST['intervals_changed'];
// naglowek
$theme->head();
$theme->page_open_head();


print "<form action=delete.php method=post name=FormList id=FormList>";
include_once ("./include/menu.inc.php");

$intervals_by_from = array();
$intervals = array();
$error_intervals_message = '';

if (!empty($_REQUEST['update_intervals'])) {
    $intervals = $_REQUEST['form_intervals'];
    reset($intervals);
    while (list($key, $val) = each($intervals)) {
        if(!isset($intervals_by_from[$val['from']])) {
            $intervals_by_from[$val['from']] = $val['to'];
        }
        else {
            $error_intervals_message = $lang->error_message["duplicated_from_value"]; // 2 przedzia³y zaczynaj± siê od tej samej liczby
        }
    }
    
    if (empty($error_intervals_message)) {
        include("./include/check_intervals.inc.php");
        if(empty($error_intervals_message)) {
            include_once("./include/update_intervals.inc.php");
            include_once("./include/update_available_in_main.inc.php");
        }
    }
    
}
$theme->bar($lang->available_bar);

if (!empty($error_intervals_message)) {
    echo "<center><b>" . $error_intervals_message . "</b><br>
            " . $lang->error_message['not_changed'] . "</center><br><br>";
}

$intervals_by_from = array();
$intervals = array();
$error_intervals_message = '';

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/available_row.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM available";
$dbedit->top_links="false";
$dbedit->set_page_records = 10000;
$dbedit->record_class="AvailableRow";
print "<p>";

include_once ("./include/list_th.inc.php");
$dbedit->start_list_element=available_list_th();
$dbedit->show();

$theme->page_open_foot();
print "</form>";

include("./include/check_intervals.inc.php");
if (!empty($error_intervals_message)) {
    echo "<center><b>" . $error_intervals_message . "</b><br>
            " . $lang->error_message['need_to_repair'] . "</center><br><br>";
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

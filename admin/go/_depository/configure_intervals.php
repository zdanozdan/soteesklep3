<?php
/**
 * Magazyn
 * 
 * @author lech@sote.pl
 * @version $Id: configure_intervals.php,v 1.1 2005/11/18 15:31:22 lechu Exp $
 * @package    depository
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->available_bar);

$error_message = '';
$ok_message = '';

if (!empty($_REQUEST['form'])) {
    /*
    echo "<pre>";
    print_r($_REQUEST['form']);
    echo "</pre>";
    */
    include_once("./include/update_intervals.inc.php");
    if(empty($error_message)) {
        $ok_message = $lang->ok_message['intervals_changes'];
    }
}

print "<form action=configure_intervals.php method=post name=FormList>";

//include_once ("./include/menu.inc.php");


echo '<br>' . $error_message . $ok_message . '<br>';

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/available_row.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM available";
$dbedit->top_links="false";
$dbedit->record_class="AvailableRow";
print "<p>";

include_once ("./include/available_list_th.inc.php");
$dbedit->start_list_element=available_list_th();
$dbedit->show();
echo "<center><input type=submit value='" . $lang->confirm . "'></center>";
print "</form>";
$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
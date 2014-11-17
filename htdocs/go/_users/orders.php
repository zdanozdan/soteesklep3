<?php
/**
 * Poka¿ historiê transkacji zalogowanego uzytkownika.
 *
 * @author      piotrek@sote.pl m@sote.pl
 * @version     $Id: orders.php,v 2.5 2006/01/20 10:56:26 lechu Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("./include/order/order_func.inc.php");
// funkcja prezentujaca wynik zapytania w glownym oknie strony 
require_once ("lib/DBEdit-Metabase/DBEdit.inc");
 
// przekaz nazwy statusow wg id do obiektu $config
$status_names=read_status_names();
$config->order_status=$status_names;

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

include_once("./include/menu.inc.php");

// naglowek Moje transakcje
if (!empty($_SESSION['id_partner']))
    $theme->bar($lang->users_partners['bar'] . $lang->trans_bar_title);
else
    $theme->bar($lang->trans_bar_title);

if (ereg("^[0-9]+$",@$_SESSION['global_id_user'])) {
    // uzytkownik jest zalogowany 
    // TODO sprwadzenie czy user istnieje
    $global_id_user=$_SESSION['global_id_user'];
} else {
    $theme->go2main();
    exit;
}

$dbedit = new DBEdit;

$order_count = 0;
$total_sum = 0;
$rake_sum = 0;

$res = $mdbd->select("id_partner", "users", "id=?", array($global_id_user => "int"), "", "array");// pobranie id partnera
if (!empty($res[0]["id_partner"])) {
    $form = @$_REQUEST['form'];
    $date_filter = '';
    if(!empty($form)) {
        $date_from = addslashes($form['yyyy_from']) . '-' . addslashes($form['mm_from']) . '-' . addslashes($form['dd_from']);
        $date_to = addslashes($form['yyyy_to']) . '-' . addslashes($form['mm_to']) . '-' . addslashes($form['dd_to']);
        $date_filter = " AND date_add >= '$date_from' AND date_add <= '$date_to' ";
    }
    $id_partner = $res[0]["id_partner"];
    $res = $mdbd->select("partner_id", "partners", "id=?", array($id_partner => "int"), "", "array"); // pobranie 8-cyfrowego numeru partnera
    $partner_id = $res[0]["partner_id"];
    
    // zapytanie dla o transakcje wykonane na rzecz zalogowanego partnera
    $sql="SELECT * FROM order_register WHERE partner_id=$partner_id AND confirm_partner=1 AND cancel=0 $date_filter ORDER BY order_id DESC";
    $dbedit->page_records=20;
    $dbedit->page_links=20;
    
    // pobierz liczbê zamówieñ, ich warto¶æ oraz prowizjê
    $agr_query = "SELECT COUNT(id) AS order_count, SUM(total_amount) AS total_sum, SUM(rake_off_amount) AS rake_sum FROM order_register WHERE partner_id=$partner_id AND confirm_partner=1 AND cancel=0 $date_filter ORDER BY order_id DESC";
    $prepared_query = $db->PrepareQuery($agr_query);
    if ($prepared_query) {
        $result=$db->ExecuteQuery($prepared_query);
        if ($result != 0) {
            $order_count = $db->FetchResult($result,0,"order_count");
            $total_sum = $db->FetchResult($result,0,"total_sum");
            $rake_sum = $db->FetchResult($result,0,"rake_sum");
            // echo "[$order_count][$total_sum][$rake_sum]";
        }
    }
    
    $theme->after_main_func="ordersFilter";
}
else {
    //zapytanie o te rekordy (liste transakcji), ktore naleza do danego usera
    $sql="SELECT * FROM order_register WHERE id_users=$global_id_user ORDER BY order_id DESC";
    $dbedit->page_records=20;
    $dbedit->page_links=20;
}
// ustal klase generujaca wiersz rekordu
require_once("./include/order/trans.inc.php");

// ustal funkcje generujaca wiersz rekordu
$dbedit->start_list_element=$theme->trans_list_th();
$dbedit->record_class="TransRecordRow";
$dbedit->dbtype=$config->dbtype;
$dbedit->record_list($sql); 

if (!empty($id_partner)) {
    $theme->ordersFilter();
}

$theme->theme_file("products4u.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

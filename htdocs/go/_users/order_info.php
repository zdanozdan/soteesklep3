<?php
/**
* Poka¿ informacje szczegó³owe o transakcji.
* Transakcja mo¿e byæ wybrana z listy tranakcji lub mo¿e wyæ przekeirowanie do niej z maila.
* W drugim przypadku przy wywo³aniu podawane s± parametry trans(order_id) oraz code - kod powierdzajacy - suma kontrolna
*
* @require $id GET
* @version    $Id: order_info.php,v 2.7 2006/01/20 10:55:41 lechu Exp $
* @package    users
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("./include/order/currency.inc.php");
require_once ("include/my_crypt.inc");
require_once ("./include/order/order_func.inc.php");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    
    // sprawdz czy podano prawidlowy parametr (tylko liczba)
    if (! ereg("^[0-9]+$",$id)) die ("Forbidden");
    
    if (! empty($_REQUEST['code'])) {
        // sprawdzenie czy klient moze wyswietlic swoja transakcje
        // suma kontrolna klienta
        $client_sign=$_REQUEST['code'];
        // suma kontrolna serwera
        $server_sign=md5($id.$config->salt);
        if ($server_sign!=$client_sign) {
            $theme->go2main();
            exit;
        }
    } else {        
        // sprawdz czy podano identyfikator transakcji nalezacej rzeczywiscie do uzytkownika lub partnera!
        $my_id=$_SESSION['global_id_user'];
        $res = $mdbd->select("id_partner", "users", "id=?", array($my_id => "int"), "", "array");// pobranie id partnera
        if (!empty($res[0]["id_partner"])) {
            $id_partner = $res[0]["id_partner"];
            $res = $mdbd->select("partner_id", "partners", "id=?", array($id_partner => "int"), "", "array"); // pobranie 8-cyfrowego numeru partnera
            $partner_id = $res[0]["partner_id"];
            $query="SELECT order_id from order_register where partner_id=?"; // czy to zamówienie partnera
            $int_to_set = $partner_id;
        }
        else {
            $query="SELECT order_id from order_register where id_users=?"; // czy to zamówienie u¿ytkownika
            $int_to_set = $my_id;
        }
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$int_to_set);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $i=0;
                    while($i<$num_rows) {
                        $my_orders[$i]=$db->Fetchresult($result,$i,"order_id");
                        $i++;
                    }
                } else {
                    $theme->go2main();
                    exit;
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        // jesli nie ma zamowienia w tablicy, to znaczy ze nie jest to zamowienie usera
        if(! in_array($id,$my_orders)) die ("Forbidden");
    }
} else {
    $theme->go2main();
    exit;
}

// odczytaj dane transakcji
$query="SELECT * FROM order_register WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // odczytaj wlasciowasi transakcji
            require_once("./include/order/query_rec.inc.php");
        } else {
            $theme->go2main();
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());


// odkoduj zakodowane dane
$my_crypt =& new MyCrypt;

// odczytaj nazwe dostawcy
$query="SELECT id,name FROM delivery WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$rec->data['id_delivery']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['delivery_name']=$db->FetchResult($result,0,"name");
        } else $rec->data['delivery_name']="-";
    } else die ($db->Error());
} else die ($db->Error());


$theme->head();
$theme->page_open_head("page_open_1_head");
if (!empty($_SESSION['global_login'])) {
    include_once("./include/menu.inc.php");
}
if (!empty($_SESSION['id_partner']))
    $theme->bar($lang->users_partners['bar'] . $lang->trans_products." ".$rec->data['order_id']);
else
    $theme->bar($lang->trans_products." ".$rec->data['order_id']);


$theme->theme_file("trans_products.html.php");

$theme->page_open_foot("page_open_1_foot");
$theme->foot();
include_once ("include/foot.inc");

?>

<?php
/**
* Odebranie komunikatow o bledach z systempu PolCard.
* Pola przekazywane jako POST: order_id, session_id, pos_id, message, err_code
*
* @author  m@sote.pl
* @version $Id: adv_error.php,v 1.5 2005/01/20 15:00:31 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

// podmiana zmiennych sesji
if (! empty($_REQUEST['session_id'])) {
    $_POST['sess_id']=&$_POST['session_id'];
}

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/polcard_config.inc.php"); // konfiguracja klienta
require_once ("./include/get_param.inc.php");

$polcard_config->error['order_id']=get_param("order_id");
$polcard_config->error['session_id']=get_param("session_id");
$polcard_config->error['pos_id']=get_param("pos_id");
$polcard_config->error['message']=get_param("message");
$__polcard_error=&$polcard_config->error['message'];
$polcard_config->error['err_code']=get_param("err_code");

// weryfikacja przekazania komunikatu
// sprawdz POS_ID
if ($polcard_config->error['pos_id']!=$polcard_config->posid) {
    $theme->go2main();
    exit;
}

if (@$polcard_config->error['order_id']!=@$_SESSION['global_order_id']) {
    $theme->go2main();
    exit;
}

// sprawdz metode platnosci jaka zostala wybrana dla danego order_id
$query="SELECT id_pay_method FROM order_register WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$polcard_config->error['order_id']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $id_pay_method=$db->FetchResult($result,0,"id_pay_method");
            if ($id_pay_method!=3) {   // 3 oznacza PolCard
            $theme->go2main();
            exit;
            } else {
                // wszystko sie zgadza
            }
        } else {
            $theme->go2main();
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());


$query="UPDATE order_register SET error=?, error_desc=? WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText(   $prepared_query,1,$polcard_config->error['err_code']);
    $db->QuerySetText(   $prepared_query,2,$polcard_config->error['message']);
    $db->QuerySetInteger($prepared_query,3,$polcard_config->error['order_id']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // OK udalo sie zaktualizowac dane o bladach transakcji
    } else die ($db->Error());
} else die ($db->Error());

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->bar_title['polcard']);

// @param string $__polcard_message komunikat o bledzie przekazany z polcardu
$theme->theme_file("_polcard/polcard_error.html.php");

$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();

// stopka
include_once ("include/foot.inc");
?>

<?php
/**
* Wyslanie zamowienia platnosc PolCard. Wyslanie zamowienia
* na konto e-mail + potwierdzenie dla klienta.
*
* @author m@sote.pl
* @version $Id: adv_welcome_back.php,v 1.7 2005/01/20 15:00:32 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

/**
* \@session string $global_lock_send zapamietanie informacji, ze zamowienie zostalo juz wyslane
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

/**
* Obs³uga koszyka.
*/
require_once ("go/_basket/include/my_basket.inc.php");

/**
* Obliczanie sumy kontrolnej.
*/
require_once ("include/order_register.inc");

if (! empty($_SESSION['global_order_id'])) {
    $order_id=$_SESSION['global_order_id'];
    if (! ereg("^[0-9]+$",$order_id)) die ("Forbidden order_id");
} else die ("Forbidden order_id");

// odczytaj response_code z polcard_auth, ocene ryzyka, sume kontrolna
$query="SELECT response_code,fraud,checksum,amount FROM polcard_auth WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$order_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $response_code=$db->FetchResult($result,0,"response_code");
            $fraud=$db->FetchResult($result,0,"fraud");
            $amount=$db->FetchResult($result,0,"amount");
            $checksum=$db->FetchResult($result,0,"checksum");
        } else {
            // nie ma takiej transakcji
            $theme->go2main();
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());

if ($response_code=="000") $auth=1; else $auth=0;

// sprawdz sume kontrolna

$amount=number_format(($amount/100),2,".","");

/*
print "db_checksum=$checksum order_id=$order_id auth=$auth amount=$amount <BR>";
$my_checksum=OrderRegisterChecksum::checksum($order_id,$auth,$amount);
print "my_checksum=$my_checksum <BR>";
if ($my_checksum!=$checksum) die ("! Forbidden");
*/

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

// wyswietl informacje o wyslaniu zamowienia
if ($auth==1) {
    // wyslij mailem zamowienie
    include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");
    
    $theme->bar($lang->bar_title['polcard']);
    print "<p>";
    $theme->send_confirm();
    print "<p>";
    
    // zamknij cala sesje
    session_unset();
    $start_new_session=1; $sess->register("start_new_session",$start_new_session);
    
} else {
    $theme->bar($lang->bar_title['polcard']);
    $theme->theme_file("_polcard/polcard_false.html.php");
}

$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

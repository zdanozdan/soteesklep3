<?php
/**
* Przekierowanie z systemu przelewy24 po autoryzacji.
* Strona oczekuj±ca na otrzymanie potwierdzenia z przelewy24.pl statusu zamówienia.
*
* @author m@sote.pl
* @version $Id: confirm_check.php,v 1.8 2006/02/15 09:49:01 lukasz Exp $
* @package przelewy24
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];


/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

// zmiana zmiennej przekazuj±cej sesjê
/*
if ((empty($_REQUEST['sess_id'])) && (! empty($_POST['p24_session_id']))) {
if ($config->ssl=="yes") $protocol="https";
else $protocol="http";
header ("Location:  $protocol://".$_SERVER['HTTP_HOST']."/plugins/_pay/_przelewy24/confirm_check.php?sess_id=".$_POST['p24_session_id'].
"&p24_order_id=".$_POST['p24_order_id']."&p24_kwota=".$_POST['p24_kwota']."&p24_session_id=".$_POST['p24_session_id']);
exit;
}
*/

define ("P24_CONFIRM_RESPONSE_TRUE",1);
define ("P24_CONFIRM_RESPONSE_FALSE",-1);
define ("P24_CONFIRM_RESPONSE_UNKNOWN",-2);
define ("P24_CONFIRM_AUTH_TRUE",1);
define ("P24_CONFIRM_AUTH_FALSE",-1);
define ("P24_CONFIRM_AUTH_UNKNOWN",-2);
define ("P24_CONFIRM_AUTH_FALSE_PARAM",-3);

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

/**
* Biblioteka obs³uguj±ca po³±czenia HTTPS/SSL
*/
require_once ("HTTP/Request.php");

$req =& new HTTP_Request(URL_SSL);
$req->setMethod(HTTP_REQUEST_METHOD_POST);
if ((! empty($_REQUEST['p24_session_id'])) && (! empty($_REQUEST['p24_order_id']))) {
    $req->addPostData("p24_session_id",$_REQUEST['p24_session_id']);
    $req->addPostData("p24_order_id",$_REQUEST['p24_order_id']);
    $req->addPostData("p24_id_sprzedawcy",$przelewy24_config->posid);
    /*
    print "p24_session_id=".$_REQUEST['p24_session_id']."<br>";
    print "p24_order_id=".$_REQUEST['p24_order_id']."<br>";
    print "p24_id_sprzedawcy=".$przelewy24_config->posid."<br>";
    */
    $res = $req->sendRequest();
    if (PEAR::isError($res)) {
        die($res->getMessage());
    }

    $response1 = $req->getResponseBody();
    $response2 = $req->getResponseHeader("Content-Length");

    /**
    * Obs³uga P24.
    */ 
    require_once("./include/przelewy24.inc.php");
    $p24 =& new Przelewy24();

    if (ereg("TRUE",$response1)) {
    		global $mdbd;
    		global $db;
//    		$db->debug=1;
    		
    		$p24_session=$_REQUEST['p24_session_id'];
    		$query="SELECT order_id FROM order_register WHERE session_id='$p24_session' LIMIT 1";
    		$result=$db->Query($query);
    		if ($result!=0) {
    		   $order_id=$db->FetchResult($result,0,'order_id');
    		}
    		if (!empty($order_id)) {
    		    if (empty($_SESSION['order_id']));
    			$session=$mdbd->select('data','order_session',"order_id='$order_id'");
    			if (!empty($session)) {
    			    $global_id_pay_method = $_SESSION['global_id_pay_method'];
    				$_SESSION=unserialize($session);
    				// zapalamy flage
    				$session_restored=true;
    			}
    		}
        // transakcja zosta³a potwierdzona
        if ($p24->confirm($_REQUEST['p24_order_id'],$_REQUEST['p24_session_id'],$_REQUEST['p24_kwota'])) {        
            $p24->saveData($_REQUEST['p24_order_id'],$_REQUEST['p24_session_id'],$_REQUEST['p24_kwota'],P24_CONFIRM_RESPONSE_TRUE,P24_CONFIRM_AUTH_TRUE);
        } else {
            // odmowa autoryzacji ze strony skryptu potwierdzajacego kwote itp.
            $p24->saveData($_REQUEST['p24_order_id'],$_REQUEST['p24_session_id'],$_REQUEST['p24_kwota'],P24_CONFIRM_RESPONSE_TRUE,P24_CONFIRM_AUTH_FALSE);            
            
            global $db;
            $query="UPDATE order_register SET (pay_status='1251') WHERE order_id='".$p24->order_id."' AND session_id='".$_REQUEST['p24_session_id']."' LIMIT 1";
            $db->Query($query);
            // nadaj transakcji odpowiedni status w tablicy order_register pay_status
//            $mdbd->update("order_register","pay_status=?","order_id=? AND session_id=?",
//            array (
//            "1251"=>"int",
//            $p24->order_id=>"int",
//            $_REQUEST['p24_session_id']=>"text"
//            ),"LIMIT 1");                        
            
        }

	    $response1 = $req->getResponseBody();
	    $response2 = $req->getResponseHeader("Content-Length");
        // Je¶li odebrano wynik poprawnej autoryzacji z p24, to zawsze wy¶wietlaj informacje o popranie
        // zakoñczonej transakcji. Je¶li wynik wewnêtrznej weryfikacji danych siê nie zgadza, to wcze¶niej
        // jest to odpowiednio odnotowywane w bazie danych.
        
        /**
        * Wy¶lij zamówienie, wy¶wietl kody (opcjonalnie) itp. Zakoñczenie zamówienia. 
        * Wy¶wietl komuniakt klientowi i podziêkowanie za dokonanie zakupów.
        */
        require_once("confirm.php");
        exit;
        
    } else {
        // P24:response !=TRUE -> FALSE        
        // odmowa autoryzacji ze strony systemu przelewy24 (przelew nie potwierdzony)        
        $p24->saveData($_REQUEST['p24_order_id'],$_REQUEST['p24_session_id'],$_REQUEST['p24_kwota'],P24_CONFIRM_RESPONSE_FALSE,P24_CONFIRM_AUTH_UNKNOWN);
                
        $theme->bar($lang->przelewy24_title);
        include_once ("plugins/_pay/_przelewy24/html/przelewy24_error.html.php");
    }
} else {
    // odmowa autoryzacji, brak odpowiednich parametrów w wywo³aniu strony
    $p24->saveData($_REQUEST['p24_order_id'],$_REQUEST['p24_session_id'],$_REQUEST['p24_kwota'],P24_CONFIRM_RESPONSE_UNKNOWN,P24_CONFIRM_AUTH_FALSE_PARAM);
    $theme->bar($lang->przelewy24_title);
    include_once ("plugins/_pay/_przelewy24/html/przelewy24_error.html.php");
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

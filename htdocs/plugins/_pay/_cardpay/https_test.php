<?php
/**
* Test wywo³ania SSL POST/GET.
*
* @author  m@sote.pl
* @Version $Id: https_test.php,v 1.1 2005/10/26 12:45:26 lukasz Exp $
* @package przelewy24
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek.
*/
require_once ("../../../../include/head.inc");

/**
* Biblioteka obs³uguj±ca po³±czenia HTTPS/SSL
*/
require_once ("HTTP/Request.php");

/**
* Adres testowy.
*/
define ("URL_SSL","https://secure.przelewy24.pl:443/transakcja.php");

if (empty($_POST)) {
    print "<form action=".URL_SSL." method=POST>\n";
    print "p24_session_id<input type=text name=p24_session_id value='' size=40><br />\n";
    print "p24_order_id<input type=text name=p24_order_id value='' size=40><br />\n";
    print "p24_id_sprzedawcy<input type=text name=p24_id_sprzedawcy value='' size=40><br />\n";
    print "<input type=submit name=submit value='Wyslij'>\n";
    print "</form>\n";
    print "<form action=https_test.php method=POST>\n";
    print "<input type=submit name=submit value='Test odebrania komunikatu SSL za pomoca HTTP::Request'>\n";
    print "</form>\n";
} else {
    $req =& new HTTP_Request(URL_SSL);
    $req->setMethod(HTTP_REQUEST_METHOD_POST);

    $res = $req->sendRequest();
    if (PEAR::isError($res)) {
        die($res->getMessage());
    }

    $response1 = $req->getResponseBody();
    $response2 = $req->getResponseHeader("Content-Length");
    echo $response1;

    print "Dane pobrane, sprawdz zrodla strony.";
}

include_once ("include/foot.inc");
?>

<?php
/**
* Potwierdzenie autoryzacji p³atno¶ci realizowanej przez PolCard. Skrypt wywo³ywany z systemu PolCardu podczas
* autoryzacji karty.
*
* @author  m@sote.pl
* @version $Id: adv_confirm.php,v 1.6 2005/01/20 15:00:31 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

// w httpd.conf w apache nalezy ustawic wymaganie, waznego i podpisanego przez znane CA, certyfikatu SSL dla tego pliku
// lub wywolac ponizszy kod
/**
* Weryfikacja certyfikatu SSL klienta.
*/
require_once ("./include/check_ssl.inc.php");

// wymagaj wywolania przez HTTPS
if (empty($_SERVER['HTTPS'])) die ("Forbidden");
if ($_SERVER['HTTPS']!="on") die ("Forbidden");

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/polcard_config.inc.php"); // konfiguracja klienta
require_once ("./config/config.inc.php");                   // konfiguracja parametrow ssl
require_once ("./include/polcard.inc.php");
require_once ("include/order_register.inc");                // funkcja obliczania sumy kontrolnej
require_once ("include/my_crypt.inc");

$polcard = new Polcard;

require_once ("./include/get_param.inc.php");

$polcard_config->auth=array();
$polcard_config->auth['order_id']=get_param("order_id");
$polcard_config->auth['session_id']=get_param("session_id");
$polcard_config->auth['amount']=get_param("amount");
$polcard_config->auth['response_code']=get_param("response_code");
$polcard_config->auth['cc_number_hash']=get_param("cc_number_hash");
$polcard_config->auth['card_type']=get_param("card_type");
$polcard_config->auth['address_ok']=get_param("address_ok");
$polcard_config->auth['test']=get_param("test");
$polcard_config->auth['auth_code']=get_param("auth_code");
$polcard_config->auth['crypt_bin']=$my_crypt->endecrypt("",get_param("bin"));
$polcard_config->auth['fraud']=get_param("fraud");
$polcard_config->auth['sequence']=get_param("sequence");

// sprawdz ocene ryzyka, jesli jest zbyt duza nie realizuj on-line platnosci
if ($polcard_config->auth['fraud']>=2) {
    $polcard_config->auth['response_code']="100";  // odmowa autoryzacji
}

// oblicz sume kontrolna
$amount=number_format(($amount/100),2,".","");
if ($polcard_config->auth['response_code']=="000") $auth=1; else $auth=0;
$polcard_config->auth['checksum']=OrderRegisterChecksum::checksum($polcard_config->auth['order_id'],$auth,$amount);

// zapisz w bazie dane
$query="INSERT INTO polcard_auth (order_id,session_id,amount,response_code,cc_number_hash,card_type,address_ok,test,auth_code,
                                  crypt_bin,fraud,sequence,checksum)
               VALUES            (?,?,?,?,?,?,?,?,?,?,?,?,?) 
       ";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    $db->QuerySetInteger($prepared_query,1, $polcard_config->auth['order_id']);
    $db->QuerySetText(   $prepared_query,2, $polcard_config->auth['session_id']);
    $db->QuerySetFloat(  $prepared_query,3, $polcard_config->auth['amount']);
    $db->QuerySettext(   $prepared_query,4, $polcard_config->auth['response_code']);
    $db->QuerySettext(   $prepared_query,5, $polcard_config->auth['cc_number_hash']);
    $db->QuerySettext(   $prepared_query,6, $polcard_config->auth['card_type']);
    $db->QuerySettext(   $prepared_query,7, $polcard_config->auth['address_ok']);
    $db->QuerySettext(   $prepared_query,8, $polcard_config->auth['test']);
    $db->QuerySettext(   $prepared_query,9, $polcard_config->auth['auth_code']);
    $db->QuerySettext(   $prepared_query,10,$polcard_config->auth['crypt_bin']);
    $db->QuerySettext(   $prepared_query,11,$polcard_config->auth['fraud']);
    $db->QuerySettext(   $prepared_query,12,$polcard_config->auth['sequence']);
    $db->QuerySettext(   $prepared_query,13,$polcard_config->auth['checksum']);
    $result=$db->ExecuteQuery($prepared_query);
    
    if ($result!=0) {
        
        // aktualizuj transakcje
        require_once ("./include/order_register.inc.php");
        $update_order=OrderRegisterLocalFn::update_confirm($polcard_config->auth['order_id'],$auth,$polcard_config->auth['fraud'],
        $polcard_config->auth['amount']);
        if ($update_order==true) {
            
            // transakcja dodana do bazy i poprawnie zaktualizowana
            print "<html>\n";
            print "<body>\n";
            if ($config->ssl=="yes") {
                print "<url_redirect>https://".$config->www."/go/_register/_polcard/adv_welcome_back.php?sess_id=".
                $polcard_config->auth['session_id'].
                "</url_redirect>\n";
            } else {
                print "<url_redirect>http://".$config->www."/go/_register/_polcard/adv_welcome_back.php?sess_id=".
                $polcard_config->auth['session_id'].
                "</url_redirect>\n";
            }
            print "</body>\n";
            print "</html>\n";
            exit;
        } else {
            // include_once ("adv_confirm.php.polcard_test_ok");
            // nie udalo sie zaktulizowac danych transakcji, nie wyswietlaj info polcardowi
            // klient otrzyma informacje, ze transakcja nie zostala poprawnie "odebrana" - info z WWW->polcardu
        }
    } else {
        
        /*
        $fd=fopen("log/error.db","a+");
        $log=date("r")."\t".$db->Error();
        fwrite($fd,$log,strlen($log));
        fclose($fd);
        die();
        */
    }
} else {
    /*
    $fd=fopen("log/error.db","a+");
    $log=date("r")."\t".$db->Error();
    fwrite($fd,$log,strlen($log));
    fclose($fd);
    die();
    */
}
// end


// bez wzgledu na to, czy udalo sie zapisac dane, czy nie, pokaz url_redirecT (wymagane przez polcard)
print "<html>\n";
print "<body>\n";
print "<url_redirect>http://".$config->www."</url_redirect>\n";
print "</body>\n";
print "</html>\n";
// end

exit;

// stopka
include_once ("include/foot.inc");
?>

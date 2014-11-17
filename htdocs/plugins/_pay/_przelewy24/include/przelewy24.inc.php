<?php
/**
* Obs³uga p³atno¶ci przelewy24.pl
*
* @author  m@sote.pl
* @version $Id: przelewy24.inc.php,v 1.15 2006/05/31 11:37:55 lukasz Exp $
* @package przelewy24
*/

/**
* Konfiguracja systemu przelewy24, definicje u¿ytkownika.
*/
@include_once ("config/auto_config/przelewy24_config.inc.php");

/**
* @package przelewy24
*/
class Przelewy24 {

    /**
    * @var int numer transakcji z tabeli order_register, warto¶æ order_id    
    */
    var $order_id=0;
    
    /**
    * @var string p24_session_id numer sesji przekazany z p24 (powinien odpowiadaæ numerowi sesji ze sklepu)
    */
    var $session_id='';
    
    /**
    * Konstruktor
    */
    function Przelewy24() {}
    
    // {{{ confirm()

    /**
    * Funkcja weryfikuj±ca odp. autoryzacyjn± oraz zapisuj±ca informacjê o autoryzacji w order_register.
    * FUnkcja jest wywo³ywana w przypadku odebrania komunikatu TRUE z systemu przelewy24.pl.
    *
    * @param string $p24_order_id   ID transakcji nadane w systemie przelewy24, parametr odebrany z POST
    * @param string $p24_session_id numer sesji, parametr odebrany z POST
    * @param string $p24_kwota      kwota zamówienia w groszach, parametr odebrany  z POST
    * @return bool true - transakcja potwierdzona, dane siê zgadzaj±; false - w p.w.
    */
    function confirm($p24_order_id,$p24_session_id,$p24_kwota) {
        global $_SESSION;
        global $mdbd;
		global $db;
        // sprawd¼ czy wcze¶niej tranakcja by³a poprawnie zatwierdzona
        $dat=$mdbd->select("response_auth,confirm_auth","przelewy24_auth","p24_order_id=? AND p24_session_id=?",
        array(
        $p24_order_id=>"text",
        $p24_session_id=>"text"
        ),"ORDER BY id DESC LIMIT 1");
        if (($dat['response_auth']==1) && ($dat['confirm_auth']==1)) {
            return true;
        }
		// zawsze ladujemy z bazy zeby otrzymac wynik uwzgledniajacy koszta dostawy
//        if (empty($_SESSION['p24_kwota'])) {
            $this->_getSessionInfoFromDB($p24_session_id);
//        }

        // zapamiêtaj dane, które po¼niej zostan± wykorzystane do aktualizacji
        // pay_status w order_register
        $this->order_id=$_SESSION['global_order_id'];        
        $this->session_id=$p24_session_id;
        // end
        if (empty($_SESSION['p24_kwota'])) {
            return false;
        }
        if (number_format($p24_kwota,2,'.','')!=number_format($_SESSION['p24_kwota'],2,'.',''))  {
            return false;
        }
        
        if (! empty($_SESSION['global_order_id'])) {
            $order_id=$_SESSION['global_order_id'];
        } else {            
            return false;
        }
        require_once("include/order_register.inc");
        $orgc =& new OrderRegisterChecksum();

        // format ceny wymagany do generowania sumy kontrolnej
        $amount=number_format((($p24_kwota)/100),2,'.','');

        // generuj sumê kontroln±
        $checksum_online=$orgc->checksum($order_id,1,$amount);

        $mdbd->update("order_register","confirm_online=?,confirm=?,checksum_online=?","order_id=?",
        array(
        "1,"."1"=>"int",
        "2,"."1"=>"int",
        "3,".$checksum_online=>"text",
        "4,".$order_id=>"int",
        ));

        return true;
    } // end confirm()

    // }}}

    // {{{  getSessionInfoFromDB()

    /**
    * Odczytaj dane dot. transakcji z bazy i udostêpnij je w tablicy sesji
    *
    * @param string $session_id numer sesji
    * @access private
    * @return none
    */
    function _getSessionInfoFromDB($session_id) {
        global $mdbd;
        global $_SESSION;

        $order=$mdbd->select("order_id,total_amount,delivery_cost","order_register","session_id=?",array($session_id=>"text"),"ORDER BY id DESC LIMIT 1");
        $_SESSION['p24_kwota']=($order['total_amount']+$order['delivery_cost'])*100;
        $_SESSION['global_order_id']=$order['order_id'];   
        
        return;
    } // end _getSessionInfoFromDB()

    // }}}

    /**
    * Zapisz dane z przelewy24 w bazie danych.
    * Dane s± zapisywane do celów debugowania.
    *
    * @param string $p24_order_id   order id transakcji, numer nadawany przez system przelewy24 np. p24-102-498
    * @param string $p24_session_id numer sesji, warto¶æ parametru przekazywany z systemu przelewy24
    * @param int    $p24_kwota      warto¶æ transakcji w groszach np. dla 20 z³ 34 gr bêdzie to 2034
    * @param int    $response_auth  status odebrania odpowiedzi autoryzacyjnej z przelewy24
    * @param int    $confirm_auth   status weryfikacji parametrów przekazanych przy autoryzacji m.in. kwoty
    * @return void
    */
    function saveData($p24_order_id,$p24_session_id,$p24_kwota,$response_auth,$confirm_auth) {
        global $db;

        $query="INSERT INTO przelewy24_auth (p24_session_id,p24_order_id,p24_kwota,response_auth,confirm_auth)
                VALUES (?,?,?,?,?)";
        $prepared_query=$db->prepareQuery($query);
        if ($prepared_query) {
            $db->querySetText($prepared_query,1,$p24_session_id);
            $db->querySetText($prepared_query,2,$p24_order_id);
            $db->querySetText($prepared_query,3,$p24_kwota);
            $db->querySetText($prepared_query,4,$response_auth);
            $db->querySetText($prepared_query,5,$confirm_auth);
            $result=$db->executeQuery($prepared_query);
            if ($result!=0) {
                // rekord zostal dodany
                // print "INSERT OK <br>$query<br>";
            }
        }

        return;
    } // end saveData()

    // {{{ getInfo()

    /**
    * Odczytaj dodatkowe dane z zamówienia przekazywane do centrum autoryzacji
    *
    * @param string $type
    * @return string opis pola wg danych z formularza
    */
    function getInfo($type) {
        global $_SESSION,$config;

        $form=array();$form_cor=array();
        if (! empty($_SESSION['form'])) $form=$_SESSION['form'];
        if (! empty($_SESSION['form_cor'])) $form_cor=$_SESSION['form_cor'];
        
        if (! empty($form_cor)) $form2=$form_cor;
        else $form2=$form;
        
        switch ($type) {
            case "p24_klient":
            $val=$form2['name']." ".$form2['surname'];
            break;
            case "p24_adres":
            $val=$form2['street']." ".$form2['street_n1'];
            if (! empty($form2['street_n2'])) $val.="/".$form2['street_n2'];
            break;
            case "p24_miasto":
            $val=$form2['city'];
            break;
            case "p24_kod":
            $val=$form2['postcode'];
            break;
            case "p24_language":
            switch ($config->lang) {
                case "pl": $val="pl";
                break;
                default: $val="en";
                break;
            }
            break;
            case "p24_kraj":
            // dla wersji 3.0
            if ($config->version=="3.x") {
                $val="PL";
            } else {
                // dla wersji 3.1.x i nowszych
                $val=$form2['country'];
            }
            break;
            case "p24_email":
            if (!empty($form2['email'])) $val=$form2['email'];
            else $val=$form['email'];
            break;
        }
        return $val;
    } // end getInfo()

    // }}}


} // end class Przelewy24
?>

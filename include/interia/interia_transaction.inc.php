<?php
/**
* Obsluga glowna klasa do kominkacji z interia
*
* @author  rdiak@sote.pl
* @version $Id: interia_transaction.inc.php,v 1.5 2005/12/23 14:37:05 scalak Exp $
* @package    pasaz.interia.pl
*/

require_once("include/interia/interia.inc.php");
include_once("include/metabase.inc");
require_once ("HTTP/Client.php");

class InteriaTransaction extends Interia {


    /**
    * Konstruktor obiektu interiaTransaction
    *
    * @return boolean true/false
    */
    function InteriaTransaction() {
        // wywolaj konstruktor obiektu rodzica.
        $this->interia();
        return true;
    } // end interiaTransaction

    /**
    * Funkcja wysy³a trnasakcje do pasazu interia w momencie sfianalizowania zakupow w sklepie
    * i wyslania zamowienia. Ta transakcja musi jeszcze zostac potwierdzona lub wycofana z
    * poziomu panelu administracyjnego.
    *
    * @return boolean true/false
    */
    function SendTrans($order_id,$state) {
        global $mdbd;
        global $lang;
        global $database;
        global $interia_config;
        global $_SESSION;

        if($interia_config->interia_load == 'test') {
            $url="http://".$interia_config->interia_test_server.$interia_config->interia_transaction;
        } else {
            $url="http://".$interia_config->interia_server.$interia_config->interia_transaction;
        }

        $global_order_amout=$database->sql_select("amount","order_register","order_id=".$order_id);
        // jesli sa jakies dane do wyslania
        $product=$mdbd->select("user_id_main,num","order_products","order_id=".$order_id,"","","array");
        $orders='';
        foreach($product as $key1=>$value1) {
            $id=$database->sql_select("id","main",""," WHERE user_id='".$value1['user_id_main']."'");
            $orders.=$id."_".$value1['num'].";";
        }
        $orders=preg_replace("/;$/","",$orders);
        $price=$global_order_amout*100;
        $http =& new HTTP_Client;
        
        $http->get($url,array(
                            "state"=>$state,
                            "shop"=>$interia_config->interia_shop_id,
                            "trans"=>$order_id,
                            "orders"=>$orders,
                            "price"=>$price
                        )
        );
        $result=$http->_responses;
        return true;
    } // end SendTransFromShop

    /**
    * Funkcja jest wywolywana z poziomu panelu administracyjnego
    * i wysy³a transakcje potwierdzone i anulowane do pasazu interia
    *
    * @return boolean true/false
    */
    function ConfirmTrans() {
        // wyslij tranasakcje do potwiedzenia
        $this->CommitTrans();
        // wyslij tanskacje do anulowania
        $this->RollbackTrans();
        return true;
    } // end ConfirmTrans

    /**
    * Funkcja tworzy i wysla komunikat SOAP z transakcjami
    * do potwiedzenia
    *
    * @return boolean true/false
    */
    function CommitTrans() {
        global $mdbd;
        global $database;
        global $lang;
        global $DOCUMENT_ROOT;

        // wyciagnij w bazy danych wszystkie transakcje do przelania do interia
        $data=$mdbd->select("order_id","order_register","confirm=1 AND confirm_partner=1 AND partner_name='interia'","","","array");
        // jesli sa jakies dane do wyslania
        if(!empty($data)) {
            // naglowek komunikatu soap
            $str=$this->_interia_get_head();
            // komunikat glowny
            $str.=$this->_interia_commit_roll_trans("CommitTransactions", $data);
            // stopka komunikatu soap
            $str.=$this->_interia_get_foot();
            // zapisz xml w pliku
            if($str) {
                $file=$DOCUMENT_ROOT."/tmp/commit.xml";
                if  ($fd=@fopen($file,"w+")) {
                    fwrite($fd,$str,strlen($str));
                    fclose($fd);
                }
            }
            //wyslij oferte na serwer
            $content=$this->soap->send_soap_category($str);

            // zapisz zwrotna informacje do bazy danych
            $this->_insert_info_db("CommitTransaction",'TRANS_ID');

            // sparsuj odpowiedz serwera interia
            $this->_interia_send_request($content,'trans');

            // zapisz zwrotna informacje do bazy danych
            $this->_insert_info_db("CommitTransaction",'TRANS_ID');
            // analizuj komunikat zwrotny i dodaj odpowiednie interiaisy do bazy danych
            foreach($this->_tags['TRANS_ID'] as $key=>$value) {
                $order_id=$this->_values[$this->_tags['TRANS_ID'][$key]]['value'];
                // zapisz informacje o tym ze transakcja zostala wyslana i potwiedzona w tablicy order_register
                if($this->_values[$this->_tags['RES'][$key]]['value'] == 0 ) {
                    // transakcja zostala poprawnie zalogowana
                    $mdbd->update("order_register","confirm_partner=?","order_id=?",array("3"=>"int",$order_id=>"int"));
                    print "<br>Transkacja <b>$order_id</b> zalogowana poprawnie";
                } else {
                    // transakcja nie zostala zalogowana poprawnie
                    $mdbd->update("order_register","confirm_partner=?","order_id=?",array("-1"=>"int",$order_id=>"int"));
                    print "<br>Transkacja <b>$order_id</b> zalogowana niepoprawnie.<font color=red><b> B³±d !!! </b></font>";
                }
            }
        }
        return true;
    } // end CommitTrans

    function RollbackTrans() {
        global $mdbd;
        global $database;
        global $lang;
        global $DOCUMENT_ROOT;

        // wyciagnij w bazy danych wszystkie transakcje do przelania do interia
        $data=$mdbd->select("order_id","order_register","confirm=1 AND confirm_partner=2 AND partner_name='interia'","","","array");
        // jesli sa jakies dane do wyslania
        if(!empty($data)) {
            // naglowek komunikatu soap
            $str=$this->_interia_get_head();
            // komunikat glowny
            $str.=$this->_interia_commit_roll_trans("RollbackTransactions", $data);
            // stopka komunikatu soap
            $str.=$this->_interia_get_foot();
            // zapisz xml w pliku
            if($str) {
                $file=$DOCUMENT_ROOT."/tmp/rollback.xml";
                if  ($fd=@fopen($file,"w+")) {
                    fwrite($fd,$str,strlen($str));
                    fclose($fd);
                }
            }
            //wyslij oferte na serwer
            $content=$this->soap->send_soap_category($str);
            // sparsuj odpowiedz serwera interia
            $this->_interia_send_request($content,'trans');

            // zapisz zwrotna informacje do bazy danych
            $this->_insert_info_db("RollbackTransaction",'TRANS_ID');

            // analizuj komunikat zwrotny i dodaj odpowiednie interiaisy do bazy danych
            foreach($this->_tags['TRANS_ID'] as $key=>$value) {
                $order_id=$this->_values[$this->_tags['TRANS_ID'][$key]]['value'];
                // zapisz informacje o tym ze transakcja zostala wyslana i potwiedzona w tablicy order_register
                if($this->_values[$this->_tags['RES'][$key]]['value'] == 0 ) {
                    // transakcja zostala poprawnie zalogowana
                    $mdbd->update("order_register","confirm_partner=?","order_id=?",array("3"=>"int",$order_id=>"int"));
                    print "Transkacja <b>$order_id</b> zalogowana poprawnie<br>";
                } else {
                    // transakcja nie zostala zalogowana poprawnie
                    $mdbd->update("order_register","confirm_partner=?","order_id=?",array("-1"=>"int",$order_id=>"int"));
                    print "Transkacja <b>$order_id</b> zalogowana niepoprawnie.<font color=red><b> B³±d !!! </b></font><br>";
                }
            }
        }
    } // end RollbackTrans
} // end class interiaTransaction

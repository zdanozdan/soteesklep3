<?php
/**
* Obsluga glowna klasa do kominkacji z wp
*
* @author  rdiak@sote.pl
* @version $Id: wp_transaction.inc.php,v 1.7 2004/12/20 18:03:02 maroslaw Exp $
* @package    pasaz.wp.pl
*/

require_once("include/wp/wp.inc.php");
include_once("include/metabase.inc");

class WpTransaction extends WP {


    /**
    * Konstruktor obiektu WpTransaction
    *
    * @return boolean true/false
    */
    function WpTransaction() {
        // wywolaj konstruktor obiektu rodzica.
        $this->WP();
        return true;
    } // end WpTransaction

    /**
    * Funkcja wysy³a trnasakcje do pasazu wp w momencie sfianalizowania zakupow w sklepie
    * i wyslania zamowienia. Ta transakcja musi jeszcze zostac potwierdzona lub wycofana z
    * poziomu panelu administracyjnego.
    *
    * @return boolean true/false
    */
    function SendTrans($order_id,$commit) {
        global $mdbd;
        global $lang;
        global $database;

        $record=array();
        $ids=array();
        // wyciagnij z sesji user_id produktów
        foreach($_SESSION['global_basket_data']['items'] as $key=>$value) {
            array_push($ids,$value['user_id']);
        }
        if(empty($ids)) {
            // jesli z sesji nie udalo sie wyciagnac user_id produktow
            // to sprobuj z bazy
            $ids=$mdbd->select("user_id_main","order_products","order_id=?",array($order_id=>"int"));
        }
        $record['order_id']=$order_id;
        if(!empty($_SESSION['global_basket_amount'])) {
            $record['price']=$_SESSION['global_basket_amount'];
        } else {
            $amount=$mdbd->select("amount","order_register","order_id=?",array($order_id=>"int"));
            $record['price']=$amount;
        }
        $record['price']=eregi_replace('\.',',',$record['price']);
        $record['commit']=$commit;
        // naglowek komunikatu soap
        $str=$this->_wp_get_head();
        // komunikat glowny
        $str.=$this->_wp_store_transaction($record, $ids);
        // stopka komunikatu soap
        $str.=$this->_wp_get_foot();
        //wyslij oferte na serwer
        $content=$this->soap->send_soap_category($str);
        // sparsuj odpowiedz serwera wp
        $this->_wp_send_request($content,'trans');

        // zapisz zwrotna informacje do bazy danych
        $this->_insert_info_db("StoreTransaction",'TRANS_ID');

        return true;
    } // end SendTransFromShop


    /**
    * Funkcja jest wywolywana z poziomu panelu administracyjnego
    * i wysy³a transakcje potwierdzone i anulowane do pasazu wp
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

        // wyciagnij w bazy danych wszystkie transakcje do przelania do wp
        $data=$mdbd->select("order_id","order_register","confirm=1 AND confirm_partner=1 AND partner_name='wp'","","","array");
        // jesli sa jakies dane do wyslania
        if(!empty($data)) {
            // naglowek komunikatu soap
            $str=$this->_wp_get_head();
            // komunikat glowny
            $str.=$this->_wp_commit_roll_trans("CommitTransactions", $data);
            // stopka komunikatu soap
            $str.=$this->_wp_get_foot();
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

            // sparsuj odpowiedz serwera wp
            $this->_wp_send_request($content,'trans');

            // zapisz zwrotna informacje do bazy danych
            $this->_insert_info_db("CommitTransaction",'TRANS_ID');
            // analizuj komunikat zwrotny i dodaj odpowiednie wpisy do bazy danych
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

        // wyciagnij w bazy danych wszystkie transakcje do przelania do wp
        $data=$mdbd->select("order_id","order_register","confirm=1 AND confirm_partner=2 AND partner_name='wp'","","","array");
        // jesli sa jakies dane do wyslania
        if(!empty($data)) {
            // naglowek komunikatu soap
            $str=$this->_wp_get_head();
            // komunikat glowny
            $str.=$this->_wp_commit_roll_trans("RollbackTransactions", $data);
            // stopka komunikatu soap
            $str.=$this->_wp_get_foot();
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
            // sparsuj odpowiedz serwera wp
            $this->_wp_send_request($content,'trans');

            // zapisz zwrotna informacje do bazy danych
            $this->_insert_info_db("RollbackTransaction",'TRANS_ID');

            // analizuj komunikat zwrotny i dodaj odpowiednie wpisy do bazy danych
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
} // end class WpTransaction

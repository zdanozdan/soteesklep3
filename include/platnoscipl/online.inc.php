<?php
/**
 * Funckje zwiazane z obsluga platnosciPl
 *
 * @author Robert Diak
 */

require_once ("HTTP/Client.php");
include_once ("config/auto_config/platnoscipl_config.inc.php");
include_once ("include/metabase.inc");

class PlatnosciPLOnline {

    var $_pos_id='';
    var $_session_id='';
    var $_ts='';
    var $_sig='';                       // otrzymany sig jako parametr
    var $_sig_compute='';               // obliczony numer sig
    var $_values='';
    var $_tags='';

    /**
     * Constructor
     */
    function PlatnosciPLOnline($order='') {
        global $_REQUEST;
        global $database;
        
        if(!empty($_REQUEST['pos_id'])) {
            $this->_pos_id=@$_REQUEST['pos_id'];
            $this->_session_id=@$_REQUEST['session_id'];
            $this->_ts=@$_REQUEST['ts'];
            $this->_sig=@$_REQUEST['sig'];
        } else {
            $this->_session_id=$database->sql_select("session_id","order_register","order_id=".$order);   
            $data=$database->sql_select_multi_array4(array("pos_id","sig","ts"),"platnoscipl_error","session_id=".$this->_session_id," LIMIT 1");
            $this->_pos_id=$data[0]['pos_id'];           
            $this->_sig=$data[0]['sig'];           
            $this->_ts=$data[0]['ts'];
        }
        return true;
    } // end constructor

    /**
     * Constructor
     */
    function action() {

        $this->_send_request();

        return true;
    } // end func action

    /**
     * Funkcja wysyla potwierdzenie requesta po kazdej zmianie statusu transakcji.
     */
    function _send_request() {
        global $platnoscipl_config;

        // jesli pos_id zawiera inne znaki niz cyfry to
        if(!preg_match("/^\d+$/",$this->_pos_id)) {
            $this->_save_error("Nieprawidlowy pos_id");
            return false;
        }
        if(!preg_match("/^\w{32}$/",$this->_session_id)) {
            $this->_save_error("Nieprawidlowy numer sesji");
            return false;
        }
        $this->_sig_compute=md5($this->_pos_id.$this->_session_id.$this->_ts.$platnoscipl_config->pl_md5_two);
        if($this->_sig_compute == $this->_sig) {
            // jesli podpisy sie zgadzaja to sprawdamy status transakcji
            if($this->_check_status()) {
                $this->_save_error("Wszystko OK");
                print "OK";
            } else {
                $this->_save_error("B³±d");
            }
        } else {
            $this->_save_error("niezgodne sygnatury");
        }
        return true;
    } // end func _send_request

    /**
     * Funkcja sprawdza status transakcji
     *
     * 
     */
    function _check_status() {
        global $platnoscipl_config;
        global $database;

        $order_id=$database->sql_select("order_id","order_register","session_id=$this->_session_id");
        
        $sig=md5($this->_pos_id.$this->_session_id.$this->_ts.$platnoscipl_config->pl_md5_one);

        //$this->_save_error("",$this->_session_id."::".$order_id);

        // pobierz status transakcji
        $http =& new HTTP_Client;
        $res=$http->post("https://www.platnosci.pl/paygw/ISO/Payment/get/txt",array(
                                                                    "pos_id"=>$this->_pos_id,
                                                                    "session_id"=>$this->_session_id,
                                                                    "ts"=>$this->_ts,
                                                                    "sig"=>$sig,
                                                                    )
                   );

        $result=$http->_responses[0]['body'];

        if(preg_match("/trans_status: 1/",$result)) {
            // ustaw kwadracik pomaranczowy
            /*$database->sql_update("order_register","order_id=".$order_id,array(
        														"pay_status"=>'000'
																)
						);*/
            $this->_save_error('status 1');
            $result="transakcja nowa";
        }
        if(preg_match("/trans_status: 2/",$result)) {
            $result="transakcja anulowana";
            $this->_save_error('status 2');
        }
        if(preg_match("/trans_status: 3/",$result)) {
            $result="transakcja odrzucona";
            $this->_save_error('status 3');
        }
        if(preg_match("/trans_status: 4/",$result)) {
           /*$database->sql_update("order_register","order_id=".$order_id,array(
        														"pay_status"=>'000'
																)
						);*/
           $this->_save_error('status 4');
            $result="transakcja rozpoczeta";
        }
        if(preg_match("/trans_status: 5/",$result)) {
            $result="oczekuje na odbior";
            $this->_save_error('status 5');
        }
        if(preg_match("/trans_status: 6/",$result)) {
            $result="autoryzacja odmowna";
            $this->_save_error('status 6');
        }
        if(preg_match("/trans_status: 99/",$result)) {
           $database->sql_update("order_register","order_id=".$order_id,array(
             													"confirm_online"=>"1",
                                                                "pay_status"=>"001",
                                                                "confirm"=>"1",
																)
						);
			$this->_save_error("status 99 [ $order_id ]");
            $result="p³atnosc odebrana";
        }
        if(preg_match("/trans_status: 888/",$result)) {
            $result="bledny status";
            $this->_save_error('status 888');
        }
        $res=serialize($res);
        $this->_save_error('',$res);
        $this->_save_error("",$result);
        return true;
    } // end func _check_status

    /**
     * Zapisz informacje o requescie do bazy danych
     *
     * @param $error string opis bledu
     */
    function _save_error($error='',$string='') {
        global $database;
        $database->sql_insert("platnoscipl_error",array(
        "pos_id"=>$this->_pos_id,
        "session_id"=>$this->_session_id,
        "ts"=>$this->_ts,
        "sig"=>$this->_sig,
        "sig_compute"=>$this->_sig_compute,
        "error"=>$error,
        "string"=>$string,
        )
        );
        return false;
    } // end fun _save_error
} // end class PlatnosciPLOnline
?>

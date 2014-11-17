<?php
/**
 * Obsluga sciagania kategorii z onet_pasaz
 * 
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_transaction.inc.php,v 1.5 2005/09/02 08:24:38 lukasz Exp $
* @package    include
 */


/**
 * Includowanie potrzebnych klas 
 */
require_once("include/onet/soap.inc.php");
require_once ("config/auto_config/onet_config.inc.php");

/**
 * Klasa OnetTrans
 *
 * @package onet
 * @subpackage admin
 */
class OnetTrans extends SOAP{
    var $onet_shop_id='';   
    
    /**
     * Konstruktor obiektu OnetTrans 
     *
     * @access public
     *
     * @author rdiak@sote.pl
     *
     * @return boolean true/false
     */
    function OnetTrans() {
        global $onet_config;

        $this->onet_shop_id=$onet_config->onet_shop_id;
        $this->SOAP();
        return true;
    } // end OnetTrans
    
    /**
     * Funkcja pobiera z bazy danych teansakcje do potwierdzenia w onet_pasaz. 
     *
     * @author rdiak@sote.pl
     *
     * @return P
     */
    function & load_trans_admin() {
        global $db;
        $transaction=array();
        $query="SELECT id,order_id,amount FROM order_register WHERE confirm=1 AND confirm_partner=1 AND partner_name='onet'";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                //print $num_rows;
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $data=array();
                        $data['id']=$db->FetchResult($result,$i,"id");
                        $data['transactionId']=$db->FetchResult($result,$i,"order_id");
                        $data['amount']=$db->FetchResult($result,$i,"amount");
                        $data['amount']=$this->compute_amount($data['amount']);
                        $data['shopId']=$this->onet_shop_id;
                        $data['currency']='PLN';
                        $data['type']='2';
                        //print_r($data);
                        array_push ($transaction, $data);
                    } // end for
                }
            } else die ($db->Error());
        } else die ($db->Error());
        $data=&$transaction;
        return $data;
    } // end load_trans

     /**
     * Funkcja wysy³a do Onetu informacje o transakcji w momencie wyslania zamowienia
     *
     * @author rdiak@sote.pl
     *
     * @return 
     */
    function & load_trans_pre($order_id) {
        global $mdbd;

        $transaction=array();
        $db_data=$mdbd->select("id,amount","order_register","order_id=?",array($order_id=>"int"));
        $data=array();
        $data['id']=$db_data['id'];
        $data['transactionId']=$order_id;
        $data['amount']=$this->compute_amount($db_data['amount']);
        $data['shopId']=$this->onet_shop_id;
        $data['currency']='PLN';
        $data['type']='1';
	    array_push ($transaction, $data);
        $data=&$transaction;
        return $data;
    } // end load_trans

    /**
     * Funkcja wysy³a tansakcje do potwierdzenia w onet_pasaz. 
     *
     * @access public
     *
     * @author rdiak@sote.pl
     *
     * @return boolean true/false
     */
    function send_trans($type,$order_id='') {
        global $lang;
        global $mdbd;

        // wstepne potwierdzenie transakcji do onet pasaz
        if( $type == 1) {
        	$data=$this->load_trans_pre($order_id);
        // wysylanie potwierdzenia transakcji z admina
        } elseif( $type == 2) {
         	$data=$this->load_trans_admin();
        }	
        //print_r($data);
        if(!empty($data)) {
            foreach ($data as $value) {
                $id=$value['id'];
                $str=$this->send_transaction($value);
                //print $str;
                if (eregi("PASAZ_TRANSACTION_LOGGED OK",$str)){
                    if( $type == 2) {
                		print $this->encoding_utf8_to_8859_2($str);
                    	$mdbd->update("order_register","confirm_partner=?","id=?",array("2"=>"int",$id=>"int"));
                    }
                } elseif (eregi("PASAZ_TRANSACTION_LOGGED ERROR",$str)) {
                    if( $type == 2) {
                 		print $this->encoding_utf8_to_8859_2($str);
                    	$mdbd->update("order_register","confirm_partner=?","id=?",array("-1"=>"int",$id=>"int"));
                    }
                  	$mdbd->insert("onet_error","error,action","?,?",array($str=>"text","B³±d podczas wysy³ania transakcji"=>"text"));
                }
            }
        } 
        return true;
    } // end send_trans

   	function compute_amount($amount) {
        $price=$amount;
		$price=number_format($price,2,".","");
        return intval($price*100);
	} // end  compute_amount

} // end class OnetTrans
?>

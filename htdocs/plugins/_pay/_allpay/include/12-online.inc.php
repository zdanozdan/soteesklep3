<?php
/**
 * Klasa do potwierdzen platnosci w tle z serwisu allpay
 *
 */
class AllpayOnline {

    /**
	 * Konstruktor klasy
	 *
	 * @return AllpayOnline
	 */
    function AllpayOnline() {
		if($this->checkParam()) {
			if($this->prepareData()) {
								
			}
		}
    	
    } // end func AllpayOnline

    /**
	 * Zapisz parametry do bazy danych
	 *
	 */
    function checkParam()
    {
        global $_REQUEST;
        global $database;
        foreach($_REQUEST as $key=>$value) {
            $_REQUEST[$key]= addslashes($_REQUEST[$key]);
        }
        $database->sql_insert("allpay_trans",$_REQUEST);
    	return true;
    } // end func checkParam
	
    /**
     * Sprawdz trenaskacje
     *
     */
    function prepareData()
    {
    	global $database;
    	global $allpay_config;
    	
    	$data=$database->sql_select_multi_array4("*","order_register","order_id=".$_REQUEST['description']);
    	
    	$amount=$data[0]['amount']+$data[0]['delivery_cost'];
        //$md5=md5(":10045:b03337e6e90a9dc291d528d113cdf3c3:10045-P12:70:fsd@fsdfsd.pl:::::1");
		$md5=md5(
					@$allpay_config->allpay_pin.":".
					$allpay_config->allpay_id.":".
					$_REQUEST['control'].":".
					$_REQUEST['t_id'].":".
					$amount.":".
					$_REQUEST['email'].":".
					@$_REQUEST['service'].":".
					@$_REQUEST['code'].":".
					@$_REQUEST['username'].":".
					@$_REQUEST['password'].":".
					$_REQUEST['t_status']
				);
		if($md5 == $_REQUEST['md5']) {
			// jesli skroty sa dobre tzn ze transakcja jest prawidlowa 			
			require_once ("include/order_register.inc");
			$my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],1,$data[0]['amount']);
			$database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
																	"confirm_online"=>"1",
																	"pay_status"=>"001",
																	"checksum_online"=>$my_checksum,
																	)
									);
			$result_online=$database->sql_select("confirm_online","order_register","order_id=".$_REQUEST['description']);
			if($result_online == 1) {
				print "OK";
			} else {
				print "ERROR";
			}
		} else {
			// cos jest nie tak z transakcja
		}
    } // end func prepareData
} // end class AllpayOnline
?>
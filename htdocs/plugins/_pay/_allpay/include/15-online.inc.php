<?php
/**
 * Klasa do potwierdzen platnosci w tle z serwisu allpay
 *
 */


define ("ALLPAY_SERVER","217.17.41.5");

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
		if(!preg_match("/\./")) {
			$amount=$amount.".00";
		}
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

		$database->sql_insert("allpay_trans",array(
													"control"=>@$_REQUEST['control'],
													"t_id"=>@$_REQUEST['t_id'],
													"order_id"=>@$_REQUEST['description'],
													"amount"=>$amount,
													"email"=>@$_REQUEST['email'],
													"service"=>@$_REQUEST['service'],
													"code"=>@$_REQUEST['code'],
													"username"=>@$_REQUEST['username'],
													"password"=>@$_REQUEST['password'],
													"t_status"=>$_REQUEST['t_status'],
													"md5"=>$md5,
													"md5_req"=>$_REQUEST['md5'],
													"orginal_amount"=>$_REQUEST['amount'],
													"remote_addres"=>$_SERVER["REMOTE_ADDR"]
													)
		);

		// transakcja nowa lub odmowna
		if($md5 == $_REQUEST['md5'] && ($_REQUEST['t_status'] == 1 || $_REQUEST['t_status'] == 3) && $_SERVER["REMOTE_ADDR"] == ALLPAY_SERVER) {
				print "OK";
		}
		// potwierdzenie trasakcji
		if($md5 == $_REQUEST['md5'] && $_REQUEST['t_status'] == 2 && $_SERVER["REMOTE_ADDR"] == ALLPAY_SERVER) {
			// jesli skroty sa dobre tzn ze transakcja jest prawidlowa
			require_once ("include/order_register.inc");
			$my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],1,$data[0]['amount']);
			$database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
								"confirm_online"=>"1",
								"confirm"=>"1",
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
		} 
	} // end func prepareData
} // end class AllpayOnline
?>

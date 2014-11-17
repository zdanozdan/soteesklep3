<?php
/**
* Klasa do obslugi platnosci payPal
*
* @version $Id: paypal.inc.php,v 1.5 2006/04/24 09:56:17 lukasz Exp $
* @package soteesklep payPal
*/
include_once("include/metabase.inc");
require_once ("include/price.inc");

class payPal {
	
	var $amount='';
	var $order_id='';
	var $auth_response='';
	var $approved='';	
	var $transid='';
	var $sess_id='';
	/**
	 * Konstruktor obiektu payPal ustwia potrzebne parametry.
	 *
	 */
	function payPal() {
		global $_SESSION;
		global $payPal_config;
		global $sess;
		global $config;
		global $shop;
		$amount=@$_SESSION['global_order_amount'];
		$get_id_currency=$_SESSION['__currency'];
		$get_id_USD_currency=array_search("USD",$config->currency_name);
		$shop->currency();
		$amount_currency=$shop->currency->change($amount,2,$get_id_USD_currency);
		$amount_currency=round($amount_currency,2);
		$this->amount=$amount_currency;
		$this->order_id=@$_SESSION['global_order_id'];
		return true;
	} // end func payPal()
	
	/**
	 * Funkcja odbiera dane po poprawnym zakonczeniu transakcji w payPal
	 */
	function _payPalGetRequestBad() {
		global $_REQUEST;
		if(! empty($_REQUEST['ID'])) {
			$this->order_id=$_REQUEST['ID'];
		} else return false;
		return true;
	} // end func _payPalGetRequestOk
	
	/**
	 * Funkcja odbiera dane po blednym zakonczeniu transakcji w payPal
	 */
	function _payPalGetRequestOk() {
		global $_REQUEST;
		if(! empty($_REQUEST['ID'])) {
			$this->order_id=$_REQUEST['ID'];
		} else return false;
		return true;
	} // end func _payPalGetRequestBad

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function payPalGetOk() {
		global $database;
		global $lang;
		// zmienna ktora okresla status operacji
		// domyslnie niepowodzenie czyli 0
		$status=0;
		// obierz dane z payPal
		if($this->_payPalGetRequestOk() == 'true') {
			//parmetry odebrane poprawnie
			//oblicz sume kontrolna
			$count=$database->sql_select("count(*)","order_register","order_id=$this->order_id");
			if($count > 0) {
				// order_id nie istnieje w bazie danych
				$result=$database->sql_insert("paypal",array(
														"order_id"=>$this->order_id,
														"payer_id"=>$_REQUEST['payer_id'],
														"payer_email"=>$_REQUEST['payer_email'],
														"txn_id"=>$_REQUEST['txn_id'],
														"payment_type"=>$_REQUEST['payment_type'],
														"receiver_email"=>$_REQUEST['receiver_email'],
														"payment_gross"=>$_REQUEST['payment_gross'],
														"sess_id"=>$_REQUEST['sess_id'],
														"receiver_id"=>$_REQUEST['receiver_id'],
														)
											);
				// transakcja zapisana poprawnie w bazie danych
				// notujemy w tablicy order_register ze tranaskacja zostala sfinalizowana
				// obliczamy sume kontrolna transakcji i zapsiujemy ja do bazy danych
				$database->sql_update("order_register","order_id=$this->order_id",array(
																	"confirm_online"=>"1",
																	"pay_status"=>"001",
																	"confirm"=>"1",
																	)
																);
						
				// sprawdzamy czy dane zostaly zapisane w bazie danych
				$result_online=$database->sql_select("confirm_online","order_register","order_id=$this->order_id");
				if($result_online == 1) {
					$status=1;
					print "<br><center>".$lang->paypal_trans_ok."</center><br><br>";
					//$this->_payPal_clear_basket();
				} else {
					print "<br><center>".$lang->paypal_error_db."</center><br><br>";
				}
			} else {
				$error=$lang->paypal_no_save_db;
				print "<br><center>".$lang->paypal_orderid_noexists."</center><br><br>";
				//nie udalo sie zapisac tansakcji w bazie danych
			}
		} else {
			// parametry odebrane niepoprawnie
			$error=$lang->paypal_req_error;
			print "<br><center>".$lang->paypal_req_error."</center><br><br>";
		}
		return true;
	} // end func payPalGetOk
	
	/**
	* G³ówna funkcja wywolywana wtedy gdy przyjdzie b³êdna odpowiedz z payPal
	*
	*/
	function payPalGetError() {
		global $lang;
		// czy paramatry zosta³y przekazane prawidlowo ?
		if($this->_payPalGetRequestBad() == 'true') {
			print "<br><center>".$lang->paypal_not_pay."<br><br>";
      		print "<b><a href=/go/_register/register2.php>".$lang->paypal_choose_pay_method."</a></b><br><br><center>";
		} else {
			// parametry odebrane niepoprawnie
			print "<br><center>".$lang->paypal_req_error."</center><br><br>";
		}
		return false;
	} // end func payPalGetError
	
	/**
	* G³ówna funkcja do tworzenia platnosci payPal
	*
	*/
	function payPalPay() {
		$str=$this->_payPalPutForms();
		return $str;
	} // end func payPalPay
	
	/**
	* Funkcja tworzy opis transakcji przekazywany do payPal
	*
	*/
	function _payPalGetDescription($desc='') {
		$description=$this->order_id;
		//$description.="|".$desc;
		return $description;
	} // end func _payPalGetDescription
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function _payPalShipping() {
		$shipping=0;
		return $shipping;
	} // end func _payPalShipping

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function _payPalCurrency() {
		global $shop;
		global $config;
		$shop->currency();
		$currency=$shop->currency->currency;
		if(empty($currency)) {
			$currency=$config->currency_name[$config->currency_lang_default[$config->lang]];
		}
		return $currency;
	} // end func _payPalShipping
	 
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function _amount() {
        global $shop;
        global $_SESSION;
        $my_price = new MyPrice;
        //$shop->currency();
        return $shop->currency->price($my_price->promotionsAmount($_SESSION['global_order_amount']));
	} // end func _payPalShipping

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function _checkLang() {
        global $_SESSION;
        global $config;
        if(empty($_SESSION['global_lang'])) {
            $local_lang='en';
        } else {
            $local_lang=$_SESSION['global_lang'];
        }

        if (in_array("multi_lang",$config->plugins)) {
      	 while(list($key, $lang_name) = each($config->languages)){
      		if (@$config->lang_active[$lang_name]==1) {
      		    if($local_lang == $lang_name) {
      		        return $lang_name;
      		    }
      	     }
            } 	    
        }	        
	} // end func _payPalShipping
	
	/**
	* Generowanie formatki do przekierowania uzytkownika do payPal
	*
	* return $string formatka ktora trzeba wyswietlic
	*/
	function _payPalPutForms() {
		global $_SESSION;
		global $paypal_config;
		global $lang;
		global $config;
		
		//print "<pre>";
		//print_r($_SESSION);
		//print "</pre>";
		$url="http://".$config->www."/".$paypal_config->payPalReturnUrl;
		$str='';
		// jesli PayPal jest w trybie produkcyjnym wez serwer produkcyjny
		if(!empty($paypal_config->payPalStatus)) {
			$str.="<form name=\"checkout_confirmation\" action=\"".$paypal_config->payPalServerUrl."\" method=\"post\">\n";
		} else {
			// jesli jest w trybie testowym wez serwer testowy
			$str.="<form name=\"checkout_confirmation\" action=\"".$paypal_config->payPalServerTestUrl."\" method=\"post\">\n";
		}	
		$str.="<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n";
		$str.="<input type=\"hidden\" name=\"business\" value=\"".$paypal_config->payPalAccount."\">\n";
		$str.="<input type=\"hidden\" name=\"item_name\" value=\"".$paypal_config->payPalCompany."\">\n";
		$str.="<input type=\"hidden\" name=\"amount\" value=\"".$this->_amount()."\">\n";
		$str.="<input type=\"hidden\" name=\"order_id\" value=\"".$_SESSION['global_order_id']."\">\n";
		$str.="<input type=\"hidden\" name=\"country\" value=\"".$this->_checkLang()."\">\n";
		
		$str.="<input type=\"hidden\" name=\"shipping\" value=\"".$this->_payPalShipping()."\">\n";
		$str.="<input type=\"hidden\" name=\"currency_code\" value=\"".$this->_payPalCurrency()."\">\n";
		$str.="<input type=\"hidden\" name=\"return\" value=\"".$url."\">\n";
		$str.="<input type=\"hidden\" name=\"cancel_return\" value=\""."http://".$config->www."/".$paypal_config->payPalCancelReturnUrl."?ID=".$_SESSION['global_order_id']."\">\n";
		$str.="<input type=\"submit\" value=\"$lang->register_paypal_payment\">\n";
		$str.="</form>\n";
		return $str;
	} // end func _payPalPutForms
} //end class payPal
?>

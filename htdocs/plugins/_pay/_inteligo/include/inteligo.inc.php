<?php
/**
* Klasa do obslugi platnosci Inteligo
*
* @author  rdiak@sote.pl
* @version $Id: inteligo.inc.php,v 1.6 2004/12/20 18:02:05 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/

global $__secure_test;
if (@$__secure_test!=true) die ("Forbidden");

require_once ("include/metabase.inc");
require_once ("include/my_crypt.inc");
require_once ("include/order_register.inc");

class Inteligo {
	// \@global object $inteligo_config konfiguracja systemu inteligo
	
	var $merchant_id='';            // identyfikator patrnera nadawany przez Inteligo
	var $amount='';                 // wartosc tranaskacji
	var $amount_org='';             // oryginalna wartosc transakcji
	var $currency='';               // waluta transkacji
	var $descripion='';             // opis tranaskacji
	var $custom_param='';           // identyfikator tranasakcji
	var $secret_key='';             // sekretny klucz nadawany sprzedawcy przez Inteligo
	var $TxID='';                   // unikalny identyfikator transakacji otrzymywany od Inteligo
	var $control_data='';           // aktualna dla danej transakcji suma kontrolna otrzymana z Inteligo
	var $coding='';                 // sposob szyfrowania tranasakcji
	var $pay_method='';             // tryb wykonywania platnosci Ipay2
	var $min_amount="1";			// minimalna warto¶æ zamówienia
	var $max_amount="4000";			// maksymalna warto¶æ zamówienia
	var $lock='';					// sposób blokowania transakcji 
	
	/**
	* Konstruktor obiektu Inteligo ustwia potrzebne parametry.
	*
	* @access public
	* @return bool
	*/
	function Inteligo() {
		global $_SESSION;
		global $inteligo_config;
		
		$this->merchant_id=$inteligo_config->inteligo_merchant_id;
		$this->amount=$this->_InteligoComputeAmount(@$_SESSION['global_order_amount']);
		$this->amount_org=@$_SESSION['global_order_amount'];
		$this->currency=$inteligo_config->inteligo_currency;
		$this->custom_param=$this->_InteligoGetOrderId(@$_SESSION['global_order_id']);
		$this->description=$this->_InteligoGetDescription($inteligo_config->inteligo_info);
		$this->secret_key=$this->_InteligoDecodeSecretKey($inteligo_config->inteligo_key);
		$this->coding=$inteligo_config->inteligo_coding;
		$this->pay_method=$inteligo_config->inteligo_pay_method;
		$this->lock=$inteligo_config->inteligo_lock;
		
		return true;
	} // end Inteligo()
	
	/**
	* Funkcja odbiera dane po zakonczeniu transakcji w Inteligo
	*
	* @access private
	* @return boolean true/false
	*/
	function _inteligoGetRequest() {
		global $_REQUEST;
		
		if(! empty($_REQUEST['MerchantID'])) {
			$this->merchant_id=$_REQUEST['MerchantID'];
		} else return false;
		if(! empty($_REQUEST['Amount'])) {
			$this->amount=$_REQUEST['Amount'];
		} else return false;
		if(! empty($_REQUEST['Currency'])) {
			$this->currency=$_REQUEST['Currency'];
		} else return false;
		if(! empty ($_REQUEST['Description'])) {
			$this->description=$_REQUEST['Description'];
		} else return false;
		if(! empty ($_REQUEST['CustomParam'])) {
			$this->custom_param=$_REQUEST['CustomParam'];
		} else return false;
		if(! empty ($_REQUEST['TxID'])) {
			$this->TxID=$_REQUEST['TxID'];
		} else return false;
		if(! empty ($_REQUEST['ControlData'])) {
			$this->control_data=$_REQUEST['ControlData'];
		} else return false;
		
		return true;
	} // end _inteligoGetRequest()
	
	/**
	* Funkcja tworzy sume kontrolna w zaleznosci od wybranego sposobu kodowania
	*
	* @param string $str  
	*
	* @access private
	* @return string $crc suma kontrolna
	*/
	function _inteligoCodingStr($str) {
		if($this->coding == 'md5') {
			$crc=md5($str);
		} elseif($this->coding == 'sha1') {
			$crc=md5($str);
		} else {
			$crc=$str;
		}
		return $crc;
	} // end _inteligoCodingStr()
	
	/**
	* G³ówna funkcja zarzadzania transakcja ktora zostala poprawnie zutoryzowana przez Inteligo
	*
	* @access public
	* @return bool
	*/
	function inteligoGetOk() {
		global $database;
		global $lang;
		// zmienna ktora okresla status operacji
		// domyslnie niepowodzenie czyli 0
		$status=0;
		// obierz dane z Inteligo
		if($this->_inteligoGetRequest() == 'true') {
			//parmetry odebrane poprawnie
			//oblicz sume kontrolna
			$crc=$this->_inteligoComputeBack();
			//print "$crc - $this->control_data";
			$this->control_data=trim($this->control_data);
			if($crc == $this->control_data) {
				$count=$database->sql_select("count(*)","inteligo","txid=$this->TxID");
				if($count > 0) {
					// txid juz istnieje w bazie danych
					$error=$lang->inteligo_txid_exists;
					print "<br><center>".$lang->inteligo_trans_error."</center><br><br>";
				} else {
					// txid nie istnieje w bazie danych
					$result=$database->sql_insert("inteligo",array(
											"txid"=>$this->TxID,
											"order_id"=>$this->custom_param,
											"ip"=>$_SESSION['REMOTE_ADDR'],
											"date_add"=>date("YmdHis"),
											"amount"=>$this->amount,
											"amount_org"=>$this->_InteligoComputeOrgAmount(),
											)
										);
					$count=$database->sql_select("count(*)","inteligo","txid=$this->TxID");
					if($count > 0) {
						// transakcja zapisana poprawnie w bazie danych
						// notujemy w tablicy order_register ze tranaskacja zostala sfinalizowana
						// obliczamy sume kontrolna transakcji i zapsiujemy ja do bazy danych
						require_once ("include/order_register.inc");
						$my_checksum=OrderRegisterChecksum::checksum($this->custom_param,1,$this->amount_org);
						if($this->lock == 'zero' ) {
							$pay_status='001';
						} else {
							$pay_status='451';
						}
						$database->sql_update("order_register","order_id=$this->custom_param",array(
																	"confirm_online"=>"1",
																	"pay_status"=>$pay_status,
																	"checksum_online"=>$my_checksum,
																	)
									);
						// sprawdzamy czy dane zostaly zapisane w bazie danych
						$result_online=$database->sql_select("confirm_online","order_register","order_id=$this->custom_param");
						if($result_online == 1) {
							$status=1;
							print "<br><center>".$lang->inteligo_trans_ok."</center><br><br>";
						} else {
							print "<br><center>".$lang->inteligo_error_db."</center><br><br>";
						}
					} else {
						$error=$lang->inteligo_no_save_db;
						print "<br><center>".$lang->inteligo_no_save_db."</center><br><br>";
						//nie udalo sie zapisac tansakcji w bazie danych
					}
				}
			} else {
				// nieprawidlowa suma kontrolna
				$error=$lang->inteligo_crc_error;
				print "<br><center>".$lang->inteligo_crc_error."</center><br><br>";
			}
		} else {
			// parametry odebrane niepoprawnie
			$error=$lang->inteligo_req_error;
			print "<br><center>".$lang->inteligo_req_error."</center><br><br>";
		}
		if($status == 0) {
			$result=$database->sql_insert("inteligo_error",array(
										"txid"=>$this->TxID,
										"order_id"=>$this->custom_param,
										"error"=>@$error,
										)	
							);
			return false;
		} else {
			return true;
		}
		return true;
	} // end inteligoGetOk()
	
	
	/**
	* G³ówna funkcja wywolywana wtedy gdy przyjdzie b³êdna odpowiedz z Inteligo
	*
	* @access public
	* @return bool
	*/
	function inteligoGetError() {
		global $lang;
		print "<br><center>".$lang->inteligo_not_pay."</center><br><br>";
		return true;
	} // end inteligoGetError()
	
	/**
	* G³ówna funkcja do tworzenia platnosci Inteligo
	*
	* @access public
	* @return string $str
	*/
	function inteligoPayInteligo() {
		$str=$this->_InteligoPutForms();
		return $str;
	} // end inteligoPayInteligo()
	
	/**
	* Funkcja oblicza sume kontrolna dla powrotnego requestu z Inteligo
	*
	* @access private
	* @return string $crc suma kontrolna
	*/
	function _inteligoComputeBack() {
		$str=$this->merchant_id."&".$this->amount."&".$this->currency."&";
		$str.=$this->description."&".$this->custom_param."&";
		$str.=$this->TxID."&".$this->secret_key;
		$crc=$this->_InteligoCodingStr($str);
		print "<font color=white>$crc</font>";
		return $crc;
	} // end _inteligoComputeBack()
	
	/**
	* Funkcja pakuje do postaci binarnej tajny klucz
	*
	* @param string $key klucz do zakodowania
	*
	* @access private
	* @return string $keys klucz w postaci binarnej
	*/
	function _inteligoDecodeSecretKey($key) {
		$my_crypt=new MyCrypt;
		$key=$my_crypt->endecrypt("",$key,"de");
		$tab=split(":",$key);
		$keys=pack("H*",$tab[0]);
		return $keys;
	} // end _inteligoDecodeSecretKey
	
	/**
	* Funkcja tworzy opis transakcji przekazywany do inteligo
	*
	* @param string $desc opis transakcji 
	*
	* @access private
	* @return string $description opis transakcji
	*/
	function _inteligoGetDescription($desc='') {
		$description=$this->custom_param;
		$description.="|".$desc;
		return $description;
	} // end _inteligoGetDescription
	
	/**
	* Zamiana wartosci zamowiebnia na grosze
	*
	* @param string $amount wartosc transakcji
	*
	* @access private
	* @return int wartosc zamowienia w groszach
	*/
	function _inteligoComputeAmount($amount) {
		$price=$amount;
		$price=number_format($price,2,".","");
		return intval($price*100);
	} // end _inteligoComputeAmount()
	
	/**
	* Zamiana wartosci zamowiebnia na zlotowki z groszy
	*
	* @access private
	* @return int wartosc zamowienia w groszach
	*/
	function _inteligoComputeOrgAmount() {
		if(empty($this->amount_org)) {
			$price=$amount;
			$price=number_format($price,2,".","");
			return intval($price/100);
		} else return $this->amount_org;
	} // end _inteligoComputeOrgAmount()
	
	/**
	* Funkcja pobiera identyfikator transakcji
	*
	* @param string $order_id identyfikator transakcji
	*
	* @access private
	* @return int $order identyfikator transkacji
	*/
	function _inteligoGetOrderId($order_id) {
		if (! empty($order_id)) {
			$order=$order_id;
		}
		if ((empty($order)) && (! empty($global_order_id))) {
			$order=$global_order_id;
		}
		return @$order;
	} // end _inteligoGetOrderId()
	
	/**
	* Generowanie sumy kontolnej dodatkowego zabezpieczenia transakcji
	*
	* @access private
	* return $string obliczona suma kontrolna
	*/
	function _inteligoPutCrc() {
		$str=$this->merchant_id."&".$this->amount."&".$this->currency."&";
		$str.=$this->description."&".$this->custom_param."&".$this->secret_key;
		$crc=$this->_InteligoCodingStr($str);
		return $crc;
	} // end _inteligoPutCrc()
	
	/**
	* Generowanie formatki do przekierowania uzytkownika do inteligo
	*
	* @access private
	* return $string formatka ktora trzeba wyswietlic
	*/
	function _inteligoPutForms() {
		global $_SESSION;
		global $inteligo_config;
		// sprawdz czy nie przekroczono maksymalnej kwoty transakcji karta
		if ($this->amount>($this->max_amount*100)) {
			$o=" <font color=red>Niestety transakcji nie mo¿na rozliczyæ kart±.<BR>
	        	 Maksymalna kwota rozliczenia kart± przez Internet to
    		 	$this->max_amount PLN</font>";
			return $o;
		}
		
		// sprawdz czy nie przekroczono minimalnej kwoty transakcji karta
		if ($this->amount<($this->min_amount*100)) {
			$o=" <font color=red>Niestety transakcji
	    	     nie mo¿na rozliczyæ kart±.<BR>
                 Minimalna kwota rozliczenia kart± przez Internet to
				 $this->min_amount PLN</font>";
			return $o;
		}
		$str='';
		$str.="<form METHOD='POST' ACTION='".$inteligo_config->inteligo_server."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='MerchantID' VALUE='".$inteligo_config->inteligo_merchant_id."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Type' VALUE='".$inteligo_config->inteligo_pay_method."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Amount' VALUE='".$this->_inteligoComputeAmount($_SESSION['global_order_amount'])."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Currency' VALUE='".$this->currency."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Description' VALUE='".$this->description."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='CustomParam' VALUE='".$this->_inteligoGetOrderId($_SESSION['global_order_id'])."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='ControlData' VALUE='".$this->_inteligoPutCrc() ."'>\n";
		$str.="<center><input TYPE='SUBMIT' VALUE='P³acê z Inteligo: ".$_SESSION['global_order_amount']." z³'></center>\n";
		$str.="</form>\n";
		return $str;
	} // end _inteligoPutForms
} //end class Inteligo
?>

<?php
/**
* Klasa do obslugi platnosci mBank
*
* @version $Id: mbank.inc.php,v 1.4 2004/12/20 18:02:06 maroslaw Exp $
* @package    pay
* @subpackage mbank
*/
include_once("include/metabase.inc");
include_once("include/pay_crc.inc.php");
include_once("mbank_mail.inc.php");

class mBank {
	
	var $merchant_id='';
	var $amount='';
	var $descripion='';
	var $order_id='';
	var $tr_date='';
	var $session_id='';            //aktualna dla danej transakcji suma kontrolna otrzymana z mbank
	
	/**
	* Konstruktor obiektu mBank ustwia potrzebne parametry.
	*
	*/
	function mBank() {
		global $_SESSION;
		global $mbank_config;
		global $sess;
		
		$this->merchant_id=$mbank_config->mbank_merchant_id;
		$this->amount=@$_SESSION['global_order_amount'];
		$this->descripion=$this->_mBankGetDescription($mbank_config->mbank_info);
		$this->order_id=@$_SESSION['global_order_id'];
		$this->tr_date=date("Ymd");
		$this->session_id=$sess->id;
		$this->crc=  & new PayCrc();
		return true;
	} // end func mBank()
	
	/**
	* Funkcja odbiera dane po poprawnym zakonczeniu transakcji w mbank
	*
	*/
	function _mBankGetRequestOk() {
		global $_REQUEST;
		
		if(! empty($_REQUEST['ServiceID'])) {
			$this->merchant_id=$_REQUEST['ServiceID'];
		} else return false;
		if(! empty($_REQUEST['Amount'])) {
			$this->amount=$_REQUEST['Amount'];
		} else return false;
		if(! empty ($_REQUEST['Description'])) {
			$this->descripion=$_REQUEST['Description'];
		} else return false;
		if(! empty ($_REQUEST['TrDate'])) {
			$this->tr_date=$_REQUEST['TrDate'];
		} else return false;
		if(! empty ($_REQUEST['SessionID'])) {
			$this->session_id=$_REQUEST['SessionID'];
		} else return false;
		if(! empty ($_REQUEST['OrderID'])) {
			$this->order_id=$_REQUEST['OrderID'];
		} else return false;
		return true;
	} // end func _mBankGetRequestOk
	
	/**
	* Funkcja odbiera dane po blednym zakonczeniu transakcji w mbank
	*
	*/
	function _mBankGetRequestBad() {
		global $_REQUEST;
		if(! empty($_REQUEST['ServiceID'])) {
			$this->merchant_id=$_REQUEST['ServiceID'];
		} else return false;
		if(! empty ($_REQUEST['OrderID'])) {
			$this->order_id=$_REQUEST['OrderID'];
		} else return false;
		if(! empty ($_REQUEST['SessionID'])) {
			$this->session_id=$_REQUEST['SessionID'];
		} else return false;
		return true;
	} // end func _mBankGetRequestBad
	

	function mBankGetOk() {
		global $database;
		global $lang;
		// zmienna ktora okresla status operacji
		// domyslnie niepowodzenie czyli 0
		$status=0;
		// obierz dane z mbank
		if($this->_mBankGetRequestOk() == 'true') {
			//parmetry odebrane poprawnie
			//oblicz sume kontrolna
			if($this->crc->PayCrcEqual($this->order_id,$this->amount,$this->session_id)) {
				print "OK";
			} else {
				print "Error";
			}
		} else {
			print "request bad";
		}
	} // end func mBankGetOk
	
	
	/**
	* G³ówna funkcja wywolywana wtedy gdy przyjdzie b³êdna odpowiedz z mbank
	*
	*/
	function mBankGetError() {
		global $lang;
		print "<br><center>".$lang->mbank_not_pay."</center><br><br>";
		return false;
	} // end func mBankGetError
	
	/**
	* G³ówna funkcja do tworzenia platnosci mbank
	*
	*/
	function mBankPay() {
		$str=$this->_mBankPutForms();
		return $str;
	} // end func mBankPay
	
	/**
	* Funkcja tworzy opis transakcji przekazywany do mbank
	*
	*/
	function _mBankGetDescription($desc='') {
		$description=$this->order_id;
		//$description.="|".$desc;
		return $description;
	} // end func _mBankGetDescription
	
	/**
	* Generowanie formatki do przekierowania uzytkownika do mbank
	*
	* return $string formatka ktora trzeba wyswietlic
	*/
	function _mBankPutForms() {
		global $_SESSION;
		global $mbank_config;
		$str='';
		$str.="\n<form METHOD='GET' ACTION='".$mbank_config->mbank_server."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='ServiceID' VALUE='".$mbank_config->mbank_merchant_id."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='TrDate' VALUE='".$this->tr_date."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Amount' VALUE='".$this->amount."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='Description' VALUE='".$this->_mBankGetDescription($mbank_config->mbank_info)."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='SessionID' VALUE='".$this->crc->PayCrcPutString($this->order_id,$this->amount)."'>\n";
		$str.="<input TYPE='HIDDEN' NAME='OrderID' VALUE='".$this->order_id."'>\n";
		$str.="<center><input TYPE='SUBMIT' VALUE='mTransfer: ".$this->amount." z³'></center>\n";
		$str.="</form>\n";
		return $str;
	} // end func _mBankPutForms
	
} //end class mBank
?>

<?php
/**
 * Klasa obslugujaca protokó³ SOAP
 *
 *
 * @author  rdiak@sote.pl
 * @version $Id: soap.inc.php,v 1.3 2006/07/11 10:16:52 cvs Exp $
* @package    include
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once("HTTP/http.php");

/**
 * Klasa SOAP
 *
 * @package ceneo
 * @subpackage admin
 */
class SOAP {
	
	var $address='';
	var $port='';
	var $rpc='';
	var $message='';
	var $transaction='';
	var $login='';
	var $password='';
	
	
	/**
	* Konstruktor obiektu ceneoGetCat
	*
	* @return boolean true/false
	*/
	function SOAP() {
		global $ceneo_config;
		global $config;

		if($ceneo_config->ceneo_load == 'product') {
			$this->address=$ceneo_config->ceneo_server;
		} else {
			$this->address=$ceneo_config->ceneo_test_server;
		}
		$this->port=$ceneo_config->ceneo_port;
		$this->rpc=@$ceneo_config->ceneo_rpc;
		$this->message=$ceneo_config->ceneo_message;
		$this->login=$ceneo_config->ceneo_login;
		$this->password=$ceneo_config->ceneo_password;
		$this->transaction=@$ceneo_config->ceneo_transaction;
		return true;
	} // end SOAP()
	
	/**
	 * Funkcja konwersji metaznakow z xml
	 *
	 * @param  string $xml      string xml
	 *
	 * @return string           skonwetowany xml
	 */
	function & xml_to_chars(&$xml) {
		$xml = eregi_replace('&lt;', '<', $xml);
		$xml = eregi_replace('&gt;', '>', $xml);
		$xml = eregi_replace('&amp;', '&', $xml);
		$xml = eregi_replace('&quot;', '"', $xml);
		$xml = eregi_replace('&apos;', '\'', $xml);
		return $xml;
	} // end xml_to_chars()
	
	/**
	 * Funkcja konwersji metaznakow do xml
	 *
	 * @param  string $str      string xml
	 *
	 * @return string          skonwetowany xml
	 */
	function & chars_to_xml(&$xml) {
		$xml = eregi_replace('<', '&lt;', $xml);
		$xml = eregi_replace('>', '&gt;', $xml);
		$xml = eregi_replace('&', '&amp;', $xml);
		$xml = eregi_replace('"', '&quot;', $xml);
		$xml = eregi_replace('\'', '&apos;', $xml);
		return $xml;
	} // end chars_to_xml()

	/**
	 * Funkcja konwertujaca string z standardu utf-8 na iso-8859-2
	 *
	 * @param  string $string  ciag znakow,
	 *
	 * @return string $string  ciag znakow po konwersji
	 */
	function & encoding_utf8_to_8859_2(&$string) {
		$decode=array(
		"\xC4\x84"=>"\xA1",
		"\xC4\x85"=>"\xB1",
		"\xC4\x86"=>"\xC6",
		"\xC4\x87"=>"\xE6",
		"\xC4\x98"=>"\xCA",
		"\xC4\x99"=>"\xEA",
		"\xC5\x81"=>"\xA3",
		"\xC5\x82"=>"\xB3",
		"\xC5\x83"=>"\xD1",
		"\xC5\x84"=>"\xF1",
		"\xC3\x93"=>"\xD3",
		"\xC3\xB3"=>"\xF3",
		"\xC5\x9A"=>"\xA6",
		"\xC5\x9B"=>"\xB6",
		"\xC5\xB9"=>"\xAC",
		"\xC5\xBA"=>"\xBC",
		"\xC5\xBB"=>"\xAF",
		"\xC5\xBC"=>"\xBF"
		);
		
		$string = strtr("$string",$decode);
		return $string;
	} // end func encoding_unicode_to_8859-2
	
	/**
	 * Funkcja konwertujaca string z standardu iso-8859-2 na utf-8
	 *
	 * @param  string $string  ciag znakow,
	 *
	 * @return string $string  ciag znakow po konwersji
	 */
	function & encoding_iso8859_2_to_utf8(&$string) {
		/*$decode=array(
		"\xA1" => "\xC4\x84",
		"\xB1" => "\xC4\x85",
		"\xC6" => "\xC4\x86",
		"\xE6" => "\xC4\x87",
		"\xCA" => "\xC4\x98",
		"\xEA" => "\xC4\x99",
		"\xA3" => "\xC5\x81",
		"\xB3" => "\xC5\x82",
		"\xD1" => "\xC5\x83",
		"\xF1" => "\xC5\x84",
		"\xD3" => "\xC3\x93",
		"\xF3" => "\xC3\xB3",
		"\xA6" => "\xC5\x9A",
		"\xB6" => "\xC5\x9B",
		"\xAC" => "\xC5\xB9",
		"\xBC" => "\xC5\xBA",
		"\xAF" => "\xC5\xBB",
		"\xBF" => "\xC5\xBC",
		);
		$string = strtr("$string",$decode);*/
		return $string;
	} // end func encoding_iso8859_2_to_utf8
		
	
	/**
	 * Glowna funkcja  pobierania  kategorii z ceneo_pasaz.
	 *
	 * @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
	 *
	 * @return boolean true/false
	 */
	function & send_soap_category($mesg) {
		global $lang;
		$category='';

		print $this->address;
		// inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
		$http = new http_class;
		
		// otwieramy polaczenie z serwerem SOAP
		$error=$http->Open(array(
			"HostName"=>$this->address,
			"HostPort"=>$this->port,
			)
		);
		// jesli polaczenie zostalo otwarte pomyslnie
		if($error == "" ) {
			$str=$this->address.$this->rpc;
			$error1=$http->SendRequest(array(
				"RequestMethod"=>"POST",
				"RequestURI"=>$this->rpc,
				"Headers"=>array(
					"Host"=>$this->address,
					"User-Agent"=>"Manuel Lemos HTTP class SOAP test script",
					"Pragma"=>"no-cache",
					"SoapAction"=>"http://rentserver73.internet1.de/ConvertTemperature",
					"EndPointURL"=>"$str",
					"Content-Type"=>"text/xml; charset=utf-8"
					),
				"Body"=>$mesg
				)
			);
			
			if($error1 == ""){
				$headers=array();
				$error2=$http->ReadReplyHeaders($headers);
				if($error2 == "") {
					$i=0;
					for(;;)
					{
						$error3=$http->ReadReplyBody($body,1000);
						if($error3!="" || strlen($body)==0){
							break;
						} else {
							$category.=HtmlSpecialChars($body);
						}
						$i++;
					}
				} else {
					print $lang->ceneo_soap['no_header']."<br>";
					print $error2;
				} //end error2
			} else {
				print $lang->ceneo_soap['bad_reply']."<br>";
				print $error1;
			} // end error1
		} else {
			print $lang->ceneo_soap['not_connect']."<br>";
			print $error;
		} //end error
		$cat=&$category;
		return $cat;
	} // end send_soap_offer()
	
	/**
	* Funkcja inlementuje komunikacje i ladowanie oferty do ceneo_pasaz.
	*
	* @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
	*
	* @return boolean true/false
	*/
	function & send_soap_offer(&$mesg) {
		global $lang;
		$category='';
		
		// inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
		$http = new http_class;
		
		$address=$this->login.":".$this->password."@".$this->address;
		//print $address;
		// otwieramy polaczenie z serwerem SOAP
		$error=$http->Open(array(
			"HostName"=>$this->address,
			"HostPort"=>$this->port,
			)
		);
		// jesli polaczenie zostalo otwarte pomyslnie
		if($error == "" ) {
			$str="http://".$address.$this->message;
			$auth='Basic ' . base64_encode($this->login . ':' . $this->password);
			$error1=$http->SendRequest(array(
				"RequestMethod"=>"POST",
				"RequestURI"=>$this->message,
				"Headers"=>array(
						"Host"=>$this->address.":".$this->port,
						"User-Agent"=>"Manuel Lemos HTTP class SOAP test script",
						"Pragma"=>"no-cache",
						"SoapAction"=>"http://rentserver73.internet1.de/ExportCennik",
						"EndPointURL"=>"$str",
						"Content-Type"=>"text/xml; charset=utf-8",
					),
				"Body"=>$mesg
				)
			);
			
			if($error1 == ""){
				$headers=array();
				$error2=$http->ReadReplyHeaders($headers);
				if($error2 == "") {
					$i=0;
					for(;;)
					{
						$error3=$http->ReadReplyBody($body,1000);
						if($error3!="" || strlen($body)==0){
							break;
						} else {
							$category.=HtmlSpecialChars($body);
						}
						$i++;
					}
				} else {
					print $lang->ceneo_soap['no_header']."<br>";
					print $error2;
				} //end error2
			} else {
				print $lang->ceneo_soap['bad_reply']."<br>";
				print $error1;
			} // end error1
		} else {
			print $lang->ceneo_soap['not_connect']."<br>";
			print $error;
		} //end error
		$cat=&$category;
		return $cat;
	} // end send_soap_offer()
	
	/**
	 * Funkcja implementuje komunikacje i obsluge transakcji.
	 *
	 * @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
	 *
	 * @return boolean true/false
	 */
	function & send_transaction(&$mesg) {
		global $lang;
		
		$category='';
		
		// inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
		$http = new http_class;
		
		// otwieramy polaczenie z serwerem SOAP
		$error=$http->Open(array(
			"HostName"=>$this->address,
			"HostPort"=>$this->port,
			)
		);
		// jesli polaczenie zostalo otwarte pomyslnie
		if($error == "" ) {
			$str="http://".$this->address.$this->transaction;
			$error1=$http->SendRequest(array(
				"RequestMethod"=>"POST",
				"RequestURI"=>$this->transaction,
				"PostValues"=>$mesg,
				)
			);
			
			if($error1 == ""){
				$headers=array();
				$error2=$http->ReadReplyHeaders($headers);
				if($error2 == "") {
					$i=0;
					for(;;)
					{
						$error3=$http->ReadReplyBody($body,1000);
						if($error3!="" || strlen($body)==0){
							break;
						} else {
							$category.=HtmlSpecialChars($body);
						}
						$i++;
					}
				} else {
					print $lang->ceneo_soap['no_header']."<br>";
					print $error2;
				} //end error2
			} else {
				print $lang->ceneo_soap['bad_reply']."<br>";
				print $error1;
			} // end error1
		} else {
			print $lang->ceneo_soap['not_connect']."<br>";
			print $error;
		} //end error
		$cat=&$category;
		return $cat;
	} // end send_transaction()
} // end class SOAP
?>

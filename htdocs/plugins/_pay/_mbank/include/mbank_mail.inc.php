<?php
/**
* @package    pay
* @subpackage mbank
*/
?>
/<?php

/**
* Klasa obslugi platnosci mBang
*
* @author  r@sote.pl
* @version $Id: mbank_mail.inc.php,v 1.5 2004/12/20 18:02:06 maroslaw Exp $
* @package soteesklep
*/

require_once("include/my_crypt.inc");
require_once ("HTTP/Client.php");

class mBankMail {
	
	// @access private
	var $pass_gpg='';			// haslo do klucza prywatnego gpg potrzebne do rozszyfrowania maila
	// @access private
	var $login='';				// login do konta na ktore przyhcodza maile z rozliczeniami
	// @access private
	var $password='';			// haslo do konta na ktore przychodza maile z rozliczeniami
	// @access private
	var $path='';				// sciezka do pliku z zaszyfrowanym mailem
	// @access private
	var $subject='';			// tytul maila z transakcjami
	// @access private
	var $subject_config='';		// tytul maila z transakcjami z pliku config
	// @access private
	var $server_no_safe='';		// adres servera vitualnego gdzie nie ma safe_moda

	
	
	/**
	* Konstruktor
	*/
	function mBankMail() {
		global $mbank_config;
		global $DOCUMENT_ROOT; 
		
		$this->pass_gpg=$this->_mbank_decrypt_value($mbank_config->mbank_pass_gpg);
		$this->login=$mbank_config->mbank_login;
		$this->password=$this->_mbank_decrypt_value($mbank_config->mbank_password);
		$this->mail_host=$mbank_config->mbank_mail_host;
		$this->path="$DOCUMENT_ROOT/plugins/_pay/_mbank/files/in.txt";
		$this->subject_config=$mbank_config->mbank_title_email;
		$this->server_no_safe=$mbank_config->mbank_no_safe;
	
		return true;
	} // end mBankMail
	
	/**
	* Wstaw formularz przekierowujacy klienta do systemu CitiConnect
	*
	* @access public
	* @return string HTML - formularz
	*/
	
	function mbank_mail_action() {
		global $database;
		
		$host="{".$this->mail_host.":143}INBOX";
		$mbox=imap_open($host,$this->login,$this->password);
		if(! $mbox ) {
			return;
		} else {
			$msgno=imap_num_msg($mbox);
			$data=imap_headerinfo($mbox,$msgno);
			$this->subject=$data->subject;
			if($this->subject != $this->subject_config) {
				$this->_mbank_save_error();
				exit;
			}			
			$parts = $this->mail_fetchparts($mbox, $msgno);
			//zapisujemy zalacznik do pliku tymczasowego
			$fd = fopen($this->path, "w");
			$parts[2]=imap_base64($parts[2]);
			$output = fputs($fd, $parts[2]);
			fclose($fd);
			// wywolujemy dekodowanie formularza.
			$this->_attachment_decode();
		}
	} // end mbank_mail_action
	
	
	function mail_mimesplit($header, $body) {
		$parts = array();
		
		$PN_EREG_BOUNDARY = "Content-Type:(.*)boundary=\"([^\"]+)\"";
		
		if (eregi ($PN_EREG_BOUNDARY, $header, $regs)) {
			$boundary = $regs[2];
			
			$delimiterReg = "([^\r\n]*)$boundary([^\r\n]*)";
			if (eregi ($delimiterReg, $body, $results)) {
				$delimiter = $results[0];
				$parts = explode($delimiter, $body);
				$parts = array_slice ($parts, 1, -1);
			}
			
			return $parts;
		} else {
			return false;
		}
	} // end mail_mimesplit
	
	function mail_mimesub($part) {
		$i = 1;
		$headDelimiter = "\r\n\r\n";
		$delLength = strlen($headDelimiter);
		
		// get head & body of the current part
		$endOfHead = strpos( $part, $headDelimiter);
		$head = substr($part, 0, $endOfHead);
		$body = substr($part, $endOfHead + $delLength, strlen($part));
		
		// check whether it is a message according to rfc822
		if (stristr($head, "Content-Type: message/rfc822")) {
			$part = substr($part, $endOfHead + $delLength, strlen($part));
			$returnParts[1] = mail_mimesub($part);
			return $returnParts;
			// if no message, get subparts and call function recursively
		} elseif ($subParts = $this->mail_mimesplit($head, $body)) {
			// got more subparts
			while (list ($key, $val) = each($subParts)) {
				$returnParts[$i] = $this->mail_mimesub($val);
				$i++;
			}
			return $returnParts;
		} else {
			return $body;
		}
	} // end mail_mimesub
	
	/**
	* Funkcja dekoduje dana podana jako parametr
	*
	* @access private
	* @return bool
	*/
	function mail_fetchparts($mbox, $msgNo) {
		$parts = array();
		$header = imap_fetchheader($mbox,$msgNo);
		$body = imap_body($mbox,$msgNo, FT_INTERNAL);
		
		$i = 1;
		
		if ($newParts = $this->mail_mimesplit($header, $body)) {
			while (list ($key, $val) = each($newParts)) {
				$parts[$i] = $this->mail_mimesub($val);
				$i++;
			}
		} else {
			$parts[$i] = $body;
		}
		return $parts;
		
	} // end mail_fetchparts

	/**
	* Funkcja dekoduje dana podana jako parametr
	*
	* @access private
	* @return bool
	*/
	function _attachment_decode() {
		
		$pass=$this->pass_gpg;
		$http =& new HTTP_Client;
		$http->post("$this->server_no_safe",array('pass'=>$pass,'path'=>$this->path));
		$body=$http->_responses[0]['body'];
		print "body".$body;
		if($this->_mbank_update_trans() == 'true' ) {
			// transakcje zostaly updaejtowane
		} else {
			// transakcje nie zostaly zaktualizowane
		}
		return true;
	}
	
	/**
	* Funkcja dekoduje dana podana jako parametr
	*
	* @access private
	* @return bool
	*/
	function _mbank_update_trans() {
		global $database;
		
		return true;
	} // end _mbank_update_trans
	
	/**
	* Funkcja dekoduje dana podana jako parametr
	*
	* @access private
	* @return bool
	*/
	function _mbank_decrypt_value($value) {
		if(! empty($value)) {
			$my_crypt=new MyCrypt;
			$value=$my_crypt->endecrypt("",@$value,"de");
		}
		return $value;
	} // end _mbank_decrypt_value
	
	/**
	* Funkcja zapisuje error do bazy
	*
	* @access private
	* @return bool
	*/
	function _mbank_save_error() {
		return true;
	} // end _mbank_save_error
}
?>

<?php
/**
 * Rozszerzone funkcje sprawdzajace m.in. poprawnosc pola email
 *
 * @author  rp@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.3 2004/12/20 18:01:54 maroslaw Exp $
* @package    users
 */
class FormCheckFunctions extends FormCheck {
	/**
	 * @return bool true - poprawne dane	 
	 */
	 
	/**
	 * Rozszerzona funkcja do sprawdzania danych email
	 *	 
	 * @param  string $email adres do weryfikacji
	 * @access public
	 */
	function emailXtd($email){		
		if(empty($email)) return true;
		return $this->email($email);
	} // end emailXtd()
	
	/**
	 * Rozszerzona funkcja do sprawdzania danych
	 *	 
	 * @param  string $email adres do weryfikacji
	 * @access public
	 */
	function intExt($data){		
		if(empty($data)) return true;
		return $this->int($data);
	} // end emailXtd()
	
	
} // end class FormCheckFunctions
?>

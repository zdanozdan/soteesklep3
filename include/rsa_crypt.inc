<?php
/**
 * Wrapper do wykorzystywania szyfrowania RSA
 * Obs³uga szyfrowania i roszyfrowywania danych na podstawie klucza publicznego lub prywatnego i pinu
 *
 * @author lukasz@sote.pl
 */
class KeyHandler {
	var $_public_key; // klucz publiczny (obiekt)
	var $_private_key; // klucz prywatny (obiekt)
	var $rsa_obj; // w³a¶ciwy obiekt koduj±cy dane

	/**
	 * Konstruktor
	 * Inicjacja klucza prywatnego i publicznego
	 *
	 * @return KeyHandler
	 */
	function KeyHandler() {
		global $shop;
		global $config;
		require_once("PEAR/Crypt/RSA.php");
		$this->rsa_obj=new Crypt_RSA;
		// czytamy configa
		global $cardpay_config;
		include_once("config/auto_config/cardpay_config.inc.php");
		// przypisujemy klucz publiczny
		$this->_public_key=& Crypt_RSA_Key::fromString($cardpay_config->pub_key);
		// je¿eli jeste¶my w panelu admina - czytamy klucz prywatny
		if ($shop->admin) {
			// trzeba nam rozszyfrowaæ klucz na podst pinu
			require_once ("include/crypt_db.inc");
			$crypt_db  = new Crypt_DB;
			global $__pin;
			include_once ("include/pin.inc.php");
			$crypt_db->key=md5($config->salt.$__pin);
			// rozszyfrowujemy klucz pinem
			$key=$crypt_db->cardkey();
			// przypisujemy
			$this->_private_key=& Crypt_RSA_Key::fromString($key);
		}
	}


	/**
	 * Szyfruj dane wej¶ciowe kluczem publicznym
	 * Funkcja serializuje cokolwiek jej siê poda jako wej¶ciowe
	 * i zwraca zaszyfrowany string
	 *
	 * @param mixed $data
	 * @return string
	 */	
	function encrypt($data) {
		$data=serialize($data);
		return $this->rsa_obj->encrypt($data, $this->_public_key);
	}

	/**
	 * Rozszyfruj dane wyej¶ciowe kluczem prywatnym
	 * Funkcja rozszyfrowuje dane wej¶ciowe kluczem prywatnym
	 * i je odserializuje - zwracaj±c tak± sam± strukture danych jak ta zaszyfrowana
	 * Je¿eli wywo³anie nie odbywa siê przez panel admina funkcja zwraca 0
	 *
	 * @param string $data
	 * @return mixed
	 */
	function decrypt($data) {
		global $shop;
		// je¿eli nie jestesmy adminem - wyjscie
		if (!$shop->admin) return 0;
		$this->rsa_obj->setParams(array('dec_key' => $this->_private_key));
		$data= $this->rsa_obj->decrypt($data);
		// odtwarzamy strukture szyfrowanych danych
		$data= unserialize($data);
		return $data;
	}
}
$keyhandler=& new KeyHandler();
?>
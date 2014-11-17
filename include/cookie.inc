<?php 
class Cookie {
	var $name;
	var $value='';
	var $expire='';
	var $path;
	var $domain;
	
	/**
	 * Klasa automatyzuj±ca zapis i odczyt plików cookie
	 *
	 * @return Cookie
	 */
	function Cookie() {
		global $config;
		$this->expire=time()+60*60*24*356*5;
		$this->name=ereg_replace('\.','_',$config->www)."SOTEeSKLEP_data";
		$this->path='/';
		$this->domain=".".$config->www;
	}
	
	/**
	 * Zwróæ warto¶æ zmiennej z ciastka lub null
	 *
	 * @param nazwa zmiennej $name
	 * @return mixed
	 */
	function read_array($name) {
		if (!empty($_COOKIE[$this->name][$name])) {
			return unserialize($_COOKIE[$this->name][$name][0]);
		} else return null;
	}
	
	/**
	 * Zapisz zmienn± do ciastka
	 *
	 * @param nazwa ciastka $name
	 * @param array $data
	 */
	function write_array($name, $data) {
		if (is_array($data)) {
			foreach ($data as $key=>$value) {
				$cookiename=$this->name.'['.$name."][$key]";
				$value=serialize($value);
				setcookie($cookiename,$value,$this->expire,$this->path,$this->domain);
			}
		}
	}
}
$cookie =& new Cookie();
?>
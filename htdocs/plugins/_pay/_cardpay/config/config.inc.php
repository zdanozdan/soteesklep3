<?php 
/**
* Konfiguracja lokalna zwi±zana z transakcjami
*
* @author  m@sote.pl
* @version $Id: config.inc.php,v 1.1 2005/10/26 12:45:26 lukasz Exp $
* @package order
*/

/**
* Konfiguracja u¿ytkownika dot. systemu przelewy24.
*/
require_once ("config/auto_config/przelewy24_config.inc.php");

/**
* Dodaj metodê Przelewy24 o ID 12, wymagane do rejestracji transakcji.
* Modyfikacja dot. upgrade dla starszych wersji config/config.inc.php, w których
* nie ma jawnej definicji poni¿szych warto¶ci. Dotyczy wersji < 3.0RC11.
*/
if (! empty($przelewy24_config)) {
    $config->pay_method[12]="Przelewy24";
    $lang->pay_method[12]="Przelewy24";
}

/**
* Adres weryfikacji danych tranakcji.
*/
define ("URL_SSL","https://secure.przelewy24.pl:443/transakcja.php");
?>
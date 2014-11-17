<?php
/**
* Klasa obs³uguj±ca import danych do sklepu z wersji 3.0
*
* @author  m@sote.pl
* @version $Id: soteesklep30.inc.php,v 1.7 2006/01/19 11:50:43 lukasz Exp $
* @package importshop
*/

/**
* Klasa z funkcjami globalnymi dot. importu danych. Funkcje niezale¿ne od rodzaju programu, z którego s±importowane dane.
*/
require_once ("./include/importshop_main.inc.php");
require_once ("include/my_crypt.inc");

$__import_class="SOTEeSKLEP30";

/**
* Import danych z SOTEeSKLEP 3.0
* @package importshop
*/
class SOTEeSKLEP30 extends ImportShopMain {

    var $name="soteesklep30";

    /**
    * Konstruktor    
    */
    function SOTEeSKLEP30() {
        require_once ("./config/$this->name"."-config.inc.php");
        return true;
    } // end SOTEeSKLEP30()

    /**
    * Je¶li id_curreny jest>1 to wstaw warto¶æ 0, je¶li id_currency=1 to skopiuj warto¶æ
    *
    * @param mixed $value
    * @return float
    */
    function changeOrZero($value) {
        if ($this->values['id_currency']==1) {
            return $value;
        } else return 0;
    } // end changeOrZero()

    /**
    * Oblicz sume kontrol± dla s³owa bazowego. 
    *    
    * @return string 
    */
    function dictionaryKeyMd5() {
        if (! empty($this->values['wordbase'])) {
            return md5($this->values['wordbase']);
        }
    } // end dictionary_key_md5()

    /**
    * Generuj sumê kontroln± potrzebn± w celu uniemo¿liwienia dodania dwóch identycznych rekordow, tj. rabatów 
    *
    * @param string $value warto¶c aktualna checksum
    * @return string
    */
    function discountChecksum($value) {
        // suma kontrolna potrzebna w celu uniemozliwienia dodania dwoch identycznych rekordow
        if (empty($value)) {
            return md5($this->values['idc_name'].$this->values['producer_name']);
        } else return $value;
    } // end discountChecksum()

    /**
     *  Crypt login - jesli login jest pusty nadaj login jako ID
     * 
     *  @param string $value warto¶æ aktualna checksum
     *  @return string
     */
     function crypt_login($value) {
	global $my_crypt;
	if (empty($value)) {
        return $my_crypt->endecrypt("",$this->values['id']);	
	} else return $value;
     } // end crypt_login()
    
     /**
      * Zwraca id dodanej dla u¿ytkownika przechowalni
      *
      * @return int
      */
     function id_wishlist() {
     	global $db;
     	$empty_basket='a:1:{i:0;s:5:"Blank";}';
     	$sql="INSERT INTO basket (data) VALUES ('$empty_basket')";
     	$result=$db->Query($sql);
     	if ($result!=0) {
     		$sql="SELECT max(id) FROM basket";
			$res=$db->Query($sql);
			$id_wishlist=$db->FetchResult($res,0,'max(id)');
			return $id_wishlist;
     	}
     	return (0);
     }
} // end class SOTEeSKLEP30
?>

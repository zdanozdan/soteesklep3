<?php
/**
* Generowanie zapytania SQL na podstawie prezkazanych kategorii
*
* @author  rdiak@sote.pl piotrek@sote.pl m@sote.pl
* @version $Id: ranking.inc.php,v 1.6 2006/04/03 13:16:18 lechu Exp $
* @package    info
* @subpackage in_category
*/

/**
* Odczytaywanie danych o produkcie.
*/
require_once ("include/product.inc");

/**
* @ignore
* @package info
* @subpackage in_category
*/
class RecRanTmp{}

/**
* Klasa zawieraj�ca funkcj� prezentacji produktu na li�cie.
* @package info
* @subpackage in_category
*/
class RankingRow {
    
    /**
    * Wy�wietl informacje o produkcie na li�cie.
    *
    * @param mixed $result wynik zpytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania z bazy danych
    * @return none
    */    
    function record($result,$i) {
        global $db,$theme;
        
        $rec =& new RecRanTmp;
        $product =& new Product($result,$i,$rec);
        $product->getRec(PRODUCT_ROW);        
        $theme->record_row_short($rec);
        
        return;
    } // end record()
} // end class RankingRow

/**
* Generowanie zapytania o dane produkt�w z tej samej kategorii, prezentacja listy produkt�w. 
* @package info
* @subpackage in_category
*/
class RankingData {
    
    /**
    * Generuj zapytanie o inne produkty z tej samej kategtoii
    *
    * @param  mixed &$rec adres obiektu $rec z danymi z bazy przgladanego produktu
    * @return string zapytanie SQL
    */
    function query_ranking(&$rec) {
        global $config;
        global $theme;
        global $db;
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        
        $query = "SELECT $config->select_main_price_list
        		FROM main WHERE active=1 $q_unavailable AND (
        			0=1";
        
        $ranking = $rec->data['ranking'];
        if(!empty($ranking)) {
        	$ranking = unserialize($ranking);
        }
        if(!empty($ranking)) {
	        reset($ranking);
	        $score_array = array();
	        while (list($key, $val) = each($ranking)) {
	            $score_array[$key] = $val['conf'];
	        }
	        
	        reset($ranking);
	        while (list($key, $val) = each($ranking)) {
	        	$query .= " OR user_id = '$key' ";
	        }
        }
        $query .= ") ";
        return $query;
    }

    
    /**
    * Pokarz liste produktow z tej samej kategorii, co przegladany produkt
    *
    * @param addr adres obiektu $rec z danymi z bazy przgladanego produktu
    */
    function show_ranking(&$rec) {
        global $config;
        global $theme;
        global $db;
        global $lang;
        
        $sql=$this->query_ranking($rec);
        $dbedit=new DBEdit;
        
        $ranking = $rec->data['ranking'];
        if(!empty($ranking)) {
        	$ranking = unserialize($ranking);
        }
        $score_array = array();
        if(!empty($ranking)) {
	        reset($ranking);
	        while (list($key, $val) = each($ranking)) {
	            $score_array[$key] = (float)$val['conf'];
	        }
        }
        
        $dbedit->page_records=$config->ranking1_max_length;
        $dbedit->record_class="RankingRow";
        $dbedit->start_list_element="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">";
        $dbedit->end_list_element="</table>";
        $dbedit->dbtype=$config->dbtype;
        $dbedit->empty_list_message=''; // nie wyswietlaj komuniakatu, jesli nie ma innych produktow w kategorii
        $dbedit->top_links = false;
        $dbedit->bottom_links = false;
        $dbedit->record_list($sql, $score_array);
        return;
    } // end show_ranking()
    
    /**
    * Sprawdz czy istnieje jakikolwiek produkt z tej samej kategorii
    *
    * @author piotrek@sote.pl
    * @param addr adres obiektu $rec z danymi z bazy przgeladanego produktu
    * @return int - (0- brak prodkutu, - produkt wystepuje)
    */
    function check_product_in_ranking(&$rec) {
        
        $ranking = $rec->data['ranking'];
        if(!empty($ranking)) {
        	$ranking = unserialize($ranking);
        }
        if (empty($ranking))
        	return 0;
        else
        	return 1;
        
        return $check;
    } // end check_product_in_ranking($rec)
    
} // end class RankingData;

$ranking =& new RankingData;

?>

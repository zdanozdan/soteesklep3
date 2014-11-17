<?php
/**
* Akceroria dla danego produktu, tworzenie zapyatani SQL, generowanie listy produktów.
*
* @author m@sote.pl piotrek@sote.pl
* @version $Id: accessories.inc.php,v 2.13 2006/04/03 13:14:42 lechu Exp $
* @package    info
* @subpackage accessories
*/

/**
* Odczytaywanie danych o produkcie.
*/
require_once ("include/product.inc");

/**
* Limit akcesoriów do produktu
*/
define ("ACCESSORIES_LIMIT",100);

/**
* @ignore
* @package info
* @subpackage in_category
*/
class RecAccTmp{}

/**
* Klasa zawieraj±ca funkcjê prezentacji produktu na li¶cie.
* @package info
* @subpackage accessories
*/
class AccessoriesRow {
    
    /**
    * Wy¶wietl informacje o produkcie na li¶cie.
    *
    * @param mixed $result wynik zpytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania z bazy danych
    * @return none
    */
    function record($result,$i) {
        global $db,$theme;
        
        $rec =& new RecAccTmp;
        $product =& new Product($result,$i,$rec);
        $product->getRec(PRODUCT_ROW);
        $theme->record_row_short($rec);
        
        return;
    } // end record()
} // end class AccessoriesyRow

/**
* Generowanie zapytania o dane produktów - akcesroriów do ogl±danego produtku, prezentacja listy produktów.
* @package info
* @subpackage accessories
*/
class Accessories {
    
    /**
    * Generuj zapytanie o akcesoria do produktów
    *
    * @param addr adres obiektu $rec z danymi z bazy przgladanego produktu
    * @return string zapytanie SQL
    */
    function query_accessories(&$rec) {
        global $config;
        global $theme;
        global $db;
        
        if (empty($rec->data['accessories'])) return;
        
        $ac=$rec->data['accessories'];
        
        // odziel numery id rekordow np. [12; 34 ; 56;12;5] podziel na elementy tablicy
        $tab_ac=preg_split("/;/",$ac,ACCESSORIES_LIMIT);
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        
        $query="SELECT $config->select_main_price_list FROM main WHERE active=1 $q_unavailable AND (";
        
        foreach ($tab_ac as $key=>$user_id) {
            // sprawdz czy odczytany user_id jest identyfikatorem uzytkownika (zawiera tylko litery i cyfry)
            $user_id = addslashes($user_id);
            if ($key==0) {
                $query.=" user_id='$user_id'";
            } else {
                $query.=" OR user_id='$user_id'";
            }
        } // end foreach
        
        // dodaj definicje sortowania wyniku
        $query.=") AND active=1 GROUP BY user_id ORDER BY price_brutto";
        
        return $query;
    } // end query_accessories()
    
    /**
    * Pokarz liste produktow z tej samej kategorii, co przegladany produkt
    *
    * @param mixed &$rec adres obiektu $rec z danymi z bazy przgladanego produktu
    * @return none
    */
    function show_accessories(&$rec) {
        global $config;
        global $theme;
        global $db;
        global $lang;
        
        $sql=$this->query_accessories($rec);
        if (empty($sql)) return;
        
        $dbedit =& new DBEdit;
        
        $dbedit->page_records=15;
        $dbedit->record_class="AccessoriesRow";
        $dbedit->start_list_element="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">";
        $dbedit->end_list_element="</table>";
        $dbedit->dbtype=$config->dbtype;
        $dbedit->empty_list_message=''; // nie wyswietlaj komuniakatu, jesli nie ma innych produktow w kategorii
        $dbedit->record_list($sql);
        
        return;
    } // end show_accessories()
    
} // end class Accessories

$accessories =& new Accessories;

?>

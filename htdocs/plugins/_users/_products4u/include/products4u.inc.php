<?php
/**
* Generowanie zapytania SQL na podstawie rankingu u¿ytkownika
*
* @author  rdiak@sote.pl piotrek@sote.pl m@sote.pl lech@sote.pl
* @version $Id: products4u.inc.php,v 1.4 2005/11/03 10:33:14 lechu Exp $
* @package    users
* @subpackage products4u
*/

/**
* Odczytaywanie danych o produkcie.
*/
require_once ("include/product.inc");

/**
* @ignore
* @package users
* @subpackage products4u
*/
class RecP4UTmp{}

/**
* Klasa zawieraj±ca funkcjê prezentacji produktu na li¶cie.
* @package users
* @subpackage products4u
*/
class Products4URow {

    /**
    * Wy¶wietl informacje o produkcie na li¶cie.
    *
    * @param mixed $result wynik zpytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania z bazy danych
    * @return none
    */    
    function record($result,$i) {
        global $db,$theme;

        $rec =& new RecP4UTmp;
        $product =& new Product($result,$i,$rec);
        $product->getRec(PRODUCT_ROW);
        $theme->record_row_short($rec);

        return;
    } // end record()
} // end class Products4URow

/**
* Generowanie zapytania o dane produktów rankingu u¿ytkownika, prezentacja listy produktów. 
* @package users
* @subpackage products4u
*/
class Products4UData {

    var $user_ranking;
    function Products4UData() {
        global $mdbd, $_SESSION;

        $res = $mdbd->select("ranking", "users", "id=?", array($_SESSION['global_id_user'] => "int"), '', 'array');
        $this->user_ranking = array();
        if(!empty($res[0]["ranking"]))
            $this->user_ranking = unserialize($res[0]["ranking"]);
    }

    /**
    * Generuj zapytanie o produkty z rankingu u¿ytkownika
    *
    * @param  mixed &$rec adres obiektu $rec z danymi z bazy przgladanego produktu
    * @return string zapytanie SQL
    */
    function query_products4u(&$rec) {
        global $config;
        global $theme;
        global $db;
        if(is_array($this->user_ranking)) {
            reset($this->user_ranking);
            $product_ids = array();
            /*
            while (list($prod_id, $arr) = each($this->user_ranking)) {
                if(!isset($product_ids[$prod_id]) || ($product_ids[$prod_id] == 0))
                    $product_ids[$prod_id] = 1;
                else
                    $product_ids[$prod_id] ++;
                while (list($prod_id2, $arr2) = each($arr)) {
                    if(!isset($product_ids[$prod_id2]) || ($product_ids[$prod_id2] == 0))
                        $product_ids[$prod_id2] = 1;
                    else
                        $product_ids[$prod_id2] ++;
                }
            }
            */
            $product_ids = $this->user_ranking;
            $this->order_array = $product_ids;
        }
        $query = "SELECT $config->select_main_price_list
        		FROM main WHERE active = 1 AND (
        			0 = 1";

        if(!empty($product_ids)) {
            reset($product_ids);

            while (list($key, $val) = each($product_ids)) {
                $query .= " OR user_id = '$key' ";
            }
        }
        $query .= ")";// LIMIT 0 , " . $config->ranking2_max_length;
//        echo "[$query]";
        return $query;
    }


    /**
    * Poka¿ liste produktow z rankingu
    *
    * @param addr adres obiektu $rec z danymi z bazy przgladanego produktu
    */
    function show_products4u(&$rec) {
        global $config;
        global $theme;
        global $db;
        global $lang;

        $sql=$this->query_products4u($rec);
        $dbedit=new DBEdit;

        $dbedit->page_records = $config->ranking2_max_length;
        $dbedit->record_class="Products4URow";
        $dbedit->start_list_element="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width='100%'>";
        $dbedit->end_list_element="</table>";
        $dbedit->dbtype=$config->dbtype;
        $dbedit->empty_list_message=''; // nie wyswietlaj komuniakatu, jesli nie ma innych produktow w kategorii
        $dbedit->top_links = false;
        $dbedit->bottom_links = false;
        $dbedit->record_list($sql);
//        $dbedit->record_list($sql, $this->order_array);

        return;
    } // end show_products4u()



} // end class Products4UData;

$products4u =& new Products4UData;

?>

<?php
/**
* Generowanie zapytania SQL na podstawie prezkazanych kategorii
*
* @author  rdiak@sote.pl piotrek@sote.pl m@sote.pl
* @version $Id: in_category.inc.php,v 2.16 2006/04/03 12:25:21 lechu Exp $
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
class RecCatTmp{}

/**
* Klasa zawieraj±ca funkcjê prezentacji produktu na li¶cie.
* @package info
* @subpackage in_category
*/
class CategoryRow {
    
    /**
    * Wy¶wietl informacje o produkcie na li¶cie.
    *
    * @param mixed $result wynik zpytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania z bazy danych
    * @return none
    */    
    function record($result,$i) {
        global $db,$theme;
        
        $rec =& new RecCatTmp;
        $product =& new Product($result,$i,$rec);
        $product->getRec(PRODUCT_ROW);        
        $theme->record_row_short($rec);
        
        return;
    } // end record()
} // end class CategoryRow

/**
* Generowanie zapytania o dane produktów z tej samej kategorii, prezentacja listy produktów. 
* @package info
* @subpackage in_category
*/
class CategoryData {
    
    /**
    * Generuj zapytanie o inne produkty z tej samej kategtoii
    *
    * @param  mixed &$rec adres obiektu $rec z danymi z bazy przgladanego produktu
    * @return string zapytanie SQL
    */
    function query_category(&$rec) {
        global $config;
        global $theme;
        global $db;
        
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        
        $query="SELECT $config->select_main_price_list
                  FROM main WHERE active=1 $q_unavailable AND (";
        for($i=1; $i <= $config->in_category_down; $i++) {
            $str="id_category".$i;
            if (! empty($rec->data[$str])) {
                $query.="id_category".$i."=".$rec->data[$str]." AND ";
            }
        }
        $query=preg_replace("/AND $/",") ",$query);
        $query.=" AND id <> ". $rec->data['id'];   

        $user_gt_id = 'GT'.$rec->data['id'];

	$query = "SELECT main.*, order_products.name,order_products.order_id, op.name, op.user_id_main, op.num, count(op.user_id_main) as cnt FROM order_products join order_products as op on op.order_id = order_products.order_id join main on op.user_id_main = main.user_id where order_products.user_id_main='$user_gt_id' and op.user_id_main <> '$user_gt_id' and main.active = 1 group by op.user_id_main order by cnt desc";     
        
        return $query;
    }
    
    /**
    * Pokarz liste produktow z tej samej kategorii, co przegladany produkt
    *
    * @param addr adres obiektu $rec z danymi z bazy przgladanego produktu
    */
    function show_category(&$rec) {
        global $config;
        global $theme;
        global $db;
        global $lang;
        
        $sql=$this->query_category($rec);
        $dbedit=new DBEdit;
        
        $dbedit->page_records=20;
        $dbedit->record_class="CategoryRow";
        $dbedit->start_list_element="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">";
        $dbedit->end_list_element="</table>";
        $dbedit->dbtype=$config->dbtype;
        $dbedit->empty_list_message=''; // nie wyswietlaj komuniakatu, jesli nie ma innych produktow w kategorii
        $dbedit->top_links = false;
        $dbedit->bottom_links = false;
        
        $dbedit->record_list($sql);
        
        return;
    } // end show_category()
    
    /**
    * Sprawdz czy istnieje jakikolwiek produkt z tej samej kategorii
    *
    * @author piotrek@sote.pl
    * @param addr adres obiektu $rec z danymi z bazy przgeladanego produktu
    * @return int - (0- brak prodkutu, - produkt wystepuje)
    */
    function check_product_in_category(&$rec) {
        global $config;
        global $theme;
        global $db;
        
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        // generuj zapytanie
        $query="SELECT id FROM main WHERE (";
        
        for($i=1; $i <= $config->in_category_down; $i++) {
            $str="id_category".$i;
            if (! empty($rec->data[$str])) {
                $query.="id_category".$i."=".$rec->data[$str]." AND ";
            }
        }
        
        $query=preg_replace("/AND $/",") ",$query);
        $query.=" AND id <> ? AND active=1 $q_unavailable";
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$rec->data['id']);
            
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    // istnieje produkt z tej samej kategorii
                    $check=1;
                } else $check=0;
            } else die ($db->Error());
        } else die ($db->Error());
        
        return $check;
    } // end check_product_in_category($rec)
    
} // end class CategoryData;

$in_category =& new CategoryData;

?>

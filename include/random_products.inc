<?php
/**
* Losuj produkty z promocji, nowo¶ci itp. (wed³ug wskazanej kolumny)
* Nowy modu³ w wersji 3.0 wykorzytyj±cy losowanie po stronie SQL, co znaczeni przyspiesza
* prezentacjê produktów. Wykorzystywane jest tu losowanie postaci:<br>
* SELECT * FROM MAIN WHERE ... ORDER BY rand()
*
* @author  m@sote.pl
* @version $Id: random_products.inc,v 2.13 2005/12/08 11:32:34 lechu Exp $
* @package    include
*/

/**
* @ignore
* @package promotion
*/
class RecordRandom {
    var $data=array(); // dane produktu
}

/* Klasa odpowiedzialna za odczytanie dany produktu */
require_once ("include/product.inc");

/**
* Klasa zawierajaca funkcje losujace proodukty w wybranych kolumn
* @package promotion
*/
class RandProduct {
    
    /**
    * @var array tablica z wy¶wietlonymi ju¿ produktami
    */
    var $_products=array();
    
    /**
    * Przedstaw wylosowane produkty z okreslonej kolumny    
    *
    * @param string $column nazwa kolumny wg której wyszukujemy produktów
    * @param int    $nr maksymaklna ilo¶c wy¶wietlanych produktów 
    */
    function showProducts($column,$nr) {
        global $time,$db,$theme,$config;
        
        if (! $nr>0) $nr=1;
        $column=addslashes($column);
        
        $time->start("<b>random_product.inc</b> $column");
        
        global $rec,$products;
        $rec =& new RecordRandom();
        
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        
        $query="SELECT $config->select_main_price_list FROM main WHERE $column=1 AND ".$this->_where()." AND active=1 $q_unavailable ORDER BY rand() LIMIT $nr";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                for ($i=0;$i<$num_rows;$i++) {
                    $products =& new Product($result,$i,$rec);
                    $products->getRec(PRODUCT_ROW);
                    
                    // zapamiêtaj wy¶wietlony produkt, po to, ¿eby nie pokazywaæ go ponownie 
                    // w innym miejscu na tej samej stronie
                    array_push($this->_products,$rec->data['id']);
                    
                    $theme->random_row($rec);
                }
            } else return;
        } else die ($db->Error());
        
        $time->stop("<b>random_product.inc</b> $column");
        
        return;
    }
    
    /**
    * Generuj warunke do zapytania SQL eliminuj±cy ju¿ wy¶iwetlone produkty
    * @return string
    */
    function _where() {
        $where='';
        if (empty($this->_products)) return 1;
        reset($this->_products);         
        foreach ($this->_products as $id) {            
            $where.="id!=$id AND ";
        }
        $where=substr($where,0,strlen($where)-5);        
        
        return $where;
    } // end _where()
        
    /* @see showProducts() */
    function show_products($column,$nr) {
        return $this->showProducts($column,$nr);
    } // end show_products()
    
} // end class RandProduct
?>

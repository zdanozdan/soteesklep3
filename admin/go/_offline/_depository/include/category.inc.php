<?php
/**
 * Zarzadzanie kategoriami i producentami
 *
 * @author  rdiak@sote.pl
 * @version $Id: category.inc.php,v 1.1 2005/12/22 11:41:22 scalak Exp $
* @package    offline
* @subpackage main
 */

 
/**
 * Includowanie liba do oblsugi zapytan do bazy danych
 */
require_once("include/metabase.inc");


/**
* Klasa OfflineCategory
*
* @package offline
* @subpackage admin
*/
class OfflineCategory {
    var $category1=array();
    var $category2=array();
    var $category3=array();
    var $category4=array();
    var $category5=array();
    var $producer=array();
    
    /**
     * Konstruktor obiektu myCategory wczytuje do tablic wartosci z bazy danyc
     *
     * @return bool  
     *
     * @author rdiak@sote.pl
     */
    function OfflineCategory() {
        global $database;
        
        $this->category1=$database->sql_select_data_array("id","category1","category1");
        $this->category2=$database->sql_select_data_array("id","category2","category2");
        $this->category3=$database->sql_select_data_array("id","category3","category3");
        $this->category4=$database->sql_select_data_array("id","category4","category4");
        $this->category5=$database->sql_select_data_array("id","category5","category5");
        $this->producer=$database->sql_select_data_array("id","producer","producer");
        //print "<pre>";
        //print_r($this->category2);
        //print "</pre>";
        return true;
    }
    
    /**
     * Funkcja check_category sprawdza czy dana kategoria znajduje sie juz w tablicy
     *
     * @param  string $category  nazwa tablicy ktor± sprawdzamy,
     * @param  string $name      nazwa kategorii do sprawdzenia
     * @return int    $max       id kategorii  
     * 
	 * @access public
	 *
     * @author rdiak@sote.pl
     */
   function check_category($category,$name) {
        // sprawdzamy czy w tablicy znajduje sie juz taka kategoria
        // jesli nie to dodajemy ja na koniec tablicy
        $category_var=&$this->$category;
        if(in_array("$name",$category_var)){
            $max=array_search("$name",$category_var);
            return $max;
        } else {
            $table=array_keys($category_var);
            @$max=max($table);
            //print "maxx - $max<br>";
            $max+=1;
            $category_var = $category_var+array($max=>$name);
            return $max;
        }
    }
    
    /**
     * Funkcja load_category laduje kategorie z tablicy do bazy danych. Wczesniej kasowane
     * sa kategorie z bazy gdyz kategorie wszystkie znajduja sie w tablicach PHP, na ktorych
     * wczesniej operowalismy. 
     *
     * @param  string $category  nazwa tablicy ktora uzupelniamy
     * @return bool     
     *
     * @author rdiak@sote.pl
     */
    function load_category(){
        global $database;

        $table=array("category1","category2","category3","category4","category5","producer");
        foreach($table as $cat) {
            $database->sql_delete($cat);
            while ( list( $key, $value ) = each( $this->$cat ) ) {
                $result=$database->sql_insert($cat,array("id"=>"$key",$cat=>"$value"));
            }
        }
        return true;
    }
} // end class OfflineCategory
?>

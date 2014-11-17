<?php
/**
 * Zarzadzanie kategoriami i producentami
 *
 * @author  rdiak@sote.pl
 * @version $Id: category.inc.php,v 1.7 2004/12/20 17:58:23 maroslaw Exp $
* @package    offline
* @subpackage attributes
 */

include_once("include/metabase.inc");

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
     * @public
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



    /**
     * Funkcja load_attributes laduje atrybuty do bazy danych.
     * Funkcja operuje na dwoch tablicach: attributes i attributes_names
     *
     * @return bool     
     *
     * @author rdiak@sote.pl
     */

    function load_attributes() {
		global $database;
		global $error;
		global $lang;
		
    	$data=$database->sql_select_multi_array4(array(
    													"id_main",
														"attribute1",
														"attribute2",
														"attribute3",
														"attribute4",
														"attribute5",
														"attribute6",
														"attribute7",
														"attribute8",
														"attribute9",
														"attribute10"),"attributes_names","");
		$k=0;
		foreach($data as $key=>$value) {
		$str="multi\n\n";
		$id_main=$value['id_main'];			
		$data1=$database->sql_select_multi_array4(array(
    													"id_main",
														"attribute1",
														"attribute2",
														"attribute3",
														"attribute4",
														"attribute5",
														"attribute6",
														"attribute7",
														"attribute8",
														"attribute9",
														"attribute10"),"attributes","id_main=$id_main");
		print "<pre>";
		//print_r($data1);
		print "<pre>";		
		for($i=1;$i<11;$i++) {
			$index="attribute".$i;
			if(empty($value[$index])) continue;
			$str.=$value[$index]."\n";
			foreach($data1 as $key1=>$value1) {
				if(empty($value1[$index])) continue;
				$str.=$value1[$index]."\n";
			}
			$str.="\n";
		}														
			$count=$database->sql_select("count(*)","main","user_id=$id_main");
			if($count > 0 ) {
				$result=$database->sql_update("main","user_id=$id_main",array("xml_options"=>$str));
			} else {
           		$k++;		
				$error->write_other("B³êdny user_id:".$id_main.". ".$lang->offline_file_errors['no_user_id'],"&nbsp;");
			} 
		}
		return $k;
    }

} // end class OfflineCategory

?>

<?php
/**
* Generowanie zapytania SQL na podstawie prezkazanych kategorii
* @version    $Id: gen_sql.inc.php,v 2.8 2006/04/03 13:48:22 lechu Exp $
* @package    category
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($global_secure_test)) || (! empty($_REQUEST['global_secure_test']))) {
    die ("Niedozwolone wywolanie");
}

class CategorySQL {
    /**
    * Generuj zapytanie SQL wg. kategorii
    *
    * @param  array  $category_tab array("1","3","5") oznacza category1=1 category2=3 category3=5
    * @param  int    $producer_id id filtru wg producenta
    * @param  string $idc IDC kategorii
    * \@global int    $config->category_multi sprawdzenie opcji w³±cznia obs³ugi category_multi
    *
    * @return string SQL
    */
    function query($category_tab,$producer_id='',$idc='') {
        global $theme,$config;
        
        $q_unavailable = '';
        if ($config->depository['show_unavailable'] != 1) {
            $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
        }
        
        $sql="SELECT * FROM main WHERE (";
        if ((! empty($producer_id) || !empty($q_unavailable))) {
            $sql.="(";
        }
        $size=sizeof($category_tab);
        reset($category_tab);
        for ($i=1;$i<=$size;$i++) {
            if (! ereg("^[0-9]+$",$category_tab[$i])) {
                $theme->go2main();
                die  ("Forbidden");
            }
            
            $sql.="id_category$i = '$category_tab[$i]' AND ";
        }
        $sql=substr($sql,0,strlen($sql)-4);

        
        $sql.=")";
     
        if ($config->category_multi==1) {
            $idc=addslashes($idc);
            $sql.=" OR id_category_multi_1='$idc' OR id_category_multi_2='$idc'";
        }
                   
        if ((! empty($producer_id) || !empty($q_unavailable))) {
            $sql.=" ) ";
            if (! empty($producer_id)) {
                $sql .= " AND id_producer='$producer_id' ";
            }
            if(!empty($q_unavailable)) {
                $sql .= $q_unavailable;
            }
        }
        return $sql;
    } // end query()
} // end class CategorySQL

$category_sql = new CategorySQL;

?>

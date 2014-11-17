<?php
/**
 * Generowanie zapytania SQL na podstawie prezkazanych kategorii
* @version    $Id: gen_sql.inc.php,v 2.4 2004/12/20 17:57:55 maroslaw Exp $
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
     * @param array $category_tab array("1","3","5") oznacza category1=1 category2=3 category3=5
     * @param int   $producer_id id filtru wg producenta
     * @return string SQL
     */   
    function query($category_tab,$producer_id='') {
        global $theme;
	
        $sql="SELECT * FROM main WHERE ";

        $size=sizeof($category_tab);
        reset($category_tab);
        for ($i=1;$i<=$size;$i++) {
	    if (! ereg("^[0-9]+$",$category_tab[$i])) {
	        $theme->go2main();
            die  ("<center>Bledne wywolanie</center>");
	    }
	   
        $sql.="id_category$i = '$category_tab[$i]' AND ";
        }
        $sql=substr($sql,0,strlen($sql)-4);
        if (! empty($producer_id)) {
            $sql.=" AND id_producer='$producer_id' ";
        }

        return $sql;
    } // end query()
} // end CategorySQL

$category_sql = new CategorySQL;

?>

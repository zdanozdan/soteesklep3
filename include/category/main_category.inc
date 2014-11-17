<?php
/**
* Obs³uga kategorii, konwersja kategorii i inne pomocnicze funkcje.
*
* @author  m@sote.pl
* @version $Id: main_category.inc,v 1.10 2004/12/20 18:02:58 maroslaw Exp $
* @package    include
*/

/**
* Operacje na kategoriach.
*/
class MainCategory {
    
    /**
    * Generuj ci±g IDC oznaczaj±cy ID kategorii.
    *
    * Przy wywo³aniu tej samej funkcji wiele razy system optymalizuje zwracane wyniki, zapamiêtuj±c
    * wykorzystane ID kategorii. Wywo³ujemy np. "Monitory/LCD", otrzymujemy "1_2"
    *
    * @author m@sote.pl
    * @param  string $category_multi ci±g z nazwami kategorii odseparowanych znakiem "/" np. "Monitory/LCD"
    * \@global array $__category_multi tablica z ID kategorii 1-5 array("1"=>array("Monitory"=>1,"TV"=>2),"2"=>array("LCD"=>2))
    *
    * @return string IDC np. 1, 1_2, 1_2_34, 2_7_15_6_7
    *
    * MainCategory::getIDCategory()
    */
    function getIDCategory($category_multi) {
        global $mdbd;
        global $__category_multi;
        
        $tabcat=split("/",$category_multi);
        $ltabcat=sizeof($tabcat);
        if ($ltabcat>0) {
            reset($tabcat);$i=1;$idc='';
            foreach ($tabcat as $cat) {
                $cat=trim($cat);
                if (empty($__category_multi[$i][$cat])) {
                    $id_cat=$mdbd->select("id","category$i","category$i=?",array($cat=>"text"),"LIMIT 1");
                    $__category_multi[$i][$cat]=$id_cat;
                } else $id_cat=$__category_multi[$i][$cat];
                if ($id_cat>0) {
                    $idc.=$id_cat."_";
                } else return '';
                $i++;
            }
        } else return '';
        
        // obetnij ostatni znak "_"
        $idc=substr($idc,0,strlen($idc)-1);
        
        return $idc;
    } // end getIDCategory()
} // end class MainCategory
?>

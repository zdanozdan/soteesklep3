<?php
/**
 * Recenzje dla danego produktu, tworzenie zapytania SQL, generowanie listy produktow
 *
 * @author piotrek@sote.pl
 * @version $Id: reviews.inc.php,v 2.7 2004/12/20 18:01:40 maroslaw Exp $
* @package    info
 */

if (! class_exists("Rec")) {
    class Rec {
        var $data=array();
    }
}

class ReviewsRow {

    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;

        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['id_product']=$db->FetchResult($result,$i,"id_product");
        $rec->data['description']=$db->FetchResult($result,$i,"description");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['score']=$db->FetchResult($result,$i,"score");
        $rec->data['author']=$db->FetchResult($result,$i,"author");
        
        $theme->reviews_row($rec);
        
        return;
     } // end record()
} // end class ReviewsRow


class Reviews {

    /**
     * Generuj zapytanie o recenzje do produktów
     *
     * @param addr adres obiektu $rec z danymi z bazy przegladanego produktu 
     * @return string zapytanie SQL
     */
    function query_reviews(&$rec) {
		global $config;
        global $theme;
		global $db;

        if (! empty($rec->data['id'])) {
            $id=$rec->data['id'];
        } else {
            $id="";
        }
        
        // sprawdz poprawnosc danych
        if (! ereg("^[0-9]+$",$id)) return;
                  
        $query="SELECT * FROM reviews WHERE id_product=$id AND state=1 AND lang='".$config->lang."'";                 
        
        // dodaj definicje sortowania wyniku
        $query.=" ORDER BY date_add DESC";
		         
        return $query;
    }
    
    /**
     * Pokaz recenzje do danego produktu
     *
     * @param addr adres obiektu $rec z danymi z bazy przegladanego produktu 
     */
    function show_reviews(&$rec) {
		global $config;
        global $theme;
		global $db;
		global $lang;

        $sql=$this->query_reviews($rec);		
        if (empty($sql)) return;

        $id=$rec->data['id'];
        $user_id=urlencode($rec->data['user_id']);
        $product=urlencode($rec->data['name']);
        
        $onclick=$theme->onclick("440","320");
        $score_link=$config->url_prefix."/plugins/_reviews/add.php?id=$id&user_id=$user_id&product=$product $onclick target=window"; 


		$dbedit=new DBEdit;

		$dbedit->page_records=20;      
		$dbedit->record_class="ReviewsRow";        
        $dbedit->start_list_element="<table border=0 width=100%>";
		$dbedit->end_list_element="<tr><td align=right><a href=$score_link><b>$lang->info_add_review</b></a></td></tr></table>\n\n";
        $dbedit->dbtype=$config->dbtype;               
        
        // nie wyswietlaj komuniakatu jesli nie ma recenzji do danego produktu
        $dbedit->empty_list_message="<BR>".$lang->info_review_empty."<BR><a href=$score_link><b>$lang->info_add_review</b></a>";
        $dbedit->record_list($sql);        

        return;
    } // end show_reviews()
     
} // end class Reviews;

$reviews = new Reviews;

$reviews->show_reviews($rec);

?>

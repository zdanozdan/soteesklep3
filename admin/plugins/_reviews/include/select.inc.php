<?php
/**
 * PHP Template:
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__reviewsdata tablica z wartosciami z tablicy reviews
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author m@sote.pl
 * @version $Id: select.inc.php,v 1.8 2005/10/20 06:45:08 krzys Exp $
 * \@depends admin/include/edit.inc.php
* @package    reviews
 */

global $db;
global $theme;
global $lang;

$__reviews_data=array();


if (empty($__query)) {
    $query="SELECT * FROM $table WHERE id=?";
} else $query=$__query;

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    if (empty($__query)) {
        $db->QuerySetText($prepared_query,1,$this->id);
    }
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if (empty($__query)) {
            $max=0;
        } else $max=$num_rows;;

        if ($num_rows>0) {
            
            // config
            $this->data['id']=$db->FetchResult($result,0,"id");
            $this->data['id_product']=$db->FetchResult($result,0,"id_product");
            $this->data['description']=$db->FetchResult($result,0,"description");
            $this->data['date_add']=$db->FetchResult($result,0,"date_add");
            $this->data['state']=$db->FetchResult($result,0,"state");
            $this->data['score']=$db->FetchResult($result,0,"score");
            $this->data['lang']=$db->FetchResult($result,0,"lang");
            $this->data['author']=$db->FetchResult($result,0,"author");
            $this->data['user_id']=$db->FetchResult($result,0,"user_id");
            $this->data['author_id']=$db->FetchResult($result,0,"author_id");
            
            // end
            
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Brak rekordu o id=$id");        
            }
        }
    } else die ($db->Error());
} else die ($db->Error());

?>

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
 * @version $Id: select.inc.php,v 1.2 2004/12/20 18:00:50 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    reviews
* @subpackage scores
 */

global $db;
global $theme;
global $lang;

$__scores_data=array();

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
            $this->data['score_amount']=$db->FetchResult($result,0,"score_amount");
            $this->data['scores_number']=$db->FetchResult($result,0,"scores_number");
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

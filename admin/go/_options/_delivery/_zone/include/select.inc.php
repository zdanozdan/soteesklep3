<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * /@global array $this->data tablica z atrybutami rekordu
 * /@global array $__currency tablica kursami walut
 * /@global array $__currency_name tablica id->nazwa waluty
 * /@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * @author m@sote.pl
 * @version $Id: select.inc.php,v 1.2 2004/11/26 08:59:47 scalak Exp $
 * @package currency 
 * /@depends admin/include/edit.inc.php
 */

global $db;
global $theme;
global $lang;


if (empty($__query)) {
    $query="SELECT * FROM  delivery_zone WHERE id=?";
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
            for ($i=0;$i<=$max;$i++) {
                // config
                $this->data['id']=$db->FetchResult($result,$i,"id");
                $this->data['name']=$db->FetchResult($result,$i,"name");
                $this->data['country']=$db->FetchResult($result,$i,"country");
                // end
                
            } // end for
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Brak rekordu o id=$id");        
            }
        }
    } else die ($db->Error());
} else die ($db->Error());
?>
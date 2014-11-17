<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * @global array $this->data tablica z atrybutami rekordu
 * @global array $__depositorydata tablica z wartosciami z tablicy depository
 * @global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  
 * @template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
 * @package soteesklep 
 * @depends admin/include/edit.inc.php
 */

global $db;
global $theme;
global $lang;

$__depository_data=array();

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
            for ($i=0;$i<=$max;$i++) {
                // config
                $this->data['id']=$db->FetchResult($result,$i,"id");
                $this->data['user_id_main']=$db->FetchResult($result,$i,"user_id_main");
                $this->data['num']=$db->FetchResult($result,$i,"num");
                $this->data['min_num']=$db->FetchResult($result,$i,"min_num");
                $this->data['id_deliverer']=$db->FetchResult($result,$i,"id_deliverer");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__depository_data[$this->data['id']]=$this->data['id'];
                }
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
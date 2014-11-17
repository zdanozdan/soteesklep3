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
* @version $Id: select.inc.php,v 2.7 2005/01/12 09:23:10 maroslaw Exp $
* /@depends admin/include/edit.inc.php
* @package    currency
*/

global $db;
global $theme;
global $lang;
global $__currency,$currency_name,$table;

$table="currency";

global $__currency_name;
$__currency=array();
$__currency_name=array();

if (empty($__query)) {
    $query="SELECT * FROM currency WHERE id=?";
} else $query=$__query;


if (! empty($this->id)) {

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
                    $this->data['currency_name']=$db->FetchResult($result,$i,"currency_name");
                    $this->data['currency_val']=$db->FetchResult($result,$i,"currency_val");
                    // end

                    // zapamietaj w talicy kurs waluty
                    if (! empty($this->data['id'])) {
                        $__currency[$this->data['id']]=$this->data['currency_val'];
                        $__currency_name[$this->data['id']]=$this->data['currency_name'];
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

}

?>

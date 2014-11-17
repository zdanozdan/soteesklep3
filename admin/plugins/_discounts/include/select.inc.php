<?php
/**
 * PHP Template:
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__discountsdata tablica z wartosciami z tablicy discounts
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author piotrek@sote.pl
 * \@template_version Id: select.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: select.inc.php,v 2.3 2004/12/20 17:59:47 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    discounts
 */

global $db;
global $theme;
global $lang;

if (@$this->secure_test!=true) die ("Bledne wywolanie");
require_once ("./include/discounts.inc.php");
$discounts = new Discounts;

// zwroc 0 jesli cioag jest pusty, w p.w. zwroc to samo co na wejsciu
function set0($val) {
    if (empty($val)) return 0;
    else return $val;
}

$__discounts_data=array();

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
                $this->data['idc']=$db->FetchResult($result,$i,"idc");
                $this->data['idc_name']=$db->FetchResult($result,$i,"idc_name");
                $this->data['id_producer']=$db->FetchResult($result,$i,"id_producer");
                $this->data['producer_name']=$db->FetchResult($result,$i,"producer_name");
                $this->data['idc_name']=$db->FetchResult($result,$i,"idc_name");
                $this->data['discount']=$discounts->get_discount(set0($db->FetchResult($result,$i,"discount")));
                $this->data['discount_cat']=$discounts->get_discount(set0($db->FetchResult($result,$i,"discount_cat")));
                $this->data['discount_producer']=$discounts->get_discount(set0($db->FetchResult($result,$i,"discount_producer")));

                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__discounts_data[$this->data['id']]=$this->data['idc'];
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

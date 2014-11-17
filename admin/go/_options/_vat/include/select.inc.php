<?php
/**
 * PHP Template:
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__vatdata tablica z wartosciami z tablicy vat
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author m@sote.pl
 * \@template_version Id: select.inc.php,v 2.1 2003/03/13 11:28:54 maroslaw Exp
 * @version $Id: select.inc.php,v 1.2 2004/12/20 17:58:45 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    options
* @subpackage vat
 */

global $db;
global $theme;
global $lang;

$__vat_data=array();

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
                $this->data['vat']=$db->FetchResult($result,$i,"vat");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__vat_data[$this->data['id']]=$this->data['vat'];
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

/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszary okreslone jako 
// config
... tu edytujemy
// end
 
*/
?>

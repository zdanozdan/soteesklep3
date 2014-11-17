<?php
/**
 * PHP Template:
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__discounts_groupsdata tablica z wartosciami z tablicy discounts_groups
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author m@sote.pl
 * \@template_version Id: select.inc.php,v 2.1 2003/03/13 11:28:54 maroslaw Exp
 * @version $Id: select.inc.php,v 1.4 2004/12/20 17:59:43 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    discounts
* @subpackage discounts_groups
 */

global $db;
global $theme;
global $lang;

$__discounts_groups_data=array();

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
                $this->data['user_id']=$db->FetchResult($result,$i,"user_id");
                $this->data['group_name']=$db->FetchResult($result,$i,"group_name");
                $this->data['default_discount']=$db->FetchResult($result,$i,"default_discount");
                $this->data['public']=$db->FetchResult($result,$i,"public");
                $this->data['photo']=$db->FetchResult($result,$i,"photo");
                $this->data['group_amount']=$db->FetchResult($result,$i,"group_amount");
                $this->data['calculate_period']=$db->FetchResult($result,$i,"calculate_period");
                // end

                // start happy hour
                $this->data['start_date']=$db->FetchResult($result,$i,"start_date");
                $this->data['end_date']=$db->FetchResult($result,$i,"end_date");
                // end happy hour

                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__discounts_groups_data[$this->data['id']]=$this->data['user_id'];
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

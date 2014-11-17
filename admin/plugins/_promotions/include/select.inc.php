<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__promotionsdata tablica z wartosciami z tablicy promotions
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  m@sote.pl
 * \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.4 2004/12/20 18:00:46 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    promotions
 */

global $db;
global $theme;
global $lang;

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

$__promotions_data=array();

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
                $this->data['name']=$db->FetchResult($result,$i,"name");
                $this->data['active']=$db->FetchResult($result,$i,"active");
                $this->data['discount']=$db->FetchResult($result,$i,"discount");
                for ($j=1;$j<=10;$j++) {                    
                    $this->data['code'.$j]=$db->FetchResult($result,$i,"code".$j);
                    $this->data['code'.$j]=$my_crypt->endecrypt("",$this->data['code'.$j],"de");
                }
                $this->data['amount']=$db->FetchResult($result,$i,"amount");
                $this->data['short_description']=$db->FetchResult($result,$i,"short_description");
                $this->data['description']=$db->FetchResult($result,$i,"description");
                $this->data['photo']=$db->FetchResult($result,$i,"photo");
                $this->data['active_code']=$db->FetchResult($result,$i,"active_code");
                $this->data['lang']=$db->FetchResult($result,$i,"lang");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__promotions_data[$this->data['id']]=$this->data['name'];
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

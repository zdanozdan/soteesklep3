<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__main_keysdata tablica z wartosciami z tablicy main_keys
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  m@sote.pl
 * \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.3 2004/12/20 18:00:03 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    main_keys
 */

global $db;
global $theme;
global $lang;

$__main_keys_data=array();

if (empty($__query)) {
    $query="SELECT * FROM $table WHERE id=?";
} else $query=$__query;

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

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
                $this->data['order_id']=$db->FetchResult($result,$i,"order_id");
                $main_key=$db->FetchResult($result,$i,"main_key");
                $this->data['main_key']=$my_crypt->endecrypt("",$main_key,"de");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__main_keys_data[$this->data['id']]=$this->data['user_id_main'];
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

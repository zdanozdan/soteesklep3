<?php
/**
* Odczytaj dane rekordu i zapamietaj je w $this->data
*
* @author m@sote.pl
* @version $Id: select.inc.php,v 2.3 2004/12/20 17:57:48 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

/**
* \@global array $this->data tablica z atrybutami rekordu
* \@global array $__admin_users_typedata tablica z wartosciami z tablicy admin_users_type
* \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
* \@depends admin/include/edit.inc.php
*/

global $db;
global $theme;
global $lang;
global $config;

$__admin_users_type_data=array();

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
                $this->data['type']=$db->FetchResult($result,$i,"type");
                foreach ($config->admin_perm as $perm) {
                    $this->data["p_$perm"]=$db->FetchResult($result,$i,"p_$perm");
                }
                // end

                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__admin_users_type_data[$this->data['id']]=$this->data['type'];
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

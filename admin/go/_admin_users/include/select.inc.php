<?php
/**
* Odczytaj dane rekordu i zapamietaj je w $this->data 
*
* @author m@sote.pl
* @version $Id: select.inc.php,v 2.2 2004/12/20 17:57:53 maroslaw Exp $
* @package    admin_users
*/

/**
* \@global array $this->data tablica z atrybutami rekordu
* \@global array $__admin_usersdata tablica z wartosciami z tablicy admin_users
* \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli

*/
global $db;
global $theme;
global $lang;

/**
* Klucze kodowania.
*/
require_once ("include/keys.inc.php");
global $__key,$__secure_key;

/**
* Obs³uga kodowania.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

$__admin_users_data=array();

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
                $this->data['login']=$db->FetchResult($result,$i,"login");
                $this->data['id_admin_users_type']=$db->FetchResult($result,$i,"id_admin_users_type");
                $this->data['active']=$db->Fetchresult($result,$i,"active");

                // odczytaj i odkoduj haslo
                $crypt_password=$db->FetchResult($result,$i,"password");
                $password=$my_crypt->endecrypt($__secure_key,$crypt_password,"de");
                $this->data['password']=$password;

                if ($this->data['id_admin_users_type']!=1) {
                    $this->data['new_password']=$this->data['password'];
                    $this->data['new_password2']=$this->data['password'];
                }
                // end

                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__admin_users_data[$this->data['id']]=$this->data['login'];
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

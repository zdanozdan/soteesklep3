<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__partnersdata tablica z wartosciami z tablicy partners
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  pmalinski@sote.pl
 * \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.3 2006/01/20 10:20:12 lechu Exp $
 * \@depends admin/include/edit.inc.php
* @package    partners
 */

global $db;
global $theme;
global $lang;
global $my_crypt, $config;

$prv_key=md5($config->salt);

$__partners_data=array();

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
                $this->data['partner_id']=$db->FetchResult($result,$i,"partner_id");
                $this->data['www']=$db->FetchResult($result,$i,"www");
                $this->data['email']=$db->FetchResult($result,$i,"email");
                $this->data['rake_off']=$db->FetchResult($result,$i,"rake_off");
                $this->data['crypt_password']=$db->FetchResult($result,$i,"crypt_password");
                $this->data['password'] = $my_crypt->endecrypt($prv_key,$this->data['crypt_password'],"de");

                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__partners_data[$this->data['id']]=$this->data['name'];
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


// pobierz login i has³o
$query="SELECT * FROM users WHERE id_partner=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$this->id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $this->data['id_user'] = $db->FetchResult($result,0,"id");
            $this->data['login'] = $my_crypt->endecrypt($prv_key,$db->FetchResult($result,0,"crypt_login"),"de");
        }
    } else die ($db->Error());
} else die ($db->Error());
?>

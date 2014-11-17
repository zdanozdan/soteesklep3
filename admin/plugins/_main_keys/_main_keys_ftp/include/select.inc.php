<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__main_keys_ftpdata tablica z wartosciami z tablicy main_keys_ftp
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  m@sote.pl
 * \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.3 2004/12/20 17:59:57 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    main_keys
* @subpackage main_keys_ftp
 */

global $db;
global $theme;
global $lang;

$__main_keys_ftp_data=array();

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
                $this->data['ftp']=$db->FetchResult($result,$i,"ftp");
                $this->data['active']=$db->FetchResult($result,$i,"active");
                $this->data['user_id_main']=$db->FetchResult($result,$i,"user_id_main");
                $this->data['demo']=$db->FetchResult($result,$i,"demo");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__main_keys_ftp_data[$this->data['id']]=$this->data['ftp'];
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

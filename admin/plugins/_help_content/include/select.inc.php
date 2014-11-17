<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * 2. Generuj tablice $__currency z walutami i kursami
 *
 * \@global array $this->data tablica z atrybutami rekordu
 * \@global array $__help_contentdata tablica z wartosciami z tablicy help_content
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author  lech@sote.pl
 * \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: select.inc.php,v 1.3 2004/12/20 17:59:52 maroslaw Exp $
 * \@depends admin/include/edit.inc.php
* @package    help_content
 */

global $db;
global $theme;
global $lang;

$__help_content_data=array();

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
                $this->data['title']=$db->FetchResult($result,$i,"title");
                $this->data['html']=$db->FetchResult($result,$i,"html");
                $this->data['author']=$db->FetchResult($result,$i,"author");
                $this->data['title_en']=$db->FetchResult($result,$i,"title_en");
                $this->data['html_en']=$db->FetchResult($result,$i,"html_en");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__help_content_data[$this->data['id']]=$this->data['title'];
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

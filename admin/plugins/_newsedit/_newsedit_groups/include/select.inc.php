<?php
/**
* 1. Odczytaj dane rekordu i zapamietaj je w $this->data
* 2. Generuj tablice $__currency z walutami i kursami
*
* \@global array $this->data tablica z atrybutami rekordu
* \@global array $__newsedit_groupsdata tablica z wartosciami z tablicy newsedit_groups
* \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
*
* @author  m@sote.pl
* \@template_version Id: select.inc.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
* @version $Id: select.inc.php,v 1.5 2004/12/20 18:00:08 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

global $db;
global $theme;
global $lang;

$__newsedit_groups_data=array();

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
                $this->data['template_info']=$db->FetchResult($result,$i,"template_info");
                $this->data['template_row']=$db->FetchResult($result,$i,"template_row");
                $this->data['multi']=$db->FetchResult($result,$i,"multi");
                // end
                
                // zapamietaj w talicy wartosc z tablicy, wartosc ta zostanie
                // przekazane do zapiania w pliku konfiguracyjnym
                if (! empty($this->data['id'])) {
                    $__newsedit_groups_data[$this->data['id']]=$this->data['name'];
                }
            } // end for
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Forbidden: Unknown ID=$id");
            }
        }
    } else die ($db->Error());
} else die ($db->Error());

?>

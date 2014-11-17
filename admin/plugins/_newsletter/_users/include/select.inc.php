<?php
/**
* Odczytanie danych adresu e-mail. Dane wy¶wietlane w edycji adresu.
*
* 1. Odczytaj dane rekordu i zapamietaj je w $this->data
* 2. Generuj tablice $__currency z walutami i kursami
*
* @author  rdiak@sote.pl
* @version $Id: select.inc.php,v 2.6 2004/12/20 18:00:20 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

global $db;
global $theme;
global $lang;

$query="SELECT * FROM newsletter WHERE id=?";

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
                $this->data['email']=$db->FetchResult($result,$i,"email");
                $this->data['status']=$db->FetchResult($result,$i,"status");
                $this->data['active']=$db->FetchResult($result,$i,"active");
                $this->data['groups']=$db->FetchResult($result,$i,"groups");
                $this->data['lang']=$db->FetchResult($result,$i,"lang");                
            }
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Unknown record id=$id");
            }
        }
    } else die ($db->Error());
} else die ($db->Error());
?>

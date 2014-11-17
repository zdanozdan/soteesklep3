<?php
/**
* Odczytanie danych grupy adresów e-mail.
*
* 1. Odczytaj dane rekordu i zapamietaj je w $this->data
* 2. Generuj tablice $__currency z walutami i kursami
*
* @author  rdiak@sote.pl
* @version $Id: select.inc.php,v 2.8 2005/08/03 08:41:24 lukasz Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

global $db;
global $theme;
global $lang;

$query="SELECT * FROM $table WHERE id=?";

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
                $this->data['name']=$db->FetchResult($result,$i,"name");
                $this->data['count']=$db->FetchResult($result,$i,"count");
                
            }
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Brak rekordu o id=$id");
            }
        }
    } else die ($db->Error());
} else die ($db->Error());
?>

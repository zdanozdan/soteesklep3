<?php
/**
 * 1. Odczytaj dane rekordu i zapamietaj je w $this->data
 * @author rdiak@sote.pl
 * @version $Id: select.inc.php,v 1.3 2005/02/09 13:56:01 scalak Exp $
 * @package volume 
 * /@depends admin/include/edit.inc.php
 */

global $db;
global $theme;
global $lang;


if (empty($__query)) {
    $query="SELECT * FROM  delivery_volume WHERE id=?";
} else $query=$__query;

//print $query;
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
                $this->data['range_max']=$db->FetchResult($result,$i,"range_max");
                // end
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
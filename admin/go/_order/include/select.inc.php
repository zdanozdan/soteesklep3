<?php
/**
* Odczytaj dane transakcji z bazy i zapamiêtaj w zmiennej $rec->data
*
* @author  m@sote.pl
* @version $Id: select.inc.php,v 2.4 2004/12/20 17:58:58 maroslaw Exp $
*
* \@global int   $id        ID systemowe transakcji
* \@global array $rec->data dane transakcji
* @package    order
*/

if (! empty($id)) {
    $query="SELECT * FROM order_register WHERE id=?";
    $set_id=$id;
}

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$set_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            /**
            * Odczytaj w³a¶ciwo¶ci transakcji i zapamiêtaj je w tablicy $rec->data.
            */
            require_once("./include/query_rec.inc.php");
        } else {
            $theme->head_window();
            print $lang->order_unknown;
            $theme->foot_window();
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());

// odczytaj nazwe dostawcy
$query="SELECT id,name FROM delivery WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$rec->data['id_delivery']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['delivery_name']=$db->FetchResult($result,0,"name");
        } else $rec->data['delivery_name']="-";
    } else die ($db->Error());
} else die ($db->Error());

?>

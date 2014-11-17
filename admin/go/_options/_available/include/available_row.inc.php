<?php
/**
* @version    $Id: available_row.inc.php,v 2.4 2005/11/18 15:36:15 lechu Exp $
* @package    options
* @subpackage available
*/

class Rec {
    var $data=array();
}

class AvailableRow {
    function record($result,$i) {
        global $db;
        global $theme, $intervals_by_from, $intervals, $error_intervals_message, $lang;

        $rec = new Rec;

        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['num_from']=$db->FetchResult($result,$i,"num_from");
        $rec->data['num_to']=$db->FetchResult($result,$i,"num_to");
        
        $intervals[$rec->data['user_id']]['from'] = $rec->data['num_from'];
        $intervals[$rec->data['user_id']]['to'] = $rec->data['num_to'];
        
        if(!isset($intervals_by_from[$rec->data['num_from']])) {
            $intervals_by_from[$rec->data['num_from']] = $rec->data['num_to'];
        }
        else {
            $error_intervals_message = $lang->error_message["duplicated_from_value"]; // 2 przedzia³y zaczynaj± siê od tej samej liczby
        }

        include ("./html/available_row.html.php");

        return;
    } // end record()
} // end class DeliveryRow
?>

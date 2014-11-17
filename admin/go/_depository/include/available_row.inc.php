<?php
/**
* @version    $Id: available_row.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
* @package    options
* @subpackage available
*/

class Rec {
    var $data=array();
}

class AvailableRow {
    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;

        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");

        include ("./html/available_row.html.php");

        return;
    } // end record()
} // end class DeliveryRow
?>

<?php
/**
* Klasa prezentacji wiersza rekordu z tabeli admin_users
*
* @author m@sote.pl
* @version $Id: row.inc.php,v 2.5 2004/12/20 17:57:53 maroslaw Exp $
* @package    admin_users
*/

/**
* Odczytaj typy uzytkownikow wg id. z tabeli amdin_users_type
* return $__admin_users_type
*/
include_once ("./include/admin_users_type.inc.php");

/**
* @ignore
* @package admin_users
*/
class Rec {
    var $data=array();
}

/**
* @ignore
* @package admin_users
*/
class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;
        global $__admin_users_type;

        $rec = new Rec;

        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['login']=$db->FetchResult($result,$i,"login");
        $rec->data['password']=$db->FetchResult($result,$i,"password");
        $rec->data['active']=$db->FetchResult($result,$i,"active");

        $id_admin_users_type=$db->FetchResult($result,$i,"id_admin_users_type");
        $rec->data['id_admin_users_type']=$id_admin_users_type;
        if (! empty($__admin_users_type[$id_admin_users_type])) {
            $rec->data['type']=$__admin_users_type[$id_admin_users_type];
        } else {
            $rec->data['type']='';
        }
        // end

        /**
        * Prezentacja wiersza.
        */
        include ("./html/row.html.php");

        return;
    } // end record()

} // end class Row
?>

<?php
/**
* Wy¶wietl rachunek/fakturê.
*
* @author  rdiak@sote.pl m@sote.pl
* @version $Id: invoice.php,v 2.5 2005/01/20 14:59:34 maroslaw Exp $
* @package    order
*/

/**
* \@require $id GET
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
require_once ("include/currency.inc.php");
require_once ("include/my_crypt.inc");
require_once ("./include/order_func.inc.php");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
} else {
    die ("Forbidden: ID");
}

// wywolano aktualizacje transakcji
if (@$_POST['update']==true) {
    include_once ("./include/order_update.inc.php");
}

// odczytaj dane transakcji
$query="SELECT * FROM order_register WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // odczytaj wlasciowasi transakcji
            require_once("./include/query_rec.inc.php");
        } else die ("Forbidden: unknown order");
    } else die ($db->Error());
} else die ($db->Error());

// odkoduj zakodowane dane
$my_crypt = new MyCrypt;
$rec->data['email']=$my_crypt->endecrypt("",$rec->data['crypt_email'],"de");
$rec->data['xml_description']=$my_crypt->endecrypt("",$rec->data['crypt_xml_description'],"de");
$rec->data['xml_user']=$my_crypt->endecrypt("",$rec->data['crypt_xml_user'],"de");
$rec->data['name']=$my_crypt->endecrypt("",$rec->data['crypt_name'],"de");

require_once("./include/xml2html.inc.php");
$xml2html = new OrderXML2HTML;
$rec->data['html_xml_description']=$xml2html->xml_description($rec->data['xml_description']);
$rec->data['html_xml_user']=$xml2html->xml_user($rec->data['xml_user']);

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

$theme->head_window();

// wstaw link do edycji danych uzytkwonika
if (! empty($rec->data['id_user'])) {
    $id_user=&$rec->data['id_user'];
    print "<div align=right>";
    if ($config->nccp==0x1388) {
        //        $buttons->menu_buttons(array($lang->order_go2_users=>"/go/_users/edit.php?id=$id_user"));
    }
    print "</div>";
}
//$theme->bar($lang->bar_title["order_edit"]." ".$rec->data['order_id']);
$theme->invoice($rec,$xml2html);

$theme->foot_window();
include_once ("include/foot.inc");
?>

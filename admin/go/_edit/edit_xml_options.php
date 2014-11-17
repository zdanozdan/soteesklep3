<?php
/**
* Formularz edycji opcji zaawansowanych (pole xml_options).
* 
* @author  m@sote.pl
* @version $Id: edit_xml_options.php,v 2.4 2005/01/20 14:59:20 maroslaw Exp $
* @supackage edit
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
} else {
    die ("Forbidden: Unknown ID");
}

if (! empty($_REQUEST['update'])) {
    $update=$_REQUEST['update'];
} else {
    $update=false;
}

$theme->head_window();

// aktualizuj dane produktu
$update_info="";
if ($update==true) {
    include ("include/edit_update_xml_options.inc.php");
    if (empty($upload->error)) {
        $update_info=$lang->edit_update_ok;
    } else {
        $error=$upload->error;
    }
}

$query="SELECT * FROM main WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            require_once("include/query_rec.inc.php");
            $theme->bar($lang->bar_title['xml_options'].": ".$rec->data['name']);                    
            require_once("html/edit_xml_options.html.php");
        } else {
             die ($lang->edit_errors['unknown_product']);
        }
    }
} else {
    die ($db->Error());    
}

$theme->foot_window();
include_once ("include/foot.inc");
?>

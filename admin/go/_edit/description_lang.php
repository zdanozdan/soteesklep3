<?php
/**
* Formularz edycji opisu produktu.
*
* @author  m@sote.pl
* @version $Id: description_lang.php,v 2.4 2005/03/14 13:44:52 lechu Exp $
* @supackage edit
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
* \@lang
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $user_id=addslashes(@$_REQUEST['user_id']);
} else {
    die ("Forbidden: Unknown ID");
}

if (! empty($_REQUEST['update'])) {
    $update=$_REQUEST['update'];
} else {
    $update=false;
}

// menu
include_once ("./include/menu.inc.php");

$theme->head_window();

// aktualizuj dane produktu
$update_info="";
if ($update==true) {
    include ("include/edit_update_description_upload.inc.php");
    include ("include/edit_update_description.inc.php");
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
            $theme->bar("$lang->edit_desc: ".$rec->data['name']);
            require_once("html/edit_page_description.html.php");
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

<?php
/**
* Zmieñ PIN.
*
* @author m@sote.pl
* @version $Id: index.php,v 2.4 2005/01/20 14:59:17 maroslaw Exp $
* @package    admin_users
* @subpackage pin
*/
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³owek skryptu.
*/
require_once ("../../../../include/head.inc");

if (! empty($_POST['item'])) {
    $item=$_POST['item'];
} else $item=array();
include("../lang/_$config->lang/lang.inc.php");
// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu_pin.inc.php");
$theme->bar($lang->pin_title);

require_once ("include/form_check.inc");
require_once ("./include/FormPinFunctions.inc.php");
$form_check = new FormPinFunctions;
$theme->form_check=&$form_check;

$form_check->form=$item;
$form_check->errors=$lang->pin_form_errors;
$form_check->fun=array("pin"=>"f_pin",
"new"=>"f_new",
"new2"=>"f_new2");

if (! empty($_POST['update'])) {
    $form_check->check=true;
    if ($form_check->form_test()) {
        print "<p><center>$lang->pin_changed</center>";
        $__new_pin=$item['new'];
        include_once ("./include/new_pin_gen.inc.php");
    } else {
        include_once ("./html/pin.html.php");
    }
} else {
    include_once ("./html/pin.html.php");
}

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

<?php
/**
* Ustawienia zwiazane z edycja/dodaniem produktu. Zapisanie danych w pliku konfiguracyjnym.
*
* @author  m@sote.pl
* @vresion $Id: setup.php,v 2.6 2005/01/20 14:59:21 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @version    $Id: setup.php,v 2.6 2005/01/20 14:59:21 maroslaw Exp $
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/currency.inc.php");
require_once ("include/image.inc.php");
require_once ("./include/select_category.inc.php");
require_once ("./include/functions.inc.php");
require_once ("./config/config.inc.php");

$form_elements->type="edit"; // nie pokazuj zaznaczonych elementow select

// inicju ID
$__id=&$id;
if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    $__id=$id;
}

// parametr id moze byc przekazany w dodaniu produktu
// tam jest includowany ten plik, po wprowadzeniu nowego rekordu
if (empty($id)) {
    die ("Forbidden: Unknown ID");
}

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

$theme->head_window();

// menu
include_once ("./include/menu.inc.php");
$theme->bar($lang->edit_setup_title);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

// generuj plik konfiguracyjny z ustawieniami w ./config/config.inc.php
if (! empty($_REQUEST['update'])) {
    require_once ("./include/local_gen_config.inc.php");
    $comm=$gen_config->gen(array("netto"=>@$item['netto']));
    $edit_config->netto=@$item['netto'];
} else {
    $item['netto']=$edit_config->netto;
}
// end

// wyswietl formularz
include_once ("./html/setup.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>

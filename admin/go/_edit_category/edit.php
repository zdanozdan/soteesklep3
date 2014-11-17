<?php
/**
 * Edytuj rekord z tabeli category$deep ;  $deep=[1-5]
 * 
 * @author  m@sote.pl
 * \@template_version Id: edit.php,v 2.3 2003/06/20 12:41:22 maroslaw Exp
 * @version $Id: edit.php,v 1.5 2005/01/20 14:59:23 maroslaw Exp $
* @package    edit_category
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
if(!empty($_REQUEST['item']['category'])) {
    $_REQUEST['item']['category'] = str_replace('"', "''", $_REQUEST['item']['category']);
    $_POST['item']['category'] = $_REQUEST['item']['category'];
}
if (ereg("^[0-9]+$",@$_REQUEST['deep'])) {
    $deep=$_REQUEST['deep'];
} else $deep=1;
$__deep=&$deep;

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

$theme->head_window();
$theme->bar($lang->edit_category_update_bar." $__deep");

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("category$__deep","",array("category"=>"category"),
                   $lang->edit_category_form_errors
                   );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>

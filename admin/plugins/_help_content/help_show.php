<?php
/**
* Wy¶wietlanie artyku³u pomocy
*
* @author  lech@sote.pl
* \@template_version Id: index.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
* @version $Id: help_show.php,v 1.8 2005/12/13 15:57:08 krzys Exp $
* @package    help_content
*/


// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
$theme->head_window();
?>


<?php
global $_REQUEST;
$help_id = addslashes($_REQUEST["id"]);
if (! ereg("^[0-9]+$",$help_id)) {
    die ("Forbidden: help_id");
}
$ar_data = $mdbd->select("title,author,date_add,date_update,html,active,title_en,html_en", "help_content", "id=?",
array($help_id=>"int"));

$title = $ar_data['title'];
$author = $ar_data['author'];
$date_add = $ar_data['date_add'];
$date_update = $ar_data['date_update'];
$html = $ar_data['html'];
$title_en = $ar_data['title_en'];
$html_en = $ar_data['html_en'];

if(@$_GET['print']==1){
include ("./html/help_show_print.html");	
}else{
include("./html/help_show.html");
}

$theme->foot_window();

include_once ("include/foot.inc");
?>

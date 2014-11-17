<?php
/**
 * Edycja wygladu, edycja wlasciwosci, typow kategorii (menu)
 *
 * @author  m@sote.pl
 * @version $Id: category.php,v 1.4 2005/01/20 15:00:11 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include ("include/menu.inc.php");
$theme->bar($lang->themes_titles['category']);

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['category'])) {
    $category=$_REQUEST['category'];
    $ftp->connect();    
    $gen_config->gen(array("category"=>$category));
    $ftp->close();
    $config->category=$category;
}

include_once ("./html/category.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

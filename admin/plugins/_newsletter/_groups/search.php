<?php
/**
* Formularz wyszukiwnia adersów e-mail oraz wyswietlenie wyników wyszukiwania.
*
* @author  rdiak@sote.pl
* @version $Id: search.php,v 2.10 2005/01/20 14:59:59 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");

if (! empty($_REQUEST['search'])) {
    $search=$_REQUEST['search'];
} else {
    $search=false;
}

// config
$bar=$lang->bar_title['newsletter'];
include_once ("./include/list_th.inc.php");
$list_th=groups_list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

$action="search.php";
if ($search==true) {
    if (empty($_POST['item']['string'])) {
        include_once ("./include/menu.inc.php");
        $theme->bar($lang->newsletter_search_groups);
        include_once ("./html/newsletter_search.html.php");
    } else {
        $string=$_POST['item']['string'];
        $string=addslashes($string);
        $sql="SELECT * FROM newsletter_groups WHERE name like '%$string%'";
        $bar=$lang->newsletter_search_groups;
        require_once ("include/list.inc.php");
    }
} else {
    include_once ("./include/menu.inc.php");
    $theme->bar($lang->newsletter_search_groups);
    include_once ("./html/newsletter_search.html.php");
}


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

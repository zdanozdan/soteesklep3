<?php
/**
* Wynik wyszukiwania adresow e-mail
*
* @author  rdiak@sote.pl
* @version $Id: search.php,v 2.7 2005/01/20 15:00:01 maroslaw Exp $
*
* verified 2004-09-03 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");

$theme->head();
$theme->page_open_head();
if (! empty($_REQUEST['search'])) {
    $search=$_REQUEST['search'];
} else {
    $search=false;
}

$action="search.php";
if ($search==true) {
    
    if (empty($_POST['item']['string'])) {
        include_once ("./include/menu.inc.php");
        $theme->bar($lang->newsletter_search_users);
        include_once ("./html/newsletter_search.html.php");
    } else {
        $string=$_POST['item']['string'];
        $string=addslashes($string);
        $sql="SELECT * FROM newsletter WHERE email like '%$string%'";
        $bar=$lang->newsletter_search_users;
        include_once ("./include/list_th.inc.php");
        $list_th=newsletter_list_th();
        require_once ("include/list.inc.php");
    }
} else {
    include_once ("./include/menu.inc.php");
    $theme->bar($lang->newsletter_search_users);
    include_once ("./html/newsletter_search.html.php");
}

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

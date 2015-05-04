<?php
/**
* Wyswietl kategroie z odpowiednimi opcjami, sprawdz jaki system kategorii wyswietlic
*
* @author  m@sote.pl
* @version $Id: category_show.inc,v 2.11 2005/08/03 13:58:48 maroslaw Exp $
* @package category
*/

global $config;
global $_SESSION;
global $_REQUEST;
global $sess;
global $__producer_filter;

if (in_array("producers_category",$config->plugins)) {
    $producer_filter=0;
    if (! empty($_REQUEST['producer_filter'])) $producer_filter=$_REQUEST['producer_filter'];
    if ((empty($producer_filter)) && (! empty($_SESSION['__producer_filter'])) && (@$_REQUEST['producer_filter']!="0")) {
        $producer_filter=$_SESSION['__producer_filter'];
    }
    $__producer_filter=$producer_filter;
    // $this->producers_category();
} // end plugin test

//$config->category['type']="standard"; // wylacz standardowe statyczne menu
//$config->category['openall']=0;       // domyslnie zamknij kategorie

include_once ("include/category.inc");
$cat = new NavbarCategory;
$cat->init();

$sess->register("__producer_filter",$__producer_filter);
?>
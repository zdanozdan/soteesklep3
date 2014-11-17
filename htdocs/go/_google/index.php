<?php
/**
 * Strona generujaca przekierowanie na odpowiedni adres do sklepu, ze strony zaindeksowanej.
 * Je¶li jest wykryty system indeksuj±cy, to nie ma przekierowania, tylko wywo³ywana jest odpowiednia tre¶c strony
 * dostosowana do indeksowania.
 * 
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.1 2005/08/08 14:21:42 maroslaw Exp $
 * @package  google
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga Google
*/
require_once ("include/google_main.inc");
$google =& new GoogleMain();

// rozpoznanie czy jest to strona info, html, newsow, czy kategorii
$uri=$_SERVER['REQUEST_URI'];$file_uri=substr($uri,6,strlen($uri)-11);
$type='';
if (ereg("^cat_",$file_uri)) {
    $type="category";
    $val=substr($file_uri,4,strlen($file_uri)-4);
    $uri="/go/_category/?idc=$val";
} elseif (ereg("^html_",$file_uri)) {
    $type="html";
    $val=substr($file_uri,5,strlen($file_uri)-5);
    $uri="/go/_files/?file=$val".".html";
} else {
    $type="product";
    $val=$file_uri;
    $uri="/go/_info/?id=$file_uri";
}

if ($google->changeTheme()=="google") {
   //    require_once ("HTTP/Client.php");
   //    $http =& new HTTP_Client();
    
    
   //    $ruri=$_SERVER['REQUEST_URI'];
   //    $ruri=ereg_replace("\/html\/","/html_google/",$ruri);
   //    $http->get("http://".$_SERVER['HTTP_HOST'].$ruri);    
   // $body=$http->_responses[0]['body'];
   // print $body;
    
} else {
    header ("Location: http://".$_SERVER['HTTP_HOST'].$uri);
    exit;    
}

include_once ("include/foot.inc");
?>

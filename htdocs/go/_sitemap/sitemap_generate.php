<?php
/**
* Generowanie pelnej mapy HTML dla wszystkich produktow i kategorii
*
* @author  tomasz@mikran.pl
* @version $Id: index.php,v 1.2 2007/04/16 14:49:09 tomasz Exp $
* @package    sitemap
*/
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// zapytamie o produkty w promocji, nowowsci itp
$sql = "SELECT * FROM main where active = '1'";
$result=$db->Query($sql);
if ($result==0) {
    $db->Error();
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/google_sitemap.inc");
include_once ("GsgXml.php");
$sitemap = new DBGoogleSiteMap;
$gsmap = $sitemap->get();

$gen = new GsgXml('http://www.sklep.mikran.pl/');
$gen->xmlEncoding = 'iso-8859-2';

foreach ($gsmap as $key=>$element)
{
$gen->addUrl($element,true,null,false,null,1);
//echo $key.' '.$element."<br>";
}

$gen->output(false,false,true);

?>

<?php
/**
* Generowanie pelnej mapy HTML dla wszystkich produktow i kategorii
*
* @author  tomasz@mikran.pl
* @version $Id: index.php,v 1.3 2007/04/27 18:35:09 tomasz Exp $
* @package    sitemap
*/
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if ( ereg("^/go/_sitemap/$",$_SERVER['SCRIPT_URL']) || 
     ereg("^/go/_sitemap/index\.php$",$_SERVER['SCRIPT_URL']) )
{
   Header( "HTTP/1.1 301 Moved Permanently" );
   Header( "Location: /mapa-strony" );
}

// naglowek
$theme->head();

// zapytamie o produkty w promocji, nowowsci itp
$sql = "SELECT * FROM main where active = '1'";
$result=$db->Query($sql);
if ($result==0) {
    $db->Error();
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/sitemap_list.inc");
$sitemap = new DBSiteMapList;
//$dbedit->title=$lang->bar_title['Mapa strony'];
$sitemap->title='Mapa strony';
$theme->page_open_object("show",$sitemap,"page_open_sitemap");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

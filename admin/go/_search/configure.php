<?php
/**
* Konfiguracja search
*
* @author krzys@sote.pl
* @version $Id: configure.php,v 1.1 2005/10/04 09:14:47 krzys Exp $
*
*
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

@include_once("config/auto_config/search_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->search_conf_tittle);

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/local_gen_config.inc.php");

if (! empty($_REQUEST['configure'])) {
    $configure=$_REQUEST['configure'];
}
// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();
 
   if (empty($configure['by_name'])) $configure['by_name']=0;
   else $configure['by_name']=1;
   if (empty($configure['by_phrase'])) $configure['by_phrase']=0;
   else $configure['by_phrase']=1;
   if (empty($configure['by_price'])) $configure['by_price']=0;
   else $configure['by_price']=1; 
   if (empty($configure['by_price_netto_brutto'])) $configure['by_price_netto_brutto']=0;
   else $configure['by_price_netto_brutto']=1; 
   if (empty($configure['by_attrib'])) $configure['by_attrib']=0;
   else $configure['by_attrib']=1;
   if (empty($configure['by_producer'])) $configure['by_producer']=0;
   else $configure['by_producer']=1;
   if (empty($configure['by_category'])) $configure['by_category']=0;
   else $configure['by_category']=1;
   
    
    
    // config
    $gen_config->gen(array(
    "by_name"=>$configure['by_name'],
    "by_phrase"=>$configure['by_phrase'], 
    "by_price"=>$configure['by_price'], 
    "by_price_netto_brutto"=>$configure['by_price_netto_brutto'],
    "by_attrib"=>$configure['by_attrib'], 
    "by_producer"=>$configure['by_producer'],
    "by_category"=>$configure['by_category'],    
   )
   );
    $ftp->close();
    
    $config_search->by_name=$configure['by_name'];
	$config_search->by_phrase=$configure['by_phrase'];
	$config_search->by_price=$configure['by_price'];
	$config_search->by_price_netto_brutto=$configure['by_price_netto_brutto'];
	$config_search->by_attrib=$configure['by_attrib'];
	$config_search->by_producer=$configure['by_producer'];
	$config_search->by_category=$configure['by_category'];
	
   
    // end config
}
include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
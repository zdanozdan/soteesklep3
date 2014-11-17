<?php
/**
* Konfiguracja search
*
* @author krzys@sote.pl
* @version $Id: configure.php,v 1.4 2005/12/27 09:47:28 krzys Exp $
*
*
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

@include_once("config/auto_config/points_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->points_conf_tittle);

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
 
  
    
    // config
    $gen_config->gen(array(
    "for_product"=>$configure['for_product'],
    "for_recommend"=>$configure['for_recommend'], 
    "for_review"=>$configure['for_review'], 
    "for_type"=>@$configure['for_type'], 
        
   )
   );
    $ftp->close();
    
    $config_points->for_product=$configure['for_product'];
	$config_points->for_recommend=$configure['for_recommend'];
	$config_points->for_review=$configure['for_review'];
	$config_points->for_type=@$configure['for_type'];

   
    // end config
}
include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
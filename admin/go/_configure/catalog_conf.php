<?php
/**
* Konfiguracja sklepu, tryb katalogu.
* Skrypt odczytuje dane z formularza i zapisuje odpowiednie warto¶ci w pliku konfiguracyjnym u¿ytkownika.
* Plik do którego zapisywane s± dane: config/auto_config/user_config.inc.php
*
* @author  krzys@sote.pl
* 
* @package    configure
* @subpackage configure-catalog
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

if (! empty($_REQUEST['configure'])) {
    $configure=$_REQUEST['configure'];
}

// naglowek
$theme->head();
$theme->page_open_head();
include_once ("./include/menu2.inc.php");

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();
      
    if (empty($configure['catalog_mode'])) $configure['catalog_mode']=0;
    else $configure['catalog_mode']=1;
    if (empty($configure['catalog_mode_options_currency'])) $configure['catalog_mode_options_currency']=0;
    else $configure['catalog_mode_options_currency']=1;
    if (empty($configure['catalog_mode_options_users'])) $configure['catalog_mode_options_users']=0;
    else $configure['catalog_mode_options_users']=1;
    if (empty($configure['catalog_mode_options_newsletter'])) $configure['catalog_mode_options_newsletter']=0;
    else $configure['catalog_mode_options_newsletter']=1;
    if (empty($configure['catalog_mode_options_newsedit'])) $configure['catalog_mode_options_newsedit']=0;
    else $configure['catalog_mode_options_newsedit']=1;
    
    
    
    $catalog_mode_options=array(
                  "currency"=>$configure['catalog_mode_options_currency'],
                  "users"=>$configure['catalog_mode_options_users'],
                  "newsletter"=>$configure['catalog_mode_options_newsletter'],
                  "newsedit"=>$configure['catalog_mode_options_newsedit'],
                  ); 
    
    $gen_config->gen(array(
                           "catalog_mode"=>$configure['catalog_mode'],
                           "catalog_mode_options"=>$catalog_mode_options,
                           )
                     );
    $ftp->close();
        
 	$config->catalog_mode=$configure['catalog_mode'];
 	$config->catalog_mode_options=$catalog_mode_options;
    // end config
}

include_once ("./html/catalog_conf.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

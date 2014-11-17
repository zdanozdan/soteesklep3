<?php
/**
 * Konfiguracja danych PolCard, aktywacja/ustawienia uslugi
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.5 2005/04/15 13:06:38 scalak Exp $
* @package    pay
* @subpackage polcard
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/polcard_config.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
//require_once("./include/local_gen_config.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/forms.inc.php");

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

$posid=@$item['posid'];
$status=@$item['status'];
$active=@$item['active'];


// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    
    require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;
    global $ftp;
    $ftp->connect();
    
    $config->pay_method_active;
    if(array_key_exists("3",$config->pay_method_active)) {
    	if($active == 1) {
    		$config->pay_method_active['3']=1;
    	} else {
    		$config->pay_method_active['3']=0;
    	}
    } else {
    	if($active == 1) {
    		$config->pay_method_active=$config->pay_method_active+array("3"=>"1");
    	} else {
    		$config->pay_method_active=$config->pay_method_active+array("3"=>"0");
    	}
    }
    
    $gen_config->gen(array(
                           "pay_method_active"=>$config->pay_method_active,
                           )
                     );
    
    $gen_config->config_dir = "/config/auto_config/";
    $gen_config->config_file="polcard_config.inc.php";               // nazwa generowanego pliku 
    $gen_config->classname="PolCardConfig";               // nazwa klasy generowanego pliku
    $gen_config->class_object="polcard_config";                             // 1) nazwa tworzonego obiektu klasy w/w 
    $gen_config->vars=$gen_config->vars=array("posid","email","status","active");// jakie zmienne beda generowane
    $gen_config->config=&$polcard_config;                                   // przekaz aktualne wartosci obiektu 1)
      
    // generuj plik konfiguracyjny
    $gen_config->gen(array("posid"=>$posid,
                           "status"=>$status,
                           "active"=>$active
                           )
                     );
    $ftp->close();
    $polcard_config->posid=$posid;
    $polcard_config->status=$status;
    $polcard_config->active=$active;
 }
include_once ("./html/polcard.html.php");

  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

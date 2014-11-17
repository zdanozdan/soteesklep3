<?php
/**
 * Konfiguracja danych Przelewy24.pl, aktywacja/ustawienia uslugi
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.4 2005/04/15 13:06:47 scalak Exp $
* @package    pay
* @subpackage przelewy24
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/przelewy24_config.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
//require_once("./include/local_gen_config.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;


// naglowek
$theme->head();
$theme->page_open_head();

/**
* Obs³uga formularza
*/
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
    if(array_key_exists("12",$config->pay_method_active)) {
    	if($active == 1) {
    		$config->pay_method_active['12']=1;
    	} else {
    		$config->pay_method_active['12']=0;
    	}
    } else {
    	if($active == 1) {
    		$config->pay_method_active=$config->pay_method_active+array("12"=>"1");
    	} else {
    		$config->pay_method_active=$config->pay_method_active+array("12"=>"0");
    	}
    }
    
    $gen_config->gen(array(
                           "pay_method_active"=>$config->pay_method_active,
                           )
                     );
    
    $gen_config->config_dir = "/config/auto_config/";
    $gen_config->config_file="przelewy24_config.inc.php";               // nazwa generowanego pliku 
    $gen_config->classname="Przelewy24Config";               // nazwa klasy generowanego pliku
    $gen_config->class_object="przelewy24_config";                             // 1) nazwa tworzonego obiektu klasy w/w 
    $gen_config->vars=$gen_config->vars=array("posid","email","status","active");// jakie zmienne beda generowane
    $gen_config->config=&$przelewy24_config;                                   // przekaz aktualne wartosci obiektu 1)
	
    $gen_config->gen(array("posid"=>$posid,
                           "status"=>$status,
                           "active"=>$active
                           )
                     );
    $ftp->close();
    $przelewy24_config->posid=$posid;
    $przelewy24_config->status=$status;
    $przelewy24_config->active=$active;
}

include_once ("./html/przelewy24.html.php");

  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

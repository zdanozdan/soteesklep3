<?php
/**
 * Konfiguracja danych platnoscipl.pl, aktywacja/ustawienia uslugi
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.3 2006/04/07 12:11:40 lukasz Exp $
* @package    pay
* @subpackage platnoscipl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/platnoscipl_config.inc.php");

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
$item['pl_url_ok']=ereg_replace("http://[a-z0-9.-]+/","",@$item['pl_url_ok']);
$item['pl_url_fail']=ereg_replace("http://[a-z0-9.-]+/","",@$item['pl_url_fail']);
$item['pl_url_check']=ereg_replace("http://[a-z0-9.-]+/","",@$item['pl_url_check']);

$pl_pos_id=@$item['pl_pos_id'];
$pl_md5_one=@$item['pl_md5_one'];
$pl_md5_two=@$item['pl_md5_two'];

$pl_url_ok=@$item['pl_url_ok'];
$pl_url_fail=@$item['pl_url_fail'];
$pl_url_check=@$item['pl_url_check'];

$status=@$item['status'];
$active=@$item['active'];
$sms=@$item['sms'];
$draw_type=@$item['draw_type'];
$js_param=@$item['js_param'];

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
   
	require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;
    global $ftp;
    $ftp->connect();
    
    $config->pay_method_active;
    if(array_key_exists("20",$config->pay_method_active)) {
    	if($active == 1) {
    		$config->pay_method_active['20']=1;
    	} else {
    		$config->pay_method_active['20']=0;
    	}
    } else {
    	if($active == 1) {
    		$config->pay_method_active=$config->pay_method_active+array("20"=>"1");
    	} else {
    		$config->pay_method_active=$config->pay_method_active+array("20"=>"0");
    	}
    }
    
    $gen_config->gen(array(
                           "pay_method_active"=>$config->pay_method_active,
                           )
                     );
    
    $gen_config->config_dir = "/config/auto_config/";
    $gen_config->config_file="platnoscipl_config.inc.php";               // nazwa generowanego pliku 
    $gen_config->classname="platnosciplConfig";               // nazwa klasy generowanego pliku
    $gen_config->class_object="platnoscipl_config";                             // 1) nazwa tworzonego obiektu klasy w/w 
    $gen_config->vars=$gen_config->vars=array(
                                                "pl_pos_id",
                                                "pl_md5_one",
                                                "pl_md5_two",
                                                "pl_url_ok",
                                                "pl_url_fail",
                                                "pl_url_check",
                                                "email",
                                                "status",
                                                "active",
                                                "draw_type",
                                                "js_param",
                                                "sms",
                                            );// jakie zmienne beda generowane
    $gen_config->config=&$platnoscipl_config;                                   // przekaz aktualne wartosci obiektu 1)
	
    $gen_config->gen(array("pl_pos_id"=>$pl_pos_id,
                            "pl_md5_one"=>$pl_md5_one,
                            "pl_md5_two"=>$pl_md5_two,
                            "pl_url_ok"=>$pl_url_ok,
                            "pl_url_fail"=>$pl_url_fail,
                            "pl_url_check"=>$pl_url_check,
                            "status"=>$status,
                            "active"=>$active,
                            "sms"=>$sms,
                            "draw_type"=>$draw_type,
                            "js_param"=>$js_param
                           )
                     );
    $ftp->close();
    $platnoscipl_config->pl_pos_id=$pl_pos_id;
    $platnoscipl_config->pl_md5_one=$pl_md5_one;
    $platnoscipl_config->pl_md5_two=$pl_md5_two;

    $platnoscipl_config->pl_url_ok=$pl_url_ok;
    $platnoscipl_config->pl_url_fail=$pl_url_fail;
    $platnoscipl_config->pl_url_check=$pl_url_check;

    $platnoscipl_config->status=$status;
    $platnoscipl_config->active=$active;
    $platnoscipl_config->js_param=$js_param;
    $platnoscipl_config->draw_type=$draw_type;
    $platnoscipl_config->sms=$sms;
}

include_once ("./html/platnoscipl.html.php");

  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

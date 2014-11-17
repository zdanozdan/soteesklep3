<?php
/**
 * Konfiguracja danych mBank (platnosc mTRANSFER), aktywacja/ustawienia uslugi
 *
 * @author  p@sote.pl
 * @version $Id: index.php,v 1.2 2005/11/30 10:50:34 scalak Exp $
 * @package soteesklep _pay _mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");
@include_once ("config/auto_config/ecard_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->ecard_config['bar']);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

$item['ecardReturnUrl']=preg_replace("/http:\/\/[a-z0-9.:-]+?\//","",@$item['ecardReturnUrl']);
$item['ecardCancelReturnUrl']=preg_replace("/http:\/\/[a-z0-9.:-]+?\//","",@$item['ecardCancelReturnUrl']);
$item['ecardAddressCheck']=preg_replace("/http:\/\/[a-z0-9.:-]+?\//","",@$item['ecardAddressCheck']);

$active=@$item['ecardActive'];

if (! empty($item['save'])) {
    require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;

    $ftp->connect();
    if(array_key_exists("2",$config->pay_method_active)) {
        if($active == 1) {
            $config->pay_method_active['2']=1;
        } else {
            $config->pay_method_active['2']=0;
        }
    } else {
        if($active == 1) {
            $config->pay_method_active=$config->pay_method_active+array("2"=>"1");
        } else {
            $config->pay_method_active=$config->pay_method_active+array("2"=>"0");
        }
    }

    $gen_config->gen(array(
            "pay_method_active"=>$config->pay_method_active,
    )
    );

    $gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
    $gen_config->config_file="ecard_config.inc.php";         // nazwa generowanego pliku
    $gen_config->classname="ecardConfig";                    // nazwa klasy generowanego pliku
    $gen_config->class_object="ecard_config";                // 1) nazwa tworzonego obiektu klasy w/w
    $gen_config->vars=array(
            "ecardAccount",
            "ecardPassword",
            "ecardReturnUrl",
            "ecardCancelReturnUrl",
            "ecardServerHash",
            "ecardServerPay",
	        "ecardPayType",
	        "ecardLang",
            "ecardActive",
            "ecardStatus",
            "ecardAddressCheck",
    );
    $gen_config->config=&$ecard_config;                      // przekaz aktualne wartosci obiektu 1)

    $gen_config->gen(array(
            "ecardAccount"=>$item['ecardAccount'],
            "ecardPassword"=>$item['ecardPassword'],
            "ecardReturnUrl"=>$item['ecardReturnUrl'],
            "ecardCancelReturnUrl"=>$item['ecardCancelReturnUrl'],
            "ecardServerHash"=>$item['ecardServerHash'],
            "ecardServerPay"=>$item['ecardServerPay'],
            "ecardPayType"=>@$item['ecardPayType'],
            "ecardLang"=>@$item['ecardLang'],
            "ecardActive"=>@$item['ecardActive'],
            "ecardStatus"=>@$item['ecardStatus'],
            "ecardAddressCheck"=>@$item['ecardAddressCheck'],
     )
    );
    $ftp->close();
    $ecard_config->ecardAccount=$item['ecardAccount'];
    $ecard_config->ecardPassword=$item['ecardPassword'];
    $ecard_config->ecardReturnUrl=$item['ecardReturnUrl'];
    $ecard_config->ecardCancelReturnUrl=$item['ecardCancelReturnUrl'];
    $ecard_config->ecardServerHash=$item['ecardServerHash'];
    $ecard_config->ecardServerPay=$item['ecardServerPay'];
    $ecard_config->ecardPayType=@$item['ecardPayType'];
    $ecard_config->ecardLang=@$item['ecardLang'];
    $ecard_config->ecardActive=@$item['ecardActive'];
    $ecard_config->ecardStatus=@$item['ecardStatus'];
    $ecard_config->ecardAddressCheck=@$item['ecardAddressCheck'];
}

include_once ("./html/ecard_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

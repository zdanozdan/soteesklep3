<?php
/**
 * Konfiguracja danych mBank (platnosc mTRANSFER), aktywacja/ustawienia uslugi
 *
 * @author  p@sote.pl
 * @version $Id: index.php,v 1.3 2005/10/12 09:14:22 scalak Exp $
 * @package soteesklep _pay _mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");
@include_once ("config/auto_config/paypal_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->paypal_config['bar']);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

$item['payPalReturnUrl']=preg_replace("/http:\/\/[a-z0-9.:]+?\//","",@$item['payPalReturnUrl']);
$item['payPalCancelReturnUrl']=preg_replace("/http:\/\/[a-z0-9.:]+?\//","",@$item['payPalCancelReturnUrl']);

$active=@$item['payPalActive'];

if (! empty($item['save'])) {
    require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;

    $ftp->connect();
    if(array_key_exists("101",$config->pay_method_active)) {
        if($active == 1) {
            $config->pay_method_active['101']=1;
        } else {
            $config->pay_method_active['101']=0;
        }
    } else {
        if($active == 1) {
            $config->pay_method_active=$config->pay_method_active+array("101"=>"1");
        } else {
            $config->pay_method_active=$config->pay_method_active+array("101"=>"0");
        }
    }

    $gen_config->gen(array(
            "pay_method_active"=>$config->pay_method_active,
    )
    );

    $gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
    $gen_config->config_file="paypal_config.inc.php";         // nazwa generowanego pliku
    $gen_config->classname="paypalConfig";                    // nazwa klasy generowanego pliku
    $gen_config->class_object="paypal_config";                // 1) nazwa tworzonego obiektu klasy w/w
    $gen_config->vars=array(
            "payPalAccount",
            "payPalCompany",
            "payPalReturnUrl",
            "payPalCancelReturnUrl",
            "payPalServerUrl",
            "payPalActive",
            "payPalStatus",
            "payPalServerTestUrl",
    );
    $gen_config->config=&$paypal_config;                      // przekaz aktualne wartosci obiektu 1)





    $gen_config->gen(array(
            "payPalAccount"=>$item['payPalAccount'],
            "payPalCompany"=>$item['payPalCompany'],
            "payPalReturnUrl"=>$item['payPalReturnUrl'],
            "payPalCancelReturnUrl"=>$item['payPalCancelReturnUrl'],
            "payPalServerUrl"=>$item['payPalServerUrl'],
            "payPalActive"=>@$item['payPalActive'],
            "payPalStatus"=>@$item['payPalStatus'],
            "payPalServerTestUrl"=>@$item['payPalServerTestUrl']
    )
    );
    $ftp->close();
    $paypal_config->payPalAccount=$item['payPalAccount'];
    $paypal_config->payPalCompany=$item['payPalCompany'];
    $paypal_config->payPalReturnUrl=$item['payPalReturnUrl'];
    $paypal_config->payPalCancelReturnUrl=$item['payPalCancelReturnUrl'];
    $paypal_config->payPalServerUrl=$item['payPalServerUrl'];
    $paypal_config->payPalActive=@$item['payPalActive'];
    $paypal_config->payPalStatus=@$item['payPalStatus'];
    $paypal_config->payPalServerTestUrl=@$item['payPalServerTestUrl'];
}

include_once ("./html/paypal_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

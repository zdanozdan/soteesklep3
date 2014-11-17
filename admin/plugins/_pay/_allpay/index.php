<?php
/**
 * Konfiguracja modu³u allpay
 *
 * @author  krzys@sote.pl
 * @version $Id: index.php,v 1.5 2006/05/30 11:38:50 krzys Exp $
* @package    allpay
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu oraz inne potrzebne pliki
 */
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/allpay_config.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->allpay_bar['config']);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();
$item['url']=ereg_replace("http://[a-z0-9.-]+/","",@$item['url']);
$item['urlc']=ereg_replace("http://[a-z0-9.-]+/","",@$item['urlc']);

      // nadanie zmiennym wartosci albo 1 albo 0    
     if (! empty($item['save'])) {  
	    if (empty($item['active'])) $item['active']=0;
	    else $item['active']=1;
	    if (empty($item['status'])) $item['status']=0;
	    else $item['status']=1;
	    if (empty($item['ch_lock'])) $item['ch_lock']=0;
	    else $item['ch_lock']=1;    
	    if (empty($item['onlinetransfer'])) $item['onlinetransfer']=0;
	    else $item['onlinetransfer']=1;
	    
    // zapisz dane w pliku konfiguracyjnym usera o aktywnej platnosci
     require_once("include/gen_user_config.inc.php");
     global $ftp;
     $ftp->connect();	
          $config->pay_method_active;
	     if(array_key_exists("21",$config->pay_method_active)) {
	     	if($item['active'] == 1) {
	     	$config->pay_method_active['21']=1;	
	     	}else{
	     	$config->pay_method_active['21']=0;
	     	} 	
	     }else{
	     	if($item['active'] == 1) {
	     	$config->pay_method_active=$config->pay_method_active+array("21"=>"1");
	     	}else{
	     	$config->pay_method_active=$config->pay_method_active+array("21"=>"0");	
	     	}
	     } 
	     
	         $gen_config->gen(array(
                           "pay_method_active"=>$config->pay_method_active,
                           )
                     );
    
    
     // wpis do pliku konfiguracynego allpay
    require_once("./include/gen_allpay_config.inc.php");
    $gen_config->gen(array(
                           "allpay_id"=>$item['id'],
                           "allpay_url"=>$item['url'],
                           "allpay_urlc"=>$item['urlc'],
                           "allpay_out_url"=>$item['out_url'],
                           "allpay_pr_set"=>$item['pr_set'],
                           "allpay_active"=>$item['active'],
                           "allpay_status"=>$item['status'],
                           "allpay_ch_lock"=>$item['ch_lock'],
                           "allpay_onlinetransfer"=>$item['onlinetransfer'],
                           "allpay_channel"=>$item['channel'],
                           "allpay_type"=>$item['type'],
                           "allpay_txtguzik"=>$item['txtguzik'],
                           "allpay_buttontext"=>$item['buttontext'],
                           
                           )
                     );
    $ftp->close();
    $allpay_config->allpay_id=$item['id'];
    $allpay_config->allpay_url=$item['url'];
    $allpay_config->allpay_urlc=$item['urlc'];
    $allpay_config->allpay_out_url=$item['out_url'];
    $allpay_config->allpay_pr_set=$item['pr_set'];
    $allpay_config->allpay_active=$item['active'];
    $allpay_config->allpay_status=$item['status'];
    $allpay_config->allpay_ch_lock=$item['ch_lock'];
    $allpay_config->allpay_onlinetransfer=$item['onlinetransfer'];
    $allpay_config->allpay_channel=$item['channel'];
    $allpay_config->allpay_type=$item['type'];
    $allpay_config->allpay_txtguzik=$item['txtguzik'];
    $allpay_config->allpay_buttontext=$item['buttontext'];

}

require_once ("./html/allpay_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

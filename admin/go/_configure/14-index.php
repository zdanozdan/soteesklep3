<?php
/**
* Konfiguracja sklepu, róne elementy z config.inc.php itp. 
* Skrypt odczytuje dane z formularza i zapisuje odpowiednie wartoï¿½ci w pliku konfiguracyjnym u¿ytkownika.
* Plik do którego zapisywane s± dane: config/auto_config/user_config.inc.php
*
* @author  krzys@sote.pl
* @version $Id: index.php,v 1.45 2006/03/09 11:34:28 lukasz Exp $
* @package    configure
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
include_once ("./include/menu.inc.php");

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();

    // config
    if (empty($configure['debug'])) $configure['debug']=0;
    else $configure['debug']=1;
    if (empty($configure['cyfra_photo'])) $configure['cyfra_photo']=0;
    else $configure['cyfra_photo']=1;
    if (empty($configure['basket_photo'])) $configure['basket_photo']=0;
    else $configure['basket_photo']=1;
    if (empty($configure['newsletter'])) $configure['newsletter']=0;
    else $configure['newsletter']=1;
    if (empty($configure['currency_show_form'])) $configure['currency_show_form']=0;
    else $configure['currency_show_form']=1;
    if (empty($configure['category_multi'])) $configure['category_multi']=0;
    else $configure['category_multi']=1;
    if (empty($configure['pay_method_active_1'])) $configure['pay_method_active_1']=0;
    else $configure['pay_method_active_1']=1;
    if (empty($configure['pay_method_active_11'])) $configure['pay_method_active_11']=0;
    else $configure['pay_method_active_11']=1;
    
    if (empty($configure['users_online'])) $configure['users_online']=0;
    else $configure['users_online']=1;
	if (empty($configure['basket_wishlist']['prod_ext_info'])) $configure['basket_wishlist']['prod_ext_info']=0;
    else $configure['basket_wishlist']['prod_ext_info']=1;
	/*if (empty($configure['ssl'])) $configure['ssl']=0;
    else $configure['ssl']=1;*/
    
    if (empty($configure['display_availability']))
        $configure['depository']['display_availability'] = 0;
    else
        $configure['depository']['display_availability'] = 1;
        
	if (empty($configure['show_user_id'])) $configure['show_user_id']=0;
    else $configure['show_user_id']=1;

    unset($configure['display_availability']);
    $configure_tmp = $configure['depository']['display_availability'];
    $configure['depository'] = $config->depository;
    $configure['depository']['display_availability'] = $configure_tmp;

    if (! ereg("^[0-9]+$",$configure['products_on_page_short'])) $configure['products_on_page_short']=$config->products_on_page['short'];
    if (! ereg("^[0-9]+$",$configure['products_on_page_long']))  $configure['products_on_page_long']=$config->products_on_page['long'];

    $products_on_page=array("long"=>$configure['products_on_page_long'],"short"=>$configure['products_on_page_short']);

    $random_on_page=array("promotion"=>$configure['random_on_page_promotion'],
    "newcol"=>$configure['random_on_page_newcol'],
    "bestseller"=>$configure['random_on_page_bestseller'],
    );

    $image=array("max_size"=>$configure['image_max_size'],
    "min_size"=>$configure['image_min_size'],
    );

    $google=array("keywords"=>$configure['google_keywords'],
    "title"=>$configure['google_title'],
    "description"=>$configure['google_description'],
    );
    
    $pay_method_active=$config->pay_method_active;
    $pay_method_active['1']=$configure['pay_method_active_1'];
    $pay_method_active['11']=$configure['pay_method_active_11'];

    // odczytaj aktualne order_id
    $order_id_current=$mdbd->select("order_id","order_id",1,array(),"LIMIT 1");
    if ($configure['id_start_orders_default']<$order_id_current) {
        $ido=$mdbd->select("order_id","order_register",1,array(),"ORDER BY order_id DESC LIMIT 1");
        if ($configure['id_start_orders_default']<$ido) {
            $configure['id_start_orders_default']=$order_id_current;
        }
    }
    if (ereg("^[0-9]+$",$configure['id_start_orders_default'])) {
        $mdbd->update("order_id","order_id=?",1,array($configure['id_start_orders_default']=>"int"));
    } else $configure['id_start_orders_default']=$order_id_current;
    // end
//	$basket_wishlist = $config->basket_wishlist;
//	$basket_wishlist['prod_ext_info'] = $configure['basket_wishlist']['prod_ext_info'];
    $gen_config->gen(array("record_row_type_default"=>$configure['record_row_type_default'],
    "cyfra_photo"=>$configure['cyfra_photo'],
    "basket_photo"=>$configure['basket_photo'],
    "price_type"=>$configure['price_type'],
    "main_order_default"=>$configure['main_order_default'],
    "products_on_page"=>$products_on_page,
    "random_on_page"=>$random_on_page,
    "google"=>$google,
    "image"=>$image,
    "newsletter"=>$configure['newsletter'],
    "category_multi"=>$configure['category_multi'],
    "currency_show_form"=>$configure['currency_show_form'],
    "pay_method_active"=>$pay_method_active,
    "id_start_orders_default"=>$configure['id_start_orders_default'],
    "in_category_down"=>$configure['in_category_down'],
    "debug"=>$configure['debug'],
    "unit"=>$configure['unit'],
    "users_online"=>$configure['users_online'],
//    "basket_wishlist" => $basket_wishlist,
//    "ssl" => $configure['ssl'],
    "depository" => $configure['depository'],
    "show_user_id" => $configure['show_user_id'],
    

    )
    );
    $ftp->close();

    $config->record_row_type_default=$configure['record_row_type_default'];
    $config->cyfra_photo=$configure['cyfra_photo'];
    $config->basket_photo=$configure['basket_photo'];
    $config->price_type=$configure['price_type'];
    $config->main_order_default=$configure['main_order_default'];
    $config->products_on_page=$products_on_page;
    $config->google=$google;
    $config->random_on_page=$random_on_page;
    $config->image=$image;
    $config->pay_method_active=$pay_method_active;
    $config->newsletter=$configure['newsletter'];
    $config->category_multi=$configure['category_multi'];
    $config->currency_show_form=$configure['currency_show_form'];
    $config->id_start_orders_default=$configure['id_start_orders_default'];
    $config->in_category_down=$configure['in_category_down'];
    $config->debug=$configure['debug'];
    $config->unit=$configure['unit'];
    $config->users_online=$configure['users_online'];
    $config->show_user_id=$configure['show_user_id'];
//    $config->basket_wishlist=$basket_wishlist;
//    $config->ssl=$configure['ssl'];
    $config->depository['display_availability'] = $configure['depository']['display_availability'];

    // end config
}

include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

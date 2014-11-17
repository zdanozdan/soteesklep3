<?php
/**
* Formularz z elementami konfiguracji sklepu.
*
* @author  krzys@sote.pl
* @version $Id: configure.html.php,v 1.45 2006/08/16 10:20:47 lukasz Exp $
* @package    configure
*/

global $config; 
$theme->bar($lang->configure_title,"100%");print "<BR>";
$theme->desktop_open("100%");

// odczytaj aktualne order_id
$order_id_current=$mdbd->select("order_id","order_id",1,array(),"LIMIT 1");
/**
* Dodaj obs�ug� formularzy.
*/
require_once ("HTML/Form.php");

$break="</td></tr><tr><td><hr></td></tr><tr><td align=right>";

$form =& new HTML_Form("index.php","POST");
$form->addHidden("update","true");

// Poka� mozliwo�c zmiany symbolu waluty tylko dla wersji light. W wersji expert
// zmiana symbolu waluty jest zintegrowana z modu��m walut
if ($config->nccp!=0x1388) {
    $form->addText("configure[currency]",$lang->configure_form['currency'],$config->currency,6);
} else {
    $form->addHidden("configure[currency]",$config->currency);
}
if ($config->ssl==1){
$form->addCheckbox("configure[ssl]",$lang->configure_form['ssl'],$config->ssl);
}
$form->addSelect("configure[price_type]",$break.$lang->configure_form['price_type'],$lang->price_type,$config->price_type);

$form->addSelect("configure[record_row_type_default]",$break.$lang->configure_form['record_row_type_default'],$lang->configure_record_row_type_default,$config->record_row_type_default);
$form->addSelect("configure[main_order_default]",$lang->configure_form['main_order_default'],$lang->main_order_default,$config->main_order_default);
$form->addText("configure[products_on_page_short]",$lang->configure_form['products_on_page_short'],$config->products_on_page['short'],4);
$form->addText("configure[products_on_page_long]",$lang->configure_form['products_on_page_long'],$config->products_on_page['long'],4);


$form->addText("configure[google_keywords]",$break.$lang->configure_form['google_keywords'],$config->google['keywords'],70);
$form->addText("configure[google_title]",$lang->configure_form['google_title'],$config->google['title'],70);

$form->addTextarea("configure[google_description]",$lang->configure_form['google_description'],$config->google['description'],80,7,1024);


$form->addText("configure[image_max_size]",$break.$lang->configure_form['image_max_size'].$lang->configure_form['pixels'],$config->image['max_size'],4);
$form->addText("configure[image_min_size]",$lang->configure_form['image_min_size'].$lang->configure_form['pixels'],$config->image['min_size'],4);

$form->addText("configure[unit]",$break.$lang->configure_form['unit'],$config->unit,30);

$form->addBlank("",$break.$lang->configure_form['random_on_page']);
$form->AddText("configure[random_on_page_promotion]",$lang->configure_form['random_on_page_promotion'],$config->random_on_page['promotion'],2);
$form->AddText("configure[random_on_page_newcol]",$lang->configure_form['random_on_page_newcol'],$config->random_on_page['newcol'],2);
$form->AddText("configure[random_on_page_bestseller]",$lang->configure_form['random_on_page_bestseller'],$config->random_on_page['bestseller'],2);


$form->addText("configure[id_start_orders_default]",$break.$lang->configure_form['id_start_orders_default'],$order_id_current,4);
$form->addSelect("configure[in_category_down]",$lang->configure_form['in_category_down'],$lang->configure_in_category_down,$config->in_category_down);
$form->addCheckbox("configure[category_multi]",$lang->configure_form['category_multi'],$config->category_multi);
$form->addCheckbox("configure[newsletter]",$lang->configure_form['newsletter'],$config->newsletter);
if (in_array("currency",$config->plugins)) {
	$form->addCheckbox("configure[currency_show_form]",$lang->configure_form['currency_show_form'],$config->currency_show_form);
}
$form->addCheckbox("configure[cyfra_photo]",$lang->configure_form['cyfra_photo'],$config->cyfra_photo);
if (in_array("extbasket",$config->plugins)) {
    $form->addCheckbox("configure[basket_photo]",$lang->configure_form['basket_photo'],$config->basket_photo);
}
$form->addCheckbox("configure[pay_method_active_1]",$lang->configure_form['pay_method_active_1'],$config->pay_method_active['1']);
$form->addCheckbox("configure[pay_method_active_11]",$lang->configure_form['pay_method_active_11'],$config->pay_method_active['11']);
$form->addCheckbox("configure[users_online]",$lang->configure_form['users_online'],$config->users_online);
$form->addCheckbox("configure[display_availability]",$lang->configure_form['display_availability'],$config->depository['display_availability']);
//$form->addCheckbox("configure[basket_wishlist][prod_ext_info]",$lang->configure_form['basket_ext'],$config->basket_wishlist['prod_ext_info']);
//$form->addCheckbox("configure[ssl]",$lang->configure_form['ssl'],$config->ssl);
$form->addCheckbox("configure[show_user_id]",$lang->configure_form['show_user_id'],$config->show_user_id);
// $form->addCheckbox("configure[debug]",$lang->configure_form['debug'],$config->debug);

$form->addSubmit("submit",$lang->update);
$form->display();

$theme->desktop_close();
?>

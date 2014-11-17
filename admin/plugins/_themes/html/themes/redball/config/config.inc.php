<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.6 2005/12/08 14:09:37 lukasz Exp $
* @package    themes
*/

/*
// konfiguracja buttonow w menu g³ównym
$cf=&$config->theme_config['buttons'];
$cf["main_page"]    = array("main.gif","/",$lang->head_home);
$cf["promotion"]    = array("promotion.gif","/go/_promotion/?column=promotion",$lang->head_promotions);
$cf["news"]         = array("news.gif","/go/_promotion/?column=newcol",$lang->head_news);
$cf["about_firm"]   = array("about_company.gif","/go/_files/?file=about_company.html",$lang->head_about_company);
$cf["terms"]        = array("terms.gif","/go/_files/?file=terms.html",$lang->head_terms);
*/



//                           ***** konfiguracja wygl±du tematu *****

$tc =&$config->theme_config;
// atrybuty dla body
$tc['body']['background-color'] = '#ffffff';
$tc['body']['font-family'] = 'arial';


// atrybuty dla nag³ówka
$tc['head']['logo']                             =   'head/white_logo.jpg';
$tc['head']['bar']                             =   'head/back_main_bar.jpg';
$tc['head']['background-image']                 =   'head/back.jpg';

$tc['head']['main_menu']['img']['left']         =   'head/main_menu/img/head-left.jpg';
$tc['head']['main_menu']['img']['center']       =   'head/main_menu/img/head-center.jpg';
$tc['head']['main_menu']['img']['right']        =   'head/main_menu/img/head-right.jpg';

$tc['head']['small_menu']['img']['left']        =   'head/small_menu/img/head-top-left.gif';
$tc['head']['small_menu']['img']['center']      =   'head/small_menu/img/head-top-center.gif';
$tc['head']['small_menu']['img']['right']       =   'head/small_menu/img/head-top-right.gif';
$tc['head']['small_menu']['img']['left_in']     =   'head/small_menu/img/head-top-left_in.gif';
$tc['head']['small_menu']['img']['center_in']     =   'head/small_menu/img/head-top-center_in.gif';
$tc['head']['small_menu']['img']['right_in']      =   'head/small_menu/img/head-top-right_in.gif';

$tc['foot']['bar']                             =   'foot/foot.jpg';

// flagi
$tc['flags']['pl']                              =   'flags/polski.gif';
$tc['flags']['en']                              =   'flags/english.gif';
$tc['flags']['de']                              =   'flags/deutsch.jpg';

// ikonki
$tc['icons']['basket']                          =   'icons/basket.gif';
$tc['icons']['wishlist']                          =   'icons/wishlist7.gif';
$tc['icons']['info']                            =   'icons/info.gif';

// boxy
$tc['box']['img']['bar']['left']                =   'box/bar_left.jpg';
$tc['box']['img']['bar']['center']              =   'box/bar_center.jpg';
$tc['box']['img']['bar']['right']               =   'box/bar_right.jpg';
$tc['box']['img']['top']['left']                =   'box/top_left01.png';
$tc['box']['img']['top']['center']              =   'box/top_center01.png';
$tc['box']['img']['top']['right']               =   'box/top_right01.png';
$tc['box']['img']['bottom']['left']             =   'box/bottom_left01.png';
$tc['box']['img']['bottom']['center']           =   'box/bottom_center01.png';
$tc['box']['img']['bottom']['right']            =   'box/bottom_right01.png';
$tc['box']['img']['middle']['left']             =   'box/middle_left01.png';
$tc['box']['img']['middle']['right']            =   'box/middle_right01.png';

$tc['colors']['basket_th']                      =     '#E0E0E0';
$tc['colors']['basket_td']                      =     '#F0F0F0';


@include_once ("themes/base/$config->theme/config/user_config.inc.php");      // temat u¿ytkownika

// kolory


//require_once ("themes/base/base_theme/config/user_config.inc.php");
?>

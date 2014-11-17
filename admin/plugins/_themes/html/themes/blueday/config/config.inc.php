<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.6 2005/12/08 14:09:35 lukasz Exp $
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

//$prefix = '_img/_bmp/';

// atrybuty dla nag³ówka
$tc['head']['logo']                             =   'head/logo.gif';
$tc['head']['bar']                              =   'head/back_main_bar.jpg';
$tc['head']['background-image']                 =   'head/sote_sub.jpg';

$tc['head']['main_menu']['img']['left']         =   'head/main_menu/img/head-left.jpg';
$tc['head']['main_menu']['img']['center']       =   'head/main_menu/img/head-center.jpg';
$tc['head']['main_menu']['img']['right']        =   'head/main_menu/img/head-right.jpg';
$tc['head']['main_menu']['img']['separator']    =   'head/main_menu/img/head-separator.jpg';

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

// przyciski wizerunkowe
$tc['layout_buttons']['search']                 =   'layout_buttons/search.gif';
$tc['layout_buttons']['newsletter_plus']        =   'layout_buttons/newsletter_plus.gif';

// boxy
$tc['box']['img']['bar']['left']                =   'box/bar_left.gif';
$tc['box']['img']['bar']['center']              =   'box/bar_center.gif';
$tc['box']['img']['bar']['right']               =   'box/bar_right.gif';
$tc['box']['img']['top']['left']                =   'layout_buttons/mask.gif';
$tc['box']['img']['top']['center']              =   'layout_buttons/mask.gif';
$tc['box']['img']['top']['right']               =   'layout_buttons/mask.gif';
$tc['box']['img']['bottom']['left']             =   'layout_buttons/mask.gif';
$tc['box']['img']['bottom']['center']           =   'layout_buttons/mask.gif';
$tc['box']['img']['bottom']['right']            =   'layout_buttons/mask.gif';
$tc['box']['img']['middle']['left']             =   'layout_buttons/mask.gif';
$tc['box']['img']['middle']['right']            =   'layout_buttons/mask.gif';
$tc['colors']['basket_th']                      =     '#E0E0E0';
$tc['colors']['basket_td']                      =     '#F0F0F0';


@include_once ("themes/base/$config->theme/config/user_config.inc.php");      // temat u¿ytkownika



?>

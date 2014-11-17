<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.5 2005/12/12 13:57:30 lukasz Exp $
* @package    themes
* @subpackage grayday
* \@lang
*/




//                           ***** konfiguracja wygl±du tematu *****

$tc =&$config->theme_config;
// atrybuty dla body
$tc['body']['background-color'] = '#ffffff';
$tc['body']['font-family'] = 'arial';

$prefix = '_img/_bmp/';

// atrybuty dla nag³ówka
$tc['head']['logo']                             =   'head/logo.gif';
$tc['head']['bar']                              =   'head/back_main_bar.jpg';
$tc['head']['background-image']                 =   '';

$tc['head']['main_menu']['img']['left']         =   'head/main_menu/img/head-left.jpg';
$tc['head']['main_menu']['img']['center']       =   'head/main_menu/img/head-center.jpg';
$tc['head']['main_menu']['img']['right']        =   'head/main_menu/img/head-right.jpg';
$tc['head']['main_menu']['img']['separator']    =   'head/main_menu/img/head-separator.jpg';

$tc['head']['small_menu']['img']['left']        =   'head/small_menu/img/head-top-left.gif';
$tc['head']['small_menu']['img']['center']      =   'head/small_menu/img/head-top-center.gif';
$tc['head']['small_menu']['img']['right']       =   'head/small_menu/img/head-top-right.gif';

$tc['foot']['bar']                             =   'foot/foot.jpg';

// ikonki
$tc['icons']['basket']                          =   'icons/basket.gif';
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

// przeniesione z user_config.inc.php

$config->theme_config=array(
                'body'=>array(
                                'background-color'=>'#ffffff',
                                'font-family'=>'arial',
                                ),
                                
                'head'=>array(
                                'logo'=>'head/logo.gif',
                                'background-image'=>'user/head/mask.gif',
                                'main_menu'=>array(
                                                'img'=>array(
                                                                'left'=>'user/head/main_menu/img/head-left.gif',
                                                                'center'=>'user/head/main_menu/img/head-center.gif',
                                                                'right'=>'user/head/main_menu/img/head-right.gif',
                                                                'separator'=>'user/head/main_menu/img/head-separator.gif',
                                                                ),
                                                                
                                                'buttons'=>array(
                                                                'main_page'=>array(
                                                                                'url'=>'/',
                                                                                'over'=>'head/main_menu/buttons/down_main.gif',
                                                                                'out'=>'head/main_menu/buttons/main.gif',
                                                                                ),
                                                                                
                                                                'promotion'=>array(
                                                                                'url'=>'/go/_promotion/?column=promotion',
                                                                                'over'=>'head/main_menu/buttons/down_promotion.gif',
                                                                                'out'=>'head/main_menu/buttons/promotion.gif',
                                                                                ),
                                                                                
                                                                'news'=>array(
                                                                                'url'=>'/go/_promotion/?column=newcol',
                                                                                'over'=>'head/main_menu/buttons/down_news.gif',
                                                                                'out'=>'head/main_menu/buttons/news.gif',
                                                                                ),
                                                                                
                                                                'about_firm'=>array(
                                                                                'url'=>'/go/_files/?file=about_company.html',
                                                                                'over'=>'head/main_menu/buttons/down_about_company.gif',
                                                                                'out'=>'head/main_menu/buttons/about_company.gif',
                                                                                ),
                                                                                
                                                                'terms'=>array(
                                                                                'url'=>'/go/_files/?file=terms.html',
                                                                                'over'=>'head/main_menu/buttons/down_terms.gif',
                                                                                'out'=>'head/main_menu/buttons/terms.gif',
                                                                                ),
                                                                                
                                                                ),
                                                                
                                                ),
                                                
                                'small_menu'=>array(
                                                'img'=>array(
                                                                'left'=>'head/small_menu/img/head-top-left.gif',
                                                                'center'=>'head/small_menu/img/head-top-center.gif',
                                                                'right'=>'head/small_menu/img/head-top-right.gif',
                                                                'left_in'=>"head/small_menu/img/head-top-left_in.gif",
                                                                'center_in'=>"head/small_menu/img/head-top-center_in.gif",
                                                                'right_in'=>"head/small_menu/img/head-top-right_in.gif",
                                                                ),
                                                                
                                                ),
                                                
                                'bar'=>'head/back_main_bar.jpg',
                                ),
                                                                
                'icons'=>array(
                                'basket'=>'user/icons/basket.gif',
                                'wishlist'=>'user/icons/wishlist7.gif',
                                'info'=>'user/icons/info.gif',
                                ),
                                
                'box'=>array(
                                'img'=>array(
                                                'bar'=>array(
                                                                'left'=>'user/box/bar_left.gif',
                                                                'center'=>'user/box/bar_center.gif',
                                                                'right'=>'user/box/bar_right.gif',
                                                                ),
                                                                
                                                'top'=>array(
                                                                'left'=>'user/box/top_left3.jpg',
                                                                'center'=>'user/box/top_center2.gif',
                                                                'right'=>'user/box/top_right2.gif',
                                                                ),
                                                                
                                                'bottom'=>array(
                                                                'left'=>'user/box/bottom_left2.gif',
                                                                'center'=>'user/box/bottom_center2.gif',
                                                                'right'=>'user/box/bottom_right3.jpg',
                                                                ),
                                                                
                                                'middle'=>array(
                                                                'left'=>'user/layout_buttons/mask.gif',
                                                                'right'=>'user/layout_buttons/mask.gif',
                                                                ),
                                                                
                                                ),
                                                
                                ),
                                
                'foot'=>array(
                                'bar'=>'foot/foot.jpg',
                                ),
                                
                'layout_buttons'=>array(
                                'search'=>'layout_buttons/search.gif',
                                'newsletter_plus'=>'layout_buttons/newsletter_plus.gif',
                                ),
                                
                'colors'=>array(
                                'body_background'=>'#ffffff',
                                'box_background'=>'#ffffff',
                                'base_font'=>'#000000',
                                'link_normal'=>'#5C5C5C',
                                'link_over'=>'#a0a0a4',
                                'header_font'=>'#5C5C5C',
                                'button_background'=>"#ffffff",
                                'button_border'=>"#000000",
                                'input_background'=>"#ffffff",
                                'input_border'=>"#000000",
                                'basket_th'=>"#E0E0E0",
                                'basket_td'=>"#F0F0F0",
                                'color_1'=>'#ffffff',
                                'color_2'=>'#d7d7d9',
                                'color_3'=>'#000000',
                                'color_4'=>'#D7D7d9',
                                ),
                                
                );


?>

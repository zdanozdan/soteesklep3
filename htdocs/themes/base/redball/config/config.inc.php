<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.7 2005/12/12 13:57:30 lukasz Exp $
* @package    themes
* @subpackage redball
* \@lang
*/



//                           ***** konfiguracja wygl±du tematu *****

$tc =&$config->theme_config;
// atrybuty dla body
$tc['body']['background-color'] = '#ffffff';
$tc['body']['font-family'] = 'arial';

$prefix = '_img/_bmp/';

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

$tc['foot']['bar']                             =   'foot/foot.jpg';

// ikonki
$tc['icons']['basket']                          =   'icons/basket.gif';
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


// kolory
$tc['colors'][0]                                = '#000000';
$tc['colors'][1]                                = '#f3f6d2';

// przeniesione z user_config.inc.php

/**
* \@lang
*/
$config->theme_config=array(
                'body'=>array(
                                'background-color'=>"#ffffff",
                                'font-family'=>"arial",
                                ),
                                
                'head'=>array(
                                'logo'=>"user/head/white_logo.jpg",
                                'background-image'=>"head/back.jpg",
                                'main_menu'=>array(
                                                'img'=>array(
                                                                'left'=>"head/main_menu/img/head-left.jpg",
                                                                'center'=>"head/main_menu/img/head-center.jpg",
                                                                'right'=>"head/main_menu/img/head-right.jpg",
                                                                ),
                                                                
                                                'buttons'=>array(
                                                                'main_page'=>array(
                                                                                'url'=>"/",
                                                                                'over'=>"head/main_menu/buttons/down_main.gif",
                                                                                'out'=>"head/main_menu/buttons/main.gif",
                                                                                ),
                                                                                
                                                                'promotion'=>array(
                                                                                'url'=>"/go/_promotion/?column=promotion",
                                                                                'over'=>"head/main_menu/buttons/down_promotion.gif",
                                                                                'out'=>"head/main_menu/buttons/promotion.gif",
                                                                                ),
                                                                                
                                                                'news'=>array(
                                                                                'url'=>"/go/_promotion/?column=newcol",
                                                                                'over'=>"head/main_menu/buttons/down_news.gif",
                                                                                'out'=>"head/main_menu/buttons/news.gif",
                                                                                ),
                                                                                
                                                                'about_firm'=>array(
                                                                                'url'=>"/go/_files/?file=about_company.html",
                                                                                'over'=>"head/main_menu/buttons/down_about_company.gif",
                                                                                'out'=>"head/main_menu/buttons/about_company.gif",
                                                                                ),
                                                                                
                                                                'terms'=>array(
                                                                                'url'=>"/go/_files/?file=terms.html",
                                                                                'over'=>"head/main_menu/buttons/down_terms.gif",
                                                                                'out'=>"head/main_menu/buttons/terms.gif",
                                                                                ),
                                                                                
                                                                ),
                                                                
                                                ),
                                                
                                'small_menu'=>array(
                                                'img'=>array(
                                                                'left'=>"head/small_menu/img/head-top-left.gif",
                                                                'center'=>"head/small_menu/img/head-top-center.gif",
                                                                'right'=>"head/small_menu/img/head-top-right.gif",
                                                                ),
                                                                
                                                ),
                                                
                                'bar'=>"user/head/back_main_bar.jpg",
                                ),
                                
                'icons'=>array(
                                'basket'=>"icons/basket.gif",
                                'wishlist'=>"icons/wishlist7.gif",
                                'info'=>"icons/info.gif",
                                ),
                                
                'box'=>array(
                                'img'=>array(
                                                'bar'=>array(
                                                                'left'=>"box/bar_left.jpg",
                                                                'center'=>"box/bar_center.jpg",
                                                                'right'=>"box/bar_right.jpg",
                                                                ),
                                                                
                                                'top'=>array(
                                                                'left'=>"user/box/top_left01.png",
                                                                'center'=>"box/top_center01.png",
                                                                'right'=>"user/box/top_right01.png",
                                                                ),
                                                                
                                                'bottom'=>array(
                                                                'left'=>"user/box/bottom_left01.png",
                                                                'center'=>"user/box/bottom_center01.png",
                                                                'right'=>"user/box/bottom_right01.png",
                                                                ),
                                                                
                                                'middle'=>array(
                                                                'left'=>"box/middle_left01.png",
                                                                'right'=>"box/middle_right01.png",
                                                                ),
                                                                
                                                ),
                                                
                                ),
                                
                'foot'=>array(
                                'bar'=>"foot/foot.jpg",
                                ),
                                
                'colors'=>array(
                                'body_background'=>"#ffffff",
                                'box_background'=>"#ffffff",
                                'base_font'=>"#000000",
                                'link_normal'=>"#000000",
                                'link_over'=>"#930303",
                                'header_font'=>"#d4d4d4",
                                'button_background'=>"#ffffff",
                                'button_border'=>"#000000",
                                'input_background'=>"#ffffff",
                                'input_border'=>"#000000",
                                'basket_th'=>"#E0E0E0",
                                'basket_td'=>"#F0F0F0",
                                'color_1'=>"#F3F6D2",
                                'color_2'=>"#930303",
                                'color_3'=>"#536083",
                                ),
                                
                );
?>

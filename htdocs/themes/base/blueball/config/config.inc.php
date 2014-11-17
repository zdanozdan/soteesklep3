<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.7 2005/12/12 13:57:29 lukasz Exp $
* @package    themes
* @subpackage blueball
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
$tc['icons']['wishlist']                        =   'icons/wishlist7.gif';
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

// przeniesione z user_config.inc.php

$config->theme_config['colors']=array(
                                'body_background'=>'#ffffff',
                                'box_background'=>'#ffffff',
                                'base_font'=>'#000000',
                                'header_font'=>'#ffffff',
                                'button_background'=>"#ffffff",
                                'button_border'=>"#000000",
                                'input_background'=>"#ffffff",
                                'input_border'=>"#000000",
                                'color_1'=>'#F3F6D2',
                                'color_2'=>'#124793',
                                'color_3'=>'#536083',
                                'basket_th'=>'#E0E0E0',
                                'basket_td'=>'#F0F0F0',
                );

?>

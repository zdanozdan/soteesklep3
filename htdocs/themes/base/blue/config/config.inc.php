<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.10 2005/12/12 13:57:27 lukasz Exp $
* @package    themes
* @subpackage blue
* \@lang
*/




//                           ***** konfiguracja wygl±du tematu *****


$tc =&$config->theme_config;

// atrybuty dla body
$tc['body']['background-color'] = '#ffffff';
$tc['body']['font-family'] = 'arial';

$prefix = '_img/_bmp/';

// atrybuty dla nag³ówka
$tc['head']['logo']                             =   'head/logo_head.gif';
$tc['head']['background-image']                 =   '';

$tc['head']['main_menu']['img']['left']         =   'head/main_menu/img/head-left.jpg';
$tc['head']['main_menu']['img']['center']       =   'head/main_menu/img/head-center.jpg';
$tc['head']['main_menu']['img']['right']        =   'head/main_menu/img/head-right.jpg';

$tc['head']['small_menu']['img']['left']        =   'head/small_menu/img/head-top-left.gif';
$tc['head']['small_menu']['img']['center']      =   'head/small_menu/img/head-top-center.gif';
$tc['head']['small_menu']['img']['right']       =   'head/small_menu/img/head-top-right.gif';

// buttony g³ównego menu
$tc['head']['main_menu']['buttons']["main_page"]['desc']    = $lang->head_home;
$tc['head']['main_menu']['buttons']["main_page"]['url']     = "/";
$tc['head']['main_menu']['buttons']["main_page"]['over']    =   'head/main_menu/buttons/down_main.gif';
$tc['head']['main_menu']['buttons']["main_page"]['out']     =   'head/main_menu/buttons/main.gif';

$tc['head']['main_menu']['buttons']["promotion"]['desc']    = $lang->head_promotions;
$tc['head']['main_menu']['buttons']["promotion"]['url']     = "/go/_promotion/?column=promotion";
$tc['head']['main_menu']['buttons']["promotion"]['over']    =   'head/main_menu/buttons/down_promotion.gif';
$tc['head']['main_menu']['buttons']["promotion"]['out']     =   'head/main_menu/buttons/promotion.gif';

$tc['head']['main_menu']['buttons']["news"]['desc']         = $lang->head_news;
$tc['head']['main_menu']['buttons']["news"]['url']          = "/go/_promotion/?column=newcol";
$tc['head']['main_menu']['buttons']["news"]['over']         =   'head/main_menu/buttons/down_news.gif';
$tc['head']['main_menu']['buttons']["news"]['out']          =   'head/main_menu/buttons/news.gif';

$tc['head']['main_menu']['buttons']["about_firm"]['desc']   = $lang->head_about_company;
$tc['head']['main_menu']['buttons']["about_firm"]['url']    = "/go/_files/?file=about_company.html";
$tc['head']['main_menu']['buttons']["about_firm"]['over']   =   'head/main_menu/buttons/down_about_company.gif';
$tc['head']['main_menu']['buttons']["about_firm"]['out']    =   'head/main_menu/buttons/about_company.gif';

$tc['head']['main_menu']['buttons']["terms"]['desc']        = $lang->head_terms;
$tc['head']['main_menu']['buttons']["terms"]['url']         = "/go/_files/?file=terms.html";
$tc['head']['main_menu']['buttons']["terms"]['over']        =   'head/main_menu/buttons/down_terms.gif';
$tc['head']['main_menu']['buttons']["terms"]['out']         =   'head/main_menu/buttons/terms.gif';

// ikonki
$tc['icons']['basket']                          =   'icons/basket.gif';
$tc['icons']['info']                            =   'icons/info.gif';

// boxy
$tc['box']['img']['bar']['left']                =   'box/bar_left.gif';
$tc['box']['img']['bar']['center']              =   'box/bar_center.gif';
$tc['box']['img']['bar']['right']               =   'box/bar_right.gif';
$tc['box']['img']['top']['left']                =   'box/top_left.gif';
$tc['box']['img']['top']['center']              =   'box/top_center.gif';
$tc['box']['img']['top']['right']               =   'box/top_right.gif';
$tc['box']['img']['bottom']['left']             =   'box/bottom_left.gif';
$tc['box']['img']['bottom']['center']           =   'box/bottom_center.gif';
$tc['box']['img']['bottom']['right']            =   'box/bottom_right.gif';
$tc['box']['img']['middle']['left']             =   'box/middle_left2.gif';
$tc['box']['img']['middle']['right']            =   'box/middle_right2.gif';


// kolory
$tc['colors']['body_background']                =     '#ffffff';
$tc['colors']['box_background']                 =     '#fafaaf';
$tc['colors']['base_font']                      =     '#009944';
$tc['colors']['header_font']                    =     '#0000ff';
$tc['colors']['button_background']              =     '#D4D0C8';
$tc['colors']['button_border']                  =     '#777777';
$tc['colors']['input_background']               =     '#ffffff';
$tc['colors']['input_border']                   =     '#777777';
$tc['colors']['basket_th']                      =     '#E0E0E0';
$tc['colors']['basket_td']                      =     '#F0F0F0';
$tc['colors']['color_1']                        =     '#F3F6D2';
$tc['colors']['color_2']                        =     '#6699cc';
$tc['colors']['color_3']                        =     '#536083';

// przeniesione z user_config.inc.php

$config->theme_config=array(
                'body'=>array(
                                'background-color'=>"#ffffff",
                                'font-family'=>"arial",
                                ),
                                
                'head'=>array(
                                'logo'=>"user/head/logo.gif",
                                'background-image'=>"",
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
                                                                'left_in'=>"head/small_menu/img/head-top-left_in.gif",
                                                                'center_in'=>"head/small_menu/img/head-top-center_in.gif",
                                                                'right_in'=>"head/small_menu/img/head-top-right_in.gif",
                                                                ),
                                                                
                                                ),
                                                
                                ),
                                
                'flags'=>array(
                                'pl'=>"flags/polski.gif",
                                'en'=>"flags/english.gif",
                                'de'=>"flags/deutsch.jpg",
                                ),
                                
                'icons'=>array(
                                'basket'=>"icons/basket.gif",
                                'wishlist'=>"icons/wishlist7.gif",
                                'info'=>"icons/info.gif",
                                ),
                                
                'box'=>array(
                                'img'=>array(
                                                'bar'=>array(
                                                                'left'=>"box/bar_left.gif",
                                                                'center'=>"box/bar_center.gif",
                                                                'right'=>"box/bar_right.gif",
                                                                ),
                                                                
                                                'top'=>array(
                                                                'left'=>"box/top_left.gif",
                                                                'center'=>"box/top_center.gif",
                                                                'right'=>"box/top_right.gif",
                                                                ),
                                                                
                                                'bottom'=>array(
                                                                'left'=>"box/bottom_left.gif",
                                                                'center'=>"box/bottom_center.gif",
                                                                'right'=>"box/bottom_right.gif",
                                                                ),
                                                                
                                                'middle'=>array(
                                                                'left'=>"box/middle_left2.gif",
                                                                'right'=>"box/middle_right2.gif",
                                                                ),
                                                                
                                                ),
                                                
                                ),
                                
                'colors'=>array(
                                'body_background'=>"#ffffff",
                                'box_background'=>"#ffffff",
                                'base_font'=>"#000000",
                                'link_normal'=>"#000000",
                                'link_over'=>"#8a3323",
                                'header_font'=>"#ffffff",
                                'button_background'=>"#ffffff",
                                'button_border'=>"#000000",
                                'input_background'=>"#ffffff",
                                'input_border'=>"#000000",
                                'basket_th'=>"#E0E0E0",
                                'basket_td'=>"#F0F0F0",
                                'color_1'=>"#F3F6D2",
                                'color_2'=>"#6699cc",
                                'color_3'=>"#536083",
                                ),
                                
                );

?>

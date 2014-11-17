<?php
/**
* Konfiguracja tematu wygl±du. Definiopwanie kolorów przycisków itp.
*
* @author m@sote.pl
* @version $Id: config.inc.php,v 1.9 2005/12/12 10:57:14 krzys Exp $
* @package    themes
* @subpackage green
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
$tc['colors']['box_background']                 =     '#ffffff';
$tc['colors']['base_font']                      =     '#000000';
$tc['colors']['header_font']                    =     '#ffffff';
$tc['colors']['button_background']              =     '#ffffff';
$tc['colors']['button_border']                  =     '#000000';
$tc['colors']['input_background']               =     '#ffffff';
$tc['colors']['input_border']                   =     '#000000';
$tc['colors']['basket_th']                      =     '#E0E0E0';
$tc['colors']['basket_td']                      =     '#F0F0F0';
$tc['colors']['color_1']                        =     '#F3F6D2';
$tc['colors']['color_2']                        =     '#499E4A';
$tc['colors']['color_3']                        =     '#536083';

?>

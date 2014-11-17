<?php
/**
* @version    $Id: user_config.inc.php,v 1.6 2005/12/08 14:09:36 lukasz Exp $
* @package    themes
*/
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
                                
                'flags'=>array(
                                'pl'=>'flags/polski.gif',
                                'en'=>'flags/english.gif',
                                'de'=>'flags/deutsch.jpg',
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
                                'input_background'=>'#cFCFd1',
                                'input_border'=>'#7F7F7F',
                                'button_background'=>'#E7e7e8',
                                'button_border'=>'#7F7F7F',
                                'basket_th'=>'#E0E0E0',
                                'basket_td'=>'#F0F0F0',
                                'color_1'=>'#ffffff',
                                'color_2'=>'#d7d7d9',
                                'color_3'=>'#000000',
                                'color_4'=>'#D7D7d9',
                                ),
                                
                );
?>

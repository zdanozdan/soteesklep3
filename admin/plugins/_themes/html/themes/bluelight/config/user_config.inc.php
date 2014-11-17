<?php
/**
* @version    $Id: user_config.inc.php,v 1.7 2005/12/08 14:09:36 lukasz Exp $
* @package    themes
*/
$config->theme_config=array(
                'body'=>array(
                                'background-color'=>'#ffffff',
                                'font-family'=>'arial',
                                ),
                                
                'head'=>array(
                                'logo'=>'user/head/logo.gif',
                                'background-image'=>'user/head/mask.gif',
                                'main_menu'=>array(
                                                'img'=>array(
                                                                'left'=>'head/main_menu/img/head-left.jpg',
                                                                'center'=>'head/main_menu/img/head-center.jpg',
                                                                'right'=>'head/main_menu/img/head-right.jpg',
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
                                                
                                'bar'=>'user/head/back_main_bar.jpg',
                                ),
                                
                'flags'=>array(
                                'pl'=>'flags/polski.gif',
                                'en'=>'flags/english.gif',
                                'de'=>'flags/deutsch.jpg',
                                ),
                                
                'icons'=>array(
                                'basket'=>'icons/basket.gif',
                                'wishlist'=>'icons/wishlist7.gif',
                                'info'=>'icons/info.gif',
                                ),
                                
                'box'=>array(
                                'img'=>array(
                                                'bar'=>array(
                                                                'left'=>'user/box/bar-left.gif',
                                                                'center'=>'user/box/bar-center.gif',
                                                                'right'=>'user/box/bar-right.gif',
                                                                ),
                                                                
                                                'top'=>array(
                                                                'left'=>'user/box/top-left.gif',
                                                                'center'=>'user/box/top-center.gif',
                                                                'right'=>'user/box/top-right.gif',
                                                                ),
                                                                
                                                'bottom'=>array(
                                                                'left'=>'user/box/bottom-left.gif',
                                                                'center'=>'user/box/bottom-center.gif',
                                                                'right'=>'user/box/bottom-right.gif',
                                                                ),
                                                                
                                                'middle'=>array(
                                                                'left'=>'user/box/middle-left.gif',
                                                                'right'=>'user/box/middle-right.gif',
                                                                ),
                                                                
                                                ),
                                                
                                ),
                                
                'foot'=>array(
                                'bar'=>'foot/foot.jpg',
                                ),
                                
                'colors'=>array(
                                'body_background'=>'#ffffff',
                                'box_background'=>'#ffffff',
                                'base_font'=>'#000000',
                                'link_normal'=>'#000000',
                                'link_over'=>'#999999',
                                'header_font'=>'#999999',
                                'button_background'=>'#E4EBEF',
                                'button_border'=>'#999999',
                                'input_background'=>'#FFFFFF',
                                'input_border'=>'#999999',
                                'basket_th'=>'#E0E0E0',
                                'basket_td'=>'#F0F0F0',
                                'color_1'=>'#F3F6D2',
                                'color_2'=>'#E4EBEF',
                                'color_3'=>'#999999',
                                ),
                                
                );
?>

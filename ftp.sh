#!/bin/sh
HOST='mikran@ftp.mikran.pl'
REMOTE='soteesklep3'

ftp $HOST <<END_SCRIPT
put htdocs/.htaccess $REMOTE/htdocs/.htaccess
put htdocs/custom/index.php $REMOTE/htdocs/custom/index.php
put htdocs/go/_basket/include/delivery.inc.php  $REMOTE/htdocs/go/_basket/include/delivery.inc.php 
put htdocs/go/_basket/include/my_ext_basket.inc.php $REMOTE/htdocs/go/_basket/include/my_ext_basket.inc.php
put htdocs/go/_basket/include/my_new_basket.inc.php $REMOTE/htdocs/go/_basket/include/my_new_basket.inc.php
put htdocs/go/_basket/index.php  $REMOTE/htdocs/go/_basket/index.php
put htdocs/go/_basket/index3.php  $REMOTE/htdocs/go/_basket/index3.php
put htdocs/go/_basket/register3.php $REMOTE/htdocs/go/_basket/register3.php
put htdocs/go/_category/index.php $REMOTE/htdocs/go/_category/index.php
put htdocs/go/_error/index.php $REMOTE/htdocs/go/_error/index.php
put htdocs/go/_files/index.php $REMOTE/htdocs/go/_files/index.php
put htdocs/go/_info/index.php $REMOTE/htdocs/go/_info/index.php
put htdocs/go/_info/info.php $REMOTE/htdocs/go/_info/info.php
put htdocs/go/_info/options_only.php $REMOTE/htdocs/go/_info/options_only.php
put htdocs/go/_lang/index.php $REMOTE/htdocs/go/_lang/index.php
put htdocs/go/_promotion/index.php $REMOTE/htdocs/go/_promotion/index.php
put htdocs/go/_promotion/kursy.php $REMOTE/htdocs/go/_promotion/kursy.php
put htdocs/go/_promotion/saleoff.php $REMOTE/htdocs/go/_promotion/saleoff.php
put htdocs/go/_register/_post/index.php $REMOTE/htdocs/go/_register/_post/index.php
put htdocs/go/_search/full_search.php $REMOTE/htdocs/go/_search/full_search.php
put htdocs/go/_sitemap/index.php $REMOTE/htdocs/go/_sitemap/index.php
put htdocs/go/_users/address_book.php $REMOTE/htdocs/go/_users/address_book.php
put htdocs/go/_users/address_book1.php $REMOTE/htdocs/go/_users/address_book1.php
put htdocs/go/_users/address_book2.php $REMOTE/htdocs/go/_users/address_book2.php
put htdocs/go/_users/address_book3.php $REMOTE/htdocs/go/_users/address_book3.php
put htdocs/go/_users/address_book4.php $REMOTE/htdocs/go/_users/address_book4.php
put htdocs/go/_users/address_book5.php $REMOTE/htdocs/go/_users/address_book5.php
put htdocs/go/_users/address_book6.php $REMOTE/htdocs/go/_users/address_book6.php
put htdocs/go/_users/index.php $REMOTE/htdocs/go/_users/index.php
put htdocs/go/_users/logout.php $REMOTE/htdocs/go/_users/logout.php
put htdocs/go/_users/new.php $REMOTE/htdocs/go/_users/new.php
put htdocs/go/_users/order_info.php $REMOTE/htdocs/go/_users/order_info.php
put htdocs/go/_users/orders.php $REMOTE/htdocs/go/_users/orders.php
put htdocs/go/_users/password.php $REMOTE/htdocs/go/_users/password.php
put htdocs/go/_users/register1.php $REMOTE/htdocs/go/_users/register1.php
put htdocs/go/_users/register2.php $REMOTE/htdocs/go/_users/register2.php
put htdocs/go/_users/register3.php $REMOTE/htdocs/go/_users/register3.php
put htdocs/go/_users/remind.ph $REMOTE/htdocs/go/_users/remind.php
put htdocs/go/_users/remind2.php  $REMOTE/htdocs/go/_users/remind2.php
put htdocs/go/_users/reminder.php  $REMOTE/htdocs/go/_users/reminder.php
put htdocs/go/_users/reminder1.php  $REMOTE/htdocs/go/_users/reminder1.php
put htdocs/go/_users/reminder2.php  $REMOTE/htdocs/go/_users/reminder2.php
put htdocs/go/_users/reminder3.php  $REMOTE/htdocs/go/_users/reminder3.php
put htdocs/go/_users/reminder4.php  $REMOTE/htdocs/go/_users/reminder4.php
put htdocs/go/_users/reminder5.php  $REMOTE/htdocs/go/_users/reminder5.php
put htdocs/index.php  $REMOTE/htdocs/index.php
put htdocs/lang/_en/lang.inc.php $REMOTE/htdocs/lang/_en/lang.inc.php
put htdocs/lang/_pl/lang.inc.php $REMOTE/htdocs/lang/_pl/lang.inc.php
put htdocs/plugins/_newsedit/index.php $REMOTE/htdocs/plugins/_newsedit/index.php

put htdocs/themes/_pl/_html_files/contact.html $REMOTE/htdocs/themes/_pl/_html_files/contact.html
put htdocs/themes/_pl/_html_files/delivery.html $REMOTE/htdocs/themes/_pl/_html_files/delivery.html
put htdocs/themes/_pl/_html_files/infoline.html $REMOTE/htdocs/themes/_pl/_html_files/infoline.html
put htdocs/themes/_pl/_html_files/mikran_o_nas.html $REMOTE/htdocs/themes/_pl/_html_files/mikran_o_nas.html
put htdocs/themes/_pl/_html_files/mikran_team.html $REMOTE/htdocs/themes/_pl/_html_files/mikran_team.html
put htdocs/themes/_pl/_html_files/payments.html $REMOTE/htdocs/themes/_pl/_html_files/payments.html
put htdocs/themes/_pl/_html_files/privacy.html $REMOTE/ htdocs/themes/_pl/_html_files/privacy.html
put htdocs/themes/_pl/_html_files/terms.html $REMOTE/htdocs/themes/_pl/_html_files/terms.html
put htdocs/themes/_pl/_html_files/directions.html $REMOTE/htdocs/themes/_pl/_html_files/directions.html
put htdocs/themes/_pl/_html_files/kursy.html $REMOTE/htdocs/themes/_pl/_html_files/kursy.html
put htdocs/themes/_pl/_html_files/over_wishlist_text.html $REMOTE/htdocs/themes/_pl/_html_files/over_wishlist_text.html
put htdocs/themes/_pl/_html_files/over_basket_text.html $REMOTE/htdocs/themes/_pl/_html_files/over_basket_text.html
put htdocs/themes/_pl/_html_files/wishlist_up_empty.html $REMOTE/htdocs/themes/_pl/_html_files/wishlist_up_empty.html

put htdocs/themes/_en/_html_files/contact.html $REMOTE/htdocs/themes/_en/_html_files/contact.html
put htdocs/themes/_en/_html_files/delivery.html $REMOTE/htdocs/themes/_en/_html_files/delivery.html
put htdocs/themes/_en/_html_files/infoline.html $REMOTE/htdocs/themes/_en/_html_files/infoline.html
put htdocs/themes/_en/_html_files/mikran_o_nas.html $REMOTE/htdocs/themes/_en/_html_files/mikran_o_nas.html
put htdocs/themes/_en/_html_files/mikran_team.html $REMOTE/htdocs/themes/_en/_html_files/mikran_team.html
put htdocs/themes/_en/_html_files/payments.html $REMOTE/htdocs/themes/_en/_html_files/payments.html
put htdocs/themes/_en/_html_files/privacy.html $REMOTE/ htdocs/themes/_en/_html_files/privacy.html
put htdocs/themes/_en/_html_files/terms.html $REMOTE/htdocs/themes/_en/_html_files/terms.html
put htdocs/themes/_en/_html_files/directions.html $REMOTE/htdocs/themes/_en/_html_files/directions.html
put htdocs/themes/_en/_html_files/kursy.html $REMOTE/htdocs/themes/_en/_html_files/kursy.html
put htdocs/themes/_en/_html_files/over_basket_text.html $REMOTE/htdocs/themes/_en/_html_files/over_basket_text.html
put htdocs/themes/_en/_html_files/wishlist_up_empty.html $REMOTE/htdocs/themes/_en/_html_files/wishlist_up_empty.html

put htdocs/themes/base/base_theme/_common/javascript/selections01.js $REMOTE/htdocs/themes/base/base_theme/_common/javascript/selections01.js
put htdocs/themes/base/base_theme/_img/mikran_team.jpg $REMOTE/htdocs/themes/base/base_theme/_img/mikran_team.jpg
put htdocs/themes/base/base_theme/_img/mikran_team_small.jpg $REMOTE/htdocs/themes/base/base_theme/_img/mikran_team_small.jpg
put htdocs/themes/base/base_theme/_style/style.css $REMOTE/htdocs/themes/base/base_theme/_style/style.css
put htdocs/themes/base/base_theme/bar.html.php $REMOTE/htdocs/themes/base/base_theme/bar.html.php
put htdocs/themes/base/base_theme/foot.html.php $REMOTE/htdocs/themes/base/base_theme/foot.html.php
put htdocs/themes/base/base_theme/head.html.php $REMOTE/htdocs/themes/base/base_theme/head.html.php
put htdocs/themes/base/base_theme/info.html.php $REMOTE/htdocs/themes/base/base_theme/info.html.php
put htdocs/themes/base/base_theme/left.html.php $REMOTE/htdocs/themes/base/base_theme/left.html.php
put htdocs/themes/base/base_theme/list/list_top.html.php $REMOTE/htdocs/themes/base/base_theme/list/list_top.html.php
put htdocs/themes/base/base_theme/login_form.html.php $REMOTE/htdocs/themes/base/base_theme/login_form.html.php
put htdocs/themes/base/base_theme/mail_form.html.php $REMOTE/htdocs/themes/base/base_theme/mail_form.html.php
put htdocs/themes/base/base_theme/main.html.php $REMOTE/htdocs/themes/base/base_theme/main.html.php
put htdocs/themes/base/base_theme/order_step_one.html.php $REMOTE/htdocs/themes/base/base_theme/order_step_one.html.php
put htdocs/themes/base/base_theme/order_step_two.html.php $REMOTE/htdocs/themes/base/base_theme/order_step_two.html.php
put htdocs/themes/base/base_theme/page_open.html.php $REMOTE/htdocs/themes/base/base_theme/page_open.html.php
put htdocs/themes/base/base_theme/page_open_1.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_1.html.php
put htdocs/themes/base/base_theme/page_open_1_head.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_1_head.html.php
put htdocs/themes/base/base_theme/page_open_2.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_2.html.php
put htdocs/themes/base/base_theme/page_open_sitemap.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_sitemap.html.php
put htdocs/themes/base/base_theme/register_billing_users.html.php $REMOTE/htdocs/themes/base/base_theme/register_billing_users.html.php
put htdocs/themes/base/base_theme/register_pay_method.html.php $REMOTE/htdocs/themes/base/base_theme/register_pay_method.html.php
put htdocs/themes/base/base_theme/send_confirm_summary.html.php $REMOTE/htdocs/themes/base/base_theme/send_confirm_summary.html.php
put htdocs/themes/base/base_theme/users_go2register.html.php $REMOTE/htdocs/themes/base/base_theme/users_go2register.html.php
put htdocs/themes/base/base_theme/users_login_error.html.php $REMOTE/htdocs/themes/base/base_theme/users_login_error.html.php
put htdocs/themes/base/base_theme/users_new.html.php $REMOTE/htdocs/themes/base/base_theme/users_new.html.php
put htdocs/themes/theme.inc.php $REMOTE/htdocs/themes/theme.inc.php
put include/category.inc $REMOTE/include/category.inc
put include/category_show.inc $REMOTE/include/category_show.inc
put include/image.inc $REMOTE/include/image.inc
put include/lang_functions.inc $REMOTE/include/lang_functions.inc
put include/product.inc $REMOTE/include/product.inc
put include/record_row.inc $REMOTE/include/record_row.inc
put include/session.inc $REMOTE/include/session.inc
put include/sitemap_list.inc $REMOTE/include/sitemap_list.inc
put lib/DBEdit-Metabase/DBEdit.inc $REMOTE/lib/DBEdit-Metabase/DBEdit.inc
put lib/JavaScripts/imgChange.js $REMOTE/lib/JavaScripts/imgChange.js
put lib/Menu/Menu.inc $REMOTE/lib/Menu/Menu.inc

put htdocs/themes/base/base_theme/_img/logo.png $REMOTE/htdocs/themes/base/base_theme/_img/logo.png
put htdocs/themes/base/base_theme/_style/mikran.css $REMOTE/htdocs/themes/base/base_theme/_style/mikran.css
put htdocs/themes/base/base_theme/banner.html.php $REMOTE/htdocs/themes/base/base_theme/banner.html.php
put htdocs/themes/base/base_theme/header.html.php $REMOTE/htdocs/themes/base/base_theme/header.html.php
put htdocs/themes/base/base_theme/page_open_simple.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_simple.html.php
put htdocs/themes/base/base_theme/page_open_simple_step_2.html.php $REMOTE/htdocs/themes/base/base_theme/page_open_simple_step_2.html.php

put include/encodeurl.inc $REMOTE/include/encodeurl.inc

put htdocs/themes/base/base_notheme/search_empty_query.html.php $REMOTE/htdocs/themes/base/base_notheme/search_empty_query.html.php

quit
END_SCRIPT
exit 0

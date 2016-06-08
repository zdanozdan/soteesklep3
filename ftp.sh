#!/bin/sh
HOST='mikran@ftp.mikran.pl'
REMOTE='soteesklep3'

ftp $HOST <<END_SCRIPT
put htdocs/go/_basket/include/my_basket.inc.php $REMOTE/htdocs/go/_basket/include/my_basket.inc.php
put htdocs/go/_basket/include/my_ext_basket.inc.php $REMOTE/htdocs/go/_basket/include/my_ext_basket.inc.php
put htdocs/go/_register/include/message.inc.php $REMOTE/htdocs/go/_register/include/message.inc.php
put htdocs/go/_register/_post/index.php $REMOTE/htdocs/go/_register/_post/index.php
put include/order/send.inc $REMOTE/include/order/send.inc
put lib/Mail/MyMail.php $REMOTE/lib/Mail/MyMail.php
#put htdocs/themes/_pl/_html_files/order_mail_hello.html $REMOTE/htdocs/themes/_pl/_html_files/order_mail_hello.html
#put htdocs/themes/_en/_html_files/order_mail_hello.html $REMOTE/htdocs/themes/_en/_html_files/order_mail_hello.html
#put htdocs/themes/_pl/_html_files/order_mail_hello_html.html $REMOTE/htdocs/themes/_pl/_html_files/order_mail_hello_html.html
#put htdocs/themes/_en/_html_files/order_mail_hello_html.html $REMOTE/htdocs/themes/_en/_html_files/order_mail_hello_html.html
#put htdocs/themes/_pl/_html_files/order_mail.html $REMOTE/htdocs/themes/_pl/_html_files/order_mail.html
#put htdocs/themes/_en/_html_files/order_mail.html $REMOTE/htdocs/themes/_en/_html_files/order_mail.html

quit
END_SCRIPT
exit 0

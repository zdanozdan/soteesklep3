<?php
/**
* Testowanie POSTów (wys³anie i odebranie CFC[D])
*
* @author  m@sote.pl
* @version $Id: test_post.php,v 1.4 2004/12/20 18:02:09 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

/**
* Weryfikuj certyfikat SSL klienta.
*/
require_once ("./include/check_ssl.inc.php");
?>

Test CFC<BR>
<form action=adv_confirm.php method=POST>
<input type=text name=order_id size=20>order_id<br>
<input type=text name=session_id size=32>session_id<br>
<input type=text name=amount size=20 value=9900>amount<br>
<input type=text name=response_code size=20 value=000>response_code<br>
<input type=text name=cc_number_hash size=20 value=1234>cc_number_hash<br>
<input type=text name=card_type size=20 value=visa>card_type<br>
<input type=text name=address_ok size=20 value=1>address_ok<br>
<input type=text name=test size=20 value='Y'>tryb testowy<br>
<input type=text name=auth_code size=20 value=12345>auth_code<br>
<input type=text name=bin size=20 value=12345678>bin<br>
<input type=text name=fraud size=20 value=1>fraud<br>
<input type=text name=sequence size=20 value=1>sequence<br>
<input type=submit value=send>
</form> 

<p>
TEST CFD
<form action=adv_poll.php method=POST enctype=multipart/form-data>
<input type=FILE name=clearing_report_file>
<input type=submit value='send cfd'>
</form>

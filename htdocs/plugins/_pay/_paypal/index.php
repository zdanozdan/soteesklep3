<?php
/**
 * Przejscie na strone aytoryzacji Mbank
 *
 * @author rdiak@sote.pl
 * @version $Id: index.php,v 1.1 2005/02/28 09:34:32 scalak Exp $
 * @package soteesklep mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");
include_once ("config/auto_config/paypal_config.inc.php");
include("plugins/_pay/_paypal/include/paypal.inc.php");


$theme->head();
$theme->page_open_head("page_open_1_head");

global $lang;
?>
<center>
<table width=70%>
<tr>
  <td width="50%"  valign="top">
    <img src=/themes/base/base_theme/_img/paypal_logo.png><br />
  </td>
  <td width="50%" valign="top">
    <p />
    <?php print $lang->register_paypal_info;?><br />
  </td>
</tr>
</table>
</center>

<?php
$payPal=new payPal;
print $payPal->payPalPay();
print "</center>";
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

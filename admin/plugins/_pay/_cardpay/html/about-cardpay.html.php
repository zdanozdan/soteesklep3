<?php
/**
* Formularz konfiguracji p³atno¶ci przelewy24.pl
*
* @author  lukasz@sote.pl
* @version $Id: about-cardpay.html.php,v 1.1 2005/12/08 09:52:09 lukasz Exp $
* @package    pay
* @subpackage cardpay
*/


include_once ("./include/menu.inc.php");

$theme->bar($lang->cardpay_title,"100%");print "<BR>";
$theme->desktop_open("100%");
print $lang->cardpay_about;
$theme->desktop_close();
?>

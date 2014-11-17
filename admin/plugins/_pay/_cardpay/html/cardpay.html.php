<?php
/**
* Formularz konfiguracji p³atno¶ci przelewy24.pl
*
* @author  lukasz@sote.pl
* @version $Id: cardpay.html.php,v 1.7 2005/12/16 12:04:41 lukasz Exp $
* @package    pay
* @subpackage cardpay
*/

$forms = new Forms;

include_once ("./include/menu.inc.php");

$theme->bar($lang->cardpay_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if (is_array(@$errors)) {
	reset($errors);
	$last_error=$lang->cardpay_errors[current($errors)];
	print $last_error;
	print "<br>";
	print $lang->cardpay_errors['notice'];
	if (count($errors)==1 && in_array('config-ssl',$errors)) {
		print "<br>&nbsp;\n";
		$forms->open("index.php");
		$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]'
		$forms->hidden("update_ssl",true);
		$forms->checkbox("item[active]",@$config->ssl,"Formularze zamowieñ przez SSL");
		$forms->button_submit("",$lang->update);
		$forms->close();
	}
}
if ($available) {
	print $lang->cardpay_ssl_warning;
	$forms->open("index.php");
	$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]'
	$forms->hidden("update",true);
	if (@$config->ssl=="no") $cardpay_config->active=0;
	$forms->checkbox("item[active]",@$cardpay_config->active,$lang->cardpay['active']);
	$forms->button_submit("",$lang->update);
	$forms->close();
}

$theme->desktop_close();
?>

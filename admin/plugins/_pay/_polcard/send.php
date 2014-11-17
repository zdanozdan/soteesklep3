<?php
/**
 * Wyslanie maila do PolCardu z konfiguracja sklepu.
 *
 * @author  m@sote.pl
 * @version $Id: send.php,v 1.6 2005/01/20 15:00:06 maroslaw Exp $
* @package    pay
* @subpackage polcard
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("lib/Mail/MyMail.php");
require_once ("config/auto_config/polcard_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

// generuj tresc maila wysylanego do polcardu
$body=$lang->polcard_message;
$body=ereg_replace("{WWW}",$config->www,$body);


$urls="";
// ustal protokol polaczenia
if ($config->ssl=="no") $protocol="http://";
else $protocol="https://";
$__polcard_url_true=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm.php";
$__polcard_url_false=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm_false.php";
$__polcard_url_error=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm_error.php";
$urls.=$lang->polcard_url['true']."\n".$__polcard_url_true."\n";
$urls.=$lang->polcard_url['false']."\n".$__polcard_url_false."\n";
$urls.=$lang->polcard_url['error']."\n".$__polcard_url_error."\n";
$body=ereg_replace("{URLS}",$urls,$body);

$posid=$polcard_config->posid;
$body=ereg_replace("{POSID}",$posid,$body);

$merchant=$config->merchant['name']."\n".$config->merchant['addr']."\n".$config->merchant['tel'];
$body=ereg_replace("{MERCHANT}",$merchant,$body);

$from=$config->from_email;
$to=$polcard_config->email;
$subject=$lang->polcard_subject;

$mail = new MyMail;
if (! empty($polcard_config->posid)) {
    $__send=true;
    $__result_mail=$mail->send($from,$to,$subject,$body,$from);
} else $__send=false;
include_once ("./html/send.html.php");
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

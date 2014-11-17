<?php
/**
 * Pokaz linki URL do konfiguracji PolCardu
 *
 * @author  m@sote.pl
 * @version $Id: url.php,v 1.5 2005/01/20 15:00:06 maroslaw Exp $
* @package    pay
* @subpackage polcard
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/polcard_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

// ustal protokol polaczenia
if ($config->ssl=="no") $protocol="http://";
else $protocol="https://";

$__polcard_url_true=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm.php";
$__polcard_url_false=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm_false.php";
$__polcard_url_error=$protocol.$config->www.$config->htdocs_dir."/plugins/_pay/_polcard/confirm_error.php";
include_once ("./html/polcard_url.html.php");
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

<?php
/**
 *
 * Autoryzacja administartora, 2 poziom administracji
 *
 * @author m@sote.pl
 * @version $Id: logout.php,v 2.6 2005/03/29 15:38:14 lechu Exp $
* @package    auth
 */

$global_database=false;
$__secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../include/head.inc");

// wylogowanie
$sess->unregister("__pin");

// przekieruj usera na strone potwierdzenie logowania
header ("Location: http://".$_SERVER['HTTP_HOST'].$config->url_prefix."/go/_auth/index.php");
exit;

include_once ("include/foot.inc");
?>
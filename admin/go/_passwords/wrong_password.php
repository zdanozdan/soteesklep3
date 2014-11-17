<?php
/**
 * Bledna autoryzacja. Mozliwe, ze zostalo zmienione haslo dostepu do WWW na poziomie serwera Apache.
 * Trzeba zatem usaktualnic dane dostepu w bazie. 
* @version    $Id: wrong_password.php,v 2.3 2005/01/20 14:59:38 maroslaw Exp $
* @package    passwords
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once("lang/_$config->lang/lang.inc.php");

// formularz wprowadzenia hasla
include_once("$DOCUMENT_ROOT/go/_passwords/html/enter_password.html.php");


require_once("include/foot.inc");
?>

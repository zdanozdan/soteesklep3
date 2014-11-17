<?php
/**
 * Przejscie na strone aytoryzacji Mbank
 *
 * @author rdiak@sote.pl
 * @version $Id: mail.php,v 1.3 2005/01/20 15:00:31 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/mbank_config.inc.php");
include("plugins/_pay/_mbank/include/mbank_mail.inc.php");


$theme->head();
$theme->page_open_head("page_open_1_head");

if (in_array("mbank",$config->plugins)) {
    $mbankmail=new mBankMail;
    $mbankmail->mbank_mail_action();
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

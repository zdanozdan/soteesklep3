<?php
/**
 * Przejscie na strone aytoryzacji Mbank
 *
 * @author rdiak@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:31 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/mbank_config.inc.php");
include("plugins/_pay/_mbank/include/mbank.inc.php");


$theme->head();
$theme->page_open_head("page_open_1_head");

if (in_array("mbank",$config->plugins)) {
    global $lang;
    print $lang->mbank_info;
    $mbank=new mBank;
    print $mbank->mBankPay();
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

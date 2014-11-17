<?php
/**
 * Przejscie na strone aytoryzacji Inteligo
 *
 * @author m@sote.pl
 * @version $Id: back.php,v 1.3 2005/01/20 15:00:30 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/mbank_config.inc.php");
include("./include/mbank.inc.php");

$theme->head();
$theme->page_open_head("page_open_1_head");

if (in_array("mbank",$config->plugins)) {
    $mbank=new mBank;
    $mbank->mBankGetOk();
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>

<?php
/**
 * PHP Template:
 * Lista rekordow tabeli dictionary
 * 
 * @author piotrek@sote.pl
 * @version $Id: index.php,v 2.7 2005/01/20 14:59:48 maroslaw Exp $
* @package    dictionary
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

if (empty($__status)) {
    $__status=$lang->dictionary_info["list"];
}
$__index=true;

// config
$sql="SELECT * FROM dictionary ORDER BY wordbase";

if (! empty($_REQUEST['char'])) {
    // wez pierwszy znak - litere
    $char=addslashes($_REQUEST['char'][0]);
    $sql="SELECT * FROM dictionary WHERE wordbase like '$char%' ORDER BY wordbase";
}

$bar=$lang->dictionary_list_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");

print $__status;

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>

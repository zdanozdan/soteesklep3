<?php
$global_database=true;$__start_page=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

include_once ("../../include/head.inc");
require_once("Packer/packer.php");
$packer=new packer('./mozz.tar.gz');
$packer->unpack();
print "<pre>";
print_r ($packer->filestruct);
print "</pre>";
//include_once ("include/foot.inc");
?>
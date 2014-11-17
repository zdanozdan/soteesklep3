<?php
/**
* @version    $Id: index.php,v 2.3 2005/01/20 14:59:37 maroslaw Exp $
* @package    passwords
*/
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Zarzadzanie haslami                                                  |
// +----------------------------------------------------------------------+
// | authors:     Marek Jakubowicz <m@sote.pl> (base system)              |
// +----------------------------------------------------------------------+
//
// $Id: index.php,v 2.3 2005/01/20 14:59:37 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;

// naglowek
$theme->head();
$theme->page_open_head();

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

if ($update==false) {
    // pierwsze wywolanie formularza
    include_once("html/password_form.html.php"); 
} else {
    // if (! empty($_REQUEST['submit_auth_ftp'])) {
    // wypelniono formularz zmiany danych autoryzacji FTP
    $config->ftp_password=$_REQUEST['auth_ftp']['password'];
    if ($ftp->connect("no")) {
        print "<center>".$lang->ftp_auth_ok."</center>";            
        $ftp->close();
        require_once ("./include/save_crypt_ftp.inc.php");
    }
    // }
} // end if


  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

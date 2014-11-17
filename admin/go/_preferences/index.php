<?php
/**
* @version    $Id: index.php,v 2.3 2005/01/20 14:59:38 maroslaw Exp $
* @package    preferences
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
// $Id: index.php,v 2.3 2005/01/20 14:59:38 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


// naglowek
$theme->head();
$theme->page_open_head();

print "Ustawienia - preferencje";

  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

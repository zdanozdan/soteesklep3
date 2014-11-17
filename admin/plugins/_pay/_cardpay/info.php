<?php
/**
 * Konfiguracja danych Przelewy24.pl, aktywacja/ustawienia uslugi
 *
 * @author  lukasz@sote.pl
 * @version $Id: info.php,v 1.1 2005/11/30 08:58:34 lukasz Exp $
 * @package    pay
 * @subpackage _cardpay
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./html/about-cardpay.html.php");
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

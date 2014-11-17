<?php
/**
 * Konfiguracja danych platnosci CitiConnect
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:05 maroslaw Exp $
* @package    pay
* @subpackage citiconnect
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

print "CitiConnect";
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

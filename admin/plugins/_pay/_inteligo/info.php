<?php
/**
 * Informacja o us³udze p³atnosci przez Inteligo
 *
 * @author  rdiak@sote.pl
 * @version $Id: info.php,v 1.3 2005/01/20 15:00:05 maroslaw Exp $
* @package    pay
* @subpackage inteligo
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./html/info.html.php");
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

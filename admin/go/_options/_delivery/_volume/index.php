<?php
/**
 * Lista walut
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 1.2 2005/01/20 14:59:32 maroslaw Exp $
 * @package currency 
 */

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../../../include/head.inc");

// config
$sql="SELECT * FROM delivery_volume ORDER BY id";
$bar=$lang->delivery_volume_bar;

include_once ("./include/list_th.inc.php");
$list_th=delivery_volume_list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");
   
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>

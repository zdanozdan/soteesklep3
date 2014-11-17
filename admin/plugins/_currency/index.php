<?php
/**
 * Lista walut
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 2.7 2005/01/20 14:59:46 maroslaw Exp $
* @package    currency
 */

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../include/head.inc");

// config
$sql="SELECT * FROM currency ORDER BY id";
$bar=$lang->bar_title['currency'];

include_once ("./include/list_th.inc.php");
$list_th=currency_list_th();
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

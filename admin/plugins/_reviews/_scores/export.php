<?php
/**
 * PHP Template:
 * Eksportowanie ocen produktow (wrzucenie sredniej oceny do tabeli main, pole user_score)
 *
 * @author piotrek@sote.pl
 * @version $Id: export.php,v 1.3 2005/01/20 15:00:09 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->scores_export_bar);

// eksportuj srednia ocen dla danego produktu do sklepu (z tabeli scores do tabeli main)
include_once("./include/export.inc.php");

$theme->page_open_foot();
$theme->foot();

include_once ("include/foot.inc");
?>

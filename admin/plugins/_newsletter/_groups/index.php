<?php
/**
* Lista adresów e-mail w bazie
* 
* @author  rdiak@sote.pl
* @version $Id: index.php,v 2.8 2005/01/20 14:59:59 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");
require_once ("include/metabase.inc");

// config
$sql="SELECT * FROM newsletter_groups ORDER BY id";
$bar=$lang->bar_title['newsletter'];
include_once ("./include/list_th.inc.php");
$list_th=groups_list_th();
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

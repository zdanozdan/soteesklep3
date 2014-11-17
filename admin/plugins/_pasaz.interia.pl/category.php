<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu interia
 *
 * @author  rdiak@sote.pl
 * @version $Id: category.php,v 1.1 2005/03/29 15:15:54 scalak Exp $
* @package    pasaz.interia.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
 * Includowanie potrzebnych klas 
 */
require_once ("../../../include/head.inc");
// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->interia_bar['cat']);
require_once ("include/save_auth_session.inc.php");

include_once ("./html/interia_category.html.php");    

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

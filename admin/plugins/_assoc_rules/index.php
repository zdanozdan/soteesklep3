<?php
/**
 * Modu³ podpowiadania produktu - regu³y asocjacyjne
 * 
 * @author lech@sote.pl
 * @version $Id: index.php,v 1.7 2005/11/03 12:20:26 lechu Exp $
* @package    assoc_rules
 */

// naglowek php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

include_once("lib/AssocRules/include/assoc_rules.inc");

global $transactions_path;

$theme->head();
$theme->page_open_head();
include_once("./include/menu.inc.php");
$theme->bar($lang->bar1);



if(@$_REQUEST['action'] == 'conf1') {
	include_once("./include/ranking_conf1.inc.php");
	echo "<br><br>" . $lang->conf1_info_ok . "<br><br>";
}


/**/

// $assoc_rules->_displayRules();
include_once("./html/form1.html.php");
$theme->page_open_foot();
$theme->foot();
include_once ("include/foot.inc");
?>

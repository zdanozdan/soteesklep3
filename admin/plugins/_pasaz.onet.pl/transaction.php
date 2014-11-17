<?php
/**
 * Transakcje do onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: transaction.php,v 1.12 2005/01/20 15:00:03 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->onet_bar['trans']);
require_once ("include/save_auth_session.inc.php");

print "<br>";
print $lang->onet_trans['info'];
print "<br><br>";

$count=$mdbd->select("count(*)","order_register","partner_name=? AND confirm=1 AND confirm_partner=1",array("onet"=>"string"),"ORDER BY order_id DESC");

include_once ("./html/onet_transaction.html.php");    

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

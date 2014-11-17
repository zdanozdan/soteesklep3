<?php
/**
 * Transakcje do interia pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: transaction.php,v 1.2 2005/03/30 13:18:15 scalak Exp $
* @package    pasaz.interia.pl
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
$theme->bar($lang->interia_bar['trans']);
require_once ("include/save_auth_session.inc.php");

print "<br>";
print $lang->interia_trans['info'];
print "<br><br>";

$count=$mdbd->select("count(*)","order_register","partner_name=? AND confirm=1 AND (confirm_partner=1 OR confirm_partner=2)",array("interia"=>"string"),"ORDER BY order_id DESC");

include_once ("./html/interia_transaction.html.php");    

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

<?php
/**
 * Transakcje do onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: transaction1.php,v 1.5 2005/06/08 11:22:40 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->onet_bar['trans']);

print "<br><center>".$lang->onet_trans['timeout']."<br></center>";
flush();

require_once("include/onet/onet_transaction.inc.php");
$onet_trans=new OnetTrans;
$onet_trans->send_trans("2");

include_once ("./html/onet_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>

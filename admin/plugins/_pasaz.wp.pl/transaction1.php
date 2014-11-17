<?php
/**
 * Transakcje do wp pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: transaction1.php,v 1.3 2005/06/08 11:22:41 maroslaw Exp $
* @package    pasaz.wp.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->wp_bar['trans']);

print "<br><center>".$lang->wp_trans['timeout']."<br></center>";
flush();

require_once("include/wp/wp_transaction.inc.php");
$wp_trans=new WpTransaction;
$wp_trans->ConfirmTrans();

include_once ("./html/wp_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>

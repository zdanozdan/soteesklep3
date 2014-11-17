<?php
/**
 * Wyszukiwanie rekordow z tabeli main_keys
 * 
 * @author  m@sote.pl
 * @version $Id: search2.php,v 1.4 2005/01/20 14:59:54 maroslaw Exp $
* @package    main_keys
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// config
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

$sql="SELECT * FROM main_keys WHERE ";
if (! empty($_REQUEST['user_id_main'])) {
    $user_id_main=addslashes(trim($_REQUEST['user_id_main']));
    $sql.=" user_id_main='$user_id_main' AND";
}
if (! empty($_REQUEST['main_key'])) {
    $main_key=addslashes(trim($_REQUEST['main_key']));
    $crypt_main_key=$my_crypt->endecrypt("",$main_key);
    $sql.=" main_key='$crypt_main_key' AND";
}
if (! empty($_REQUEST['order_id'])) {
    $order_id=addslashes(trim($_REQUEST['order_id']));
    $sql.=" order_id='$order_id' AND";
}
$sql=substr($sql,0,strlen($sql)-3);
$sql.=" ORDER BY id";

$bar=$lang->main_keys_search_title;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
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

<?php 
/**
* Odczytaj i zapamiêtaj ustawienia dot. opcji multi_shop
*
* @auhtor  m@sote.pl
* @version $Id: multi_shop.inc.php,v 2.1 2005/01/28 15:30:56 maroslaw Exp $
* @package auth
* @subpackage multi_shop
*/

$db->soteSetModSQLOff();
$mode=$mdbd->select("mode","shop","license=?",array($config->license['nr']=>"text"),"LIMIT 1");
if ($mode=="master") {
    $multi_shop=1;
    $sess->register("multi_shop",$multi_shop);
}
$db->soteSetModSQLOn();
?>
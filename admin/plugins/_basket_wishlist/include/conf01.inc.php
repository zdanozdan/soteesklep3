<?php
/**
 * Modu³ konfiguracji koszyka i przechowalni
 * 
 * @author lech@sote.pl
 * @version $Id: conf01.inc.php,v 1.2 2005/12/09 14:30:18 lechu Exp $
 * @package    _basket_wishlist
 */

global $config, $_REQUEST;
require_once("include/gen_user_config.inc.php");


$prod_ext_info = 0;
if(!empty($_REQUEST['prod_ext_info'])) {
    $prod_ext_info = 1;
}
$config->basket_wishlist['prod_ext_info'] = $prod_ext_info;





$basket_wishlist = $config->basket_wishlist;
$ftp->connect();
$gen_config->gen(
    array
    (
    "basket_wishlist"=>$basket_wishlist,
    )
);
$ftp->close();

?>
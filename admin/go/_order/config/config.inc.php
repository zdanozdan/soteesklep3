<?php 
/**
* Konfiguracja lokalna zwi±zana z transakcjami
*
* @author  m@sote.pl
* @version $Id: config.inc.php,v 1.2 2004/12/20 17:58:53 maroslaw Exp $
* @package    order
*/

// dodaj p³atno¶æ przelewy24
require_once ("config/auto_config/przelewy24_config.inc.php");
if (! empty($przelewy24_config)) {
    $config->pay_method[12]="Przelewy24";
}
?>

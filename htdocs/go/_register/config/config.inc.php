<?php 
/**
* Konfiguracja lokalna zwi±zana z transakcjami
*
* @author  m@sote.pl
* @version $Id: config.inc.php,v 1.2 2004/12/20 18:01:44 maroslaw Exp $
* @package    register
*/

// dodaj p³atno¶æ przelewy24
require_once ("config/auto_config/przelewy24_config.inc.php");
if (! empty($przelewy24_config)) {
    $config->pay_method[12]="Przelewy24";
    $lang->pay_method[12]="Przelewy24";
}
?>

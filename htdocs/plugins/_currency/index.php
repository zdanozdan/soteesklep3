<?php
/**
 * Zmiana waluty wyswietlanej w sklepie
 * 
 * @author  m@sote.pl 
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:26 maroslaw Exp $
* @package    currency
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// inicjuj obsluge Walut
$shop->currency();

if (! empty($_REQUEST['currency'])) {
    $__currency=$_REQUEST['currency'];
    if ((! empty($config->currency_name[$__currency])) && (! empty($config->currency_data[$__currency]))) 
    {        
        $sess->register("__currency",$__currency);           
    }
}
header ("Location: http://".$_SERVER['HTTP_HOST'].$config->url_prefix."/index.php?$sess->param=$sess->id");

// stopka
include_once ("include/foot.inc");
?>

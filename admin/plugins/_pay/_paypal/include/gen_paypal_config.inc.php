<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  piotrek@sote.pl
 * @version $Id: gen_paypal_config.inc.php,v 1.1 2005/02/28 09:38:14 scalak Exp $
 * @package soteesklep
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="paypal_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="paypalConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="paypal_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array(
                           "payPalAccount",
                           "payPalCompany",
                           "payPalReturnUrl",
                           "payPalCancelReturnUrl",
                           "payPalServerUrl",
                           "payPalActive",
                           "payPalStatus",
                           "payPalServerTestUrl",
                           );
$gen_config->config=&$paypal_config;                      // przekaz aktualne wartosci obiektu 1)

?>

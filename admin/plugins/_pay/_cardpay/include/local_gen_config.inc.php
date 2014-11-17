<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.1 2005/10/26 12:29:18 lukasz Exp $
* @package    pay
* @subpackage przelewy24
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="cardpay_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="CardPayConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="cardpay_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("pub_key","priv_key","active");
$gen_config->config=&$cardpay_config;                      // przekaz aktualne wartosci obiektu 1)

?>

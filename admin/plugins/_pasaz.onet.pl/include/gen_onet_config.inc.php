<?php
/**
 * Konfiguracja modu³u onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: gen_onet_config.inc.php,v 1.10 2004/12/20 18:00:31 maroslaw Exp $
* @package    pasaz.onet.pl
 */

/**
 * Includowanie pliku do generowania konfiguracji
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
//$gen_config->config_dir="/admin/plugins/_pasaz.onet.pl/config/";     // katalog zawierajacy generowany plik
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="onet_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="OnetConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="onet_config";                // obiekt klasy 1)
$gen_config->vars=array(
                        "onet_shop_id",
                        "onet_mode",
                        "onet_login",
                        "onet_password",
                        "onet_server",
                        "onet_rpc",
                        "onet_message", 
                        "onet_port",
                        "onet_transaction",
                        "onet_category",
                        "onet_confirm_trans",
                        "onet_test_server",
                        "onet_load",
                        "onet_partner_name",
                        );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

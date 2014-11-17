<?php
/**
 * Generuj plik konfiguracyjny uzytkownika config/auto_config/user_config.inc.php
 *
 * @author  m@sote.pl
 * @version $Id: gen_wp_config.inc.php,v 1.5 2004/12/20 18:00:36 maroslaw Exp $
* @package    pasaz.wp.pl
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";     // katalog zawierajacy generowany plik
$gen_config->config_file="wp_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="wpConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="wp_config";                // obiekt klasy 1)
$gen_config->vars=array(
                        "wp_shop_id",
                        "wp_mode",
                        "wp_login",
                        "wp_password",
                        "wp_server",
                        "wp_rpc",
                        "wp_message", 
                        "wp_port",
                        "wp_transaction",
                        "wp_category",
                        "wp_confirm_trans",
                        "wp_test_server",
                        "wp_load",
                        "wp_partner_name",
                        );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

<?php
/**
 * Generuj plik konfiguracyjny uzytkownika config/auto_config/user_config.inc.php
 *
 * @author  m@sote.pl
 * @version $Id: gen_interia_config.inc.php,v 1.2 2005/03/30 11:59:27 scalak Exp $
* @package    pasaz.interia.pl
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";     // katalog zawierajacy generowany plik
$gen_config->config_file="interia_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="interiaConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="interia_config";                // obiekt klasy 1)
$gen_config->vars=array(
                        "interia_shop_id",
                        "interia_password",
                        "interia_server",
                        "interia_rpc",
                        "interia_message", 
                        "interia_port",
                        "interia_transaction",
                        "interia_category",
                        "interia_test_server",
                        "interia_partner_name",
                        "interia_load",
                        );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

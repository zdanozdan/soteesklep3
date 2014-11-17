<?php
/**
 * Konfiguracja modu³u allegro
 *
 * @author  krzys@sote.pl
 * @version $Id: gen_allegro_config.inc.php,v 1.6 2006/04/12 11:45:28 scalak Exp $
* @package    allegro
 */

/**
 * Includowanie pliku do generowania konfiguracji
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="allegro_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="allegroConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="allegro_config";                // obiekt klasy 1)
$gen_config->vars=array(
						"allegro_login",
						"allegro_login_test",
                        "allegro_password",
                        "allegro_password_test",
                        "allegro_web_api_key",
                        "allegro_country_code",
                        "allegro_country_code_test",
                        "allegro_category",
                        "allegro_category_test",
                        "allegro_server",
                        "allegro_version",
                        "allegro_version_test",
                        "allegro_country",
                        "allegro_country_test",
                        "allegro_city",
                        "allegro_time",
                        "allegro_states",
                        "allegro_trans",
                        "allegro_mode",
                        "allegro_city",
                        "allegro_state_select",
                       );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

<?php
/**
 * Konfiguracja modu³u ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: gen_ceneo_config.inc.php,v 1.4 2006/08/16 10:41:42 lukasz Exp $
* @package    pasaz.ceneo.pl
 */

/**
 * Includowanie pliku do generowania konfiguracji
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
//$gen_config->config_dir="/admin/plugins/_pasaz.ceneo.pl/config/";     // katalog zawierajacy generowany plik
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="ceneo_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="ceneoConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="ceneo_config";                // obiekt klasy 1)
$gen_config->vars=array(
                        "ceneo_shop_id",
                     
                        );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

<?php
/**
 * Generuj plik konfiguracyjny uzytkownika config/auto_config/user_config.inc.php
 *
 * @author  m@sote.pl
 * @version $Id: gen_user_config.inc.php,v 2.3 2004/12/20 17:59:22 maroslaw Exp $
* @package    admin_include
 */
require_once ("include/gen_config.inc.php");

$gen_config =& new GenConfig;
$gen_config->config_dir="/config/auto_config";     // katalog zawierajacy generowany plik
$gen_config->config_file="user_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="MyConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="AutoConfig";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="config";                // obiekt klasy 1)
$gen_config->vars=$config->user_vars;              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

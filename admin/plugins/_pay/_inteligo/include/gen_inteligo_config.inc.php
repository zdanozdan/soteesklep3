<?php
/**
 * Generuj plik konfiguracyjny uzytkownika config/auto_config/user_config.inc.php
 *
 * @author  m@sote.pl
 * @version $Id: gen_inteligo_config.inc.php,v 1.6 2004/12/20 18:00:38 maroslaw Exp $
* @package    pay
* @subpackage inteligo
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";     // katalog zawierajacy generowany plik
$gen_config->config_file="config_inteligo.inc.php";                           // generowany plik konfiguracyjny
$gen_config->classname="InteligoConfig";                             // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";                                       // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="inteligo_config";                         // obiekt klasy 1)
$gen_config->vars=array(
                        "inteligo_merchant_id",
                        "inteligo_email",
                        "inteligo_mode",
                        "inteligo_pay_method",
                        "inteligo_currency",
                        "inteligo_info",
                        "inteligo_coding",
                        "inteligo_server",
                        "inteligo_key",
                        "inteligo_back_ok",
                        "inteligo_back_error",
                        "inteligo_lock",
                        "inteligo_number",
                        );                                           // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                                        // adres aktualnego obiektu klasy 1)
?>

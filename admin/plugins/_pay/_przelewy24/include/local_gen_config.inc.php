<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.2 2004/12/20 18:00:42 maroslaw Exp $
* @package    pay
* @subpackage przelewy24
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="przelewy24_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="Przelewy24Config";                    // nazwa klasy generowanego pliku
$gen_config->class_object="przelewy24_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("posid","email","status","active");
$gen_config->config=&$przelewy24_config;                      // przekaz aktualne wartosci obiektu 1)

?>

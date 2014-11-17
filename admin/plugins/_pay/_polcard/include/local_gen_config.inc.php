<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.3 2004/12/20 18:00:41 maroslaw Exp $
* @package    pay
* @subpackage polcard
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="polcard_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="PolCardConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="polcard_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("posid","email","status","active");
$gen_config->config=&$polcard_config;                      // przekaz aktualne wartosci obiektu 1)

?>

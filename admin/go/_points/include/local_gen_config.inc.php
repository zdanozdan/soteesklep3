<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  krzys@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.2 2005/12/09 10:44:11 scalak Exp $
* @package    admin
* @subpackage search
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="points_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="PointsConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="config_points";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("for_product","for_recommend","for_review","for_type");
$gen_config->config=&$config_points;                      // przekaz aktualne wartosci obiektu 1)
?>
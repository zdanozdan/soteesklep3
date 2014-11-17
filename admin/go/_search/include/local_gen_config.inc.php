<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  krzys@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.1 2005/10/04 09:15:35 krzys Exp $
* @package    admin
* @subpackage search
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="search_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="SearchConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="config_search";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("by_name","by_phrase","by_price","by_price_netto_brutto","by_attrib","by_producer","by_category");
$gen_config->config=&$config_search;                      // przekaz aktualne wartosci obiektu 1)

?>

<?php
/**
 * Generuj plik konfiguracyjny PHP z ustawieniami dot. google
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.1 2005/08/02 10:37:23 maroslaw Exp $
 * @package    google
 */

/**
*  Obs³uga generowania pliku kofnguracyjnego.
*/
require_once ("include/gen_config.inc.php");

$gen_config =& new GenConfig;
$gen_config->config_dir="/config/auto_config";            // katalog generowanego pliku
$gen_config->config_file="google_config.inc.php";         // nazwa generowanego pliku
$gen_config->classname="GoogleConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="google_config";                // 1) nazwa tworzonego obiektu klasy w/w
// wszystkie zmienne zapisywane w pliku konfiguracyjnym
$gen_config->vars=array("http_user_agents","keywords","keyword_plain","sentences","description","title","logo");              
$gen_config->config=&$google_config;                      // przekaz aktualne wartosci obiektu 1)
?>

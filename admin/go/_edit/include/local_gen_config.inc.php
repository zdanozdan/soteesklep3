<?php
/**
 * Generuj plik konfiguracyjny PHP z ustawieniami dot. edycji/dodania produktu
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 2.3 2004/12/20 17:58:04 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    edit
 */
if (@$__secure_test!=true) die ("Forbidden");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/admin/go/_edit/config";         // katalog generowanego pliku
$gen_config->config_file="config.inc.php";                // nazwa generowanego pliku 
$gen_config->classname="EditConfig";                      // nazwa klasy generowanego pliku
$gen_config->class_object="edit_config";                  // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("netto");                         // wszystkie zmienne zapisywane w pliku konfiguracyjnym
$gen_config->config=&$edit_config;                        // przekaz aktualne wartosci obiektu 1)
?>

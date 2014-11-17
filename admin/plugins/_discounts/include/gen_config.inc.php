<?php
/**
 * Generuj plik konfiguracyjny PHP
 *
 * @author  m@sote.pl
 * \@modified_by p@sote.pl (happy hour)
 * @version $Id: gen_config.inc.php,v 2.5 2004/12/20 17:59:46 maroslaw Exp $
* @package    discounts
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/discounts";            // katalog generowanego pliku
$gen_config->config_file="discounts_config.inc.php";                // nazwa generowanego pliku 
$gen_config->classname="DiscountsConfig";                           // nazwa klasy generowanego pliku
$gen_config->class_object="discounts_config";                       // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("producer","category","category_producer","default_discounts","discounts_groups","discounts_groups_public","discounts_start_date","discounts_end_date");                                // jakie zmienne beda generowane

$gen_config->config=&$discounts_config;                             // przekaz aktualne wartosci obiektu 1)
?>

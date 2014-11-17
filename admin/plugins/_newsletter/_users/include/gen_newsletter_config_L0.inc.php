<?php
/**
* Generuj plik konfiguracyjny uzytkownika config/auto_config/user_config.inc.php dla jêzyka 0
*
* @author  rdiak@sote.pl
* @version $Id: gen_newsletter_config_L0.inc.php,v 2.2 2006/03/03 07:52:58 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

/**
* Za³±cz obs³ugê generowania pliku konfiguracyjnego.
*/
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/newsletter/";          // katalog zawierajacy generowany plik
$gen_config->config_file="newsletter_config_L0.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="ConfigNewsletter";               // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="config_newsletter";           // obiekt klasy 1)
$gen_config->vars=array(
"newsletter_confirm",
"newsletter_group",
"newsletter_sender",
"newsletter_head",
"newsletter_info_add",
"newsletter_info_del",
"newsletter_foot_add",
"newsletter_foot_del",
"newsletter_foot",
);              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                           // adres aktualnego obiektu klasy 1)
?>

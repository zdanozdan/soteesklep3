<?php
/**
 * Konfiguracja modu³u allegro
 *
 * @author  krzys@sote.pl
 * @version $Id: gen_allpay_config.inc.php,v 1.3 2006/05/30 11:38:50 krzys Exp $
* @package    allegro
 */

/**
 * Includowanie pliku do generowania konfiguracji
 */
require_once ("include/gen_config.inc.php");

$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="allpay_config.inc.php";    // generowany plik konfiguracyjny
$gen_config->classname="allpayConfig";                 // 1) klasa tworzona w pliku, zawierajaca definicje zmeinnych
$gen_config->ext_classname="";           // jesli w/w klasa jest rozszezeniem klasy, to ext_classname okresla nazwa klasy nadrzednej
$gen_config->class_object="allpay_config";                // obiekt klasy 1)
$gen_config->vars=array(
						"allpay_id",
						"allpay_url",
						"allpay_urlc",
						"allpay_active",
						"allpay_status",
						"allpay_ch_lock",
						"allpay_onlinetransfer",
						"allpay_channel",
						"allpay_type",
						"allpay_txtguzik",
						"allpay_buttontext",
						"allpay_out_url",
						"allpay_pr_set"
						
						
                       );              // lista zmiennych generowanych w konfiguracji
$gen_config->config=&$config;                      // adres aktualnego obiektu klasy 1)
?>

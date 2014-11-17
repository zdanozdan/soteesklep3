<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  m@sote.pl
 * @version $Id: local_gen_config.inc.php,v 1.2 2006/01/20 13:46:37 scalak Exp $
* @package    pay
* @subpackage platnoscipl
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="platnoscipl_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="platnosciplConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="platnoscipl_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array(
                        "pl_pos_id",
                        "pl_md5_one",
                        "pl_md5_two",
                        "pl_url_ok",
                        "pl_url_fail",
                        "pl_url_check",
                        "email",
                        "status",
                        "active",
                        "sms",
                        );
$gen_config->config=&$platnoscipl_config;                      // przekaz aktualne wartosci obiektu 1)

?>

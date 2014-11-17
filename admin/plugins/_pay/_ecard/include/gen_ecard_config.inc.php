<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  piotrek@sote.pl
 * @version $Id: gen_ecard_config.inc.php,v 1.1 2005/11/29 14:18:52 scalak Exp $
 * @package soteesklep
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="ecard_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="ecardConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="ecard_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array(
                           "ecardAccount",
                           "ecardPassword",
                           "ecardReturnUrl",
                           "ecardCancelReturnUrl",
                           "ecardServerHash",
                           "ecardServerPay",
                           "ecardActive",
                           "ecardStatus",
                           "ecardLang",
                           "ecardPayType",
                           );
$gen_config->config=&$ecard_config;                      // przekaz aktualne wartosci obiektu 1)

?>

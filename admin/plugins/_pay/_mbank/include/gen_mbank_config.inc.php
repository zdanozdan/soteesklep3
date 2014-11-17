<?php
/**
 * Generuj plik konfiguracyjny PHP z danymi dot. PolCardu
 *
 * @author  piotrek@sote.pl
 * @version $Id: gen_mbank_config.inc.php,v 1.3 2004/12/20 18:00:39 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */
if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="mbank_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="mBankConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="mbank_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array(
                           "mbank_merchant_id",
                           "mbank_email",
                           "mbank_mode",
                           "mbank_info",
                           "mbank_server",
                           "mbank_back_ok",
                           "mbank_back_error",
                           "mbank_pass_gpg",
                           "mbank_login",
                           "mbank_password",
                           "mbank_mail_host",
                           "mbank_title_email",
                           "mbank_no_safe",
            );
$gen_config->config=&$mbank_config;                      // przekaz aktualne wartosci obiektu 1)

?>

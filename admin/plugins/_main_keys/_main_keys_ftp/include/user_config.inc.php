<?php
/**
 * Generuj plik konfiguracyjny z wartosciami z tabeli main_keys_ftp
 * 
 * @author  m@sote.pl
 * \@template_version Id: user_config.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: user_config.inc.php,v 1.2 2004/12/20 17:59:58 maroslaw Exp $
 * \@depends ./select.inc.php
* @package    main_keys
* @subpackage main_keys_ftp
 */

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny 
//# 1. oczytaj dane z tabeli 
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;
 
// $__query="SELECT * FROM main_keys_ftp";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("main_keys_ftp_data",array($__main_keys_ftp_data)));  // main_keys_ftp_data -nazwa zmiennej np. $config->main_keys_ftp_data

?>

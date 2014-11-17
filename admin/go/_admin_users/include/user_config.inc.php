<?php
/**
* Generuj plik konfiguracyjny z wartosciami z tabeli admin_users
*
* @author m@sote.pl
* @version $Id: user_config.inc.php,v 2.2 2004/12/20 17:57:53 maroslaw Exp $
* @ignore
* @package    admin_users
*/

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny
//# 1. oczytaj dane z tabeli
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;

// $__query="SELECT * FROM admin_users";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("admin_users_data",array($__admin_users_data)));  // admin_users_data -nazwa zmiennej np. $config->admin_users_data

?>

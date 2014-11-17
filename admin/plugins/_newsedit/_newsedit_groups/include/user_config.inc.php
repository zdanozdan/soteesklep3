<?php
/**
* Generuj plik konfiguracyjny z wartosciami z tabeli newsedit_groups
*
* @author  m@sote.pl
* \@template_version Id: user_config.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
* @version $Id: user_config.inc.php,v 1.3 2004/12/20 18:00:08 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny
//# 1. oczytaj dane z tabeli
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;

// $__query="SELECT * FROM newsedit_groups";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("newsedit_groups_data",array($__newsedit_groups_data)));  // newsedit_groups_data -nazwa zmiennej np. $config->newsedit_groups_data

?>

<?php
/**
 * PHP Template:
 * Generuj plik konfiguracyjny z wartosciami z tabeli discounts
 * 
 * @author m@sote.pl
 * \@template_version Id: user_config.inc.php,v 1.3 2003/02/06 11:55:16 maroslaw Exp
 * @version $Id: user_config.inc.php,v 2.2 2004/12/20 17:59:48 maroslaw Exp $
 * \@depends ./select.inc.php
* @package    discounts
 */

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny 
//# 1. oczytaj dane z tabeli 
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;
 
// $__query="SELECT * FROM discounts";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("discounts_data",array($__discounts_data)));  // discounts_data -nazwa zmiennej np. $config->discounts_data

?>

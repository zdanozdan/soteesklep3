<?php
/**
 * Generuj plik konfiguracyjny z wartosciami z tabeli depository
 * 
 * @author  
 * @template_version Id: user_config.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: user_config.inc.php,v 1.1 2005/11/18 15:33:36 lechu Exp $
 * @package soteesklep
 * @depends ./select.inc.php
 */

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny 
//# 1. oczytaj dane z tabeli 
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;
 
// $__query="SELECT * FROM depository";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("depository_data",array($__depository_data)));  // depository_data -nazwa zmiennej np. $config->depository_data

?>
<?php
/**
 * PHP Template:
 * Generuj plik konfiguracyjny z wartosciami z tabeli reviews
 * 
 * @author m@sote.pl
 * \@template_version Id: user_config.inc.php,v 2.1 2003/03/13 11:28:57 maroslaw Exp
 * @version $Id: user_config.inc.php,v 1.2 2004/12/20 18:00:53 maroslaw Exp $
 * \@depends ./select.inc.php
* @package    reviews
 */

//# obsluga generowania pliku konfiguracyjnego uzytkwonika */
// require_once("include/gen_user_config.inc.php");

//# generuj plik konfiguracyjny 
//# 1. oczytaj dane z tabeli 
//# 2. zapisz je w tablicy 1 wymiarowej $__data
//# 3. zapisz dane w pliku config/auto_config/user_config.inc.php, $gen_config->gen() automatycznie tworzy odpowiedni plik
//#    wystarczy ze jako parametr podamy odpowienia tablice PHP, lub wartosc np. $gen_config->gen(array("x",1)) spowoduje zapisanie
//#    zmiennej $config->x=1;
 
// $__query="SELECT * FROM reviews";
// require_once ("./include/select.inc.php");
// $gen_config->gen(array("reviews_data",array($__reviews_data)));  // reviews_data -nazwa zmiennej np. $config->reviews_data

?>

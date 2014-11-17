<?php
/**
* Plik z podmenu strony raportów
*
* Skrypt generuje menu z linkami do poszczególnych rodzajów raportu:
* produkty, kategorie, producenci, transakcje
* @author  lech@sote.pl
* @version $Id: menu.inc.php,v 1.10 2004/12/20 17:59:03 maroslaw Exp $
* @package    report
*/

print "<div align=right>";
global $config;



    $buttons->menu_buttons(array($lang->report_products=>"/go/_report/index.php?report=q_products",
                                 $lang->report_categories=>"/go/_report/categories.php?report=q_categories",
                                 $lang->report_producers=>"/go/_report/producers.php?report=q_producers",
                                 $lang->report_transactions=>"/go/_report/transactions.php?report=q_transactions",
                                 $lang->help =>"'javascript:window.open(\"/plugins/_help_content/help_show.php?id=15\", \"window\", \"scrollbars=1, width=300, height=500, resizable=1\"); void(0);'"
                                )
                          );

print "</div>";
?>

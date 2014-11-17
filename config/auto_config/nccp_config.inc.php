<?php
/**
 * Konfiguracja nccp
 *
 * @author m@sote.pl
 * $Id: nccp_config.inc.php,v 2.45 2006/03/30 08:42:03 scalak Exp $
* @version    $Id: nccp_config.inc.php,v 2.45 2006/03/30 08:42:03 scalak Exp $
* @package    config

 */

class NccpConfig Extends MyConfig {

    // plugins
    var $plugins_0x1388=array("available",                 // dostepnosc
                              "newsedit",                  // edycja newsow
                              "in_category",               // inne produkty z tej samej kategorii
                              "accessories",               // akcesoria
                              "pasaz.onet.pl",             // integracja z pasaz.onet.pl
                              "pasaz.wp.pl",               // integracja z pasaz.wp.pl
                              "pasaz.interia.pl",          // integracja z zakupy.interia.pl
                              "ceneo.pl",                  // ceneo 
                              "hidden_price",              // nie pokazuj ceny/zapytaj o cene
                              "currency",                  // waluty
                              "newsletter",                // newsletter - korespondencja seryjna
                              "producer_list",             // listy producentow w kategoriach
                              "order_by_list",             // sortowanie
                              "choose_list",               // format wyswietlania rekordow short|long
                              #"ecard",                    // platnosc karta - system eCard
                              "polcard",                   // platnosc karta - system PolCard
                              #"polcard_adv",              // platnosc karta - system PolCard - wersja zaawansowana
                              #"payu",                     // platnosc poprzez PayU (payu.pl)
                              #"mbank",                    // platnosc poprzez mTransfer (mbank.pl)
                              #"inteligo",                 // platnosc poprzez Inteligo (inteligo.pl)
                              "promotion",                 // centrum promocji
                              "discounts",                 // rabaty % dla produktu
                              "product_discounts",         // rabaty % wg kategorii/producenta
                              "producers_category",        // "podlisty" kategorii dla producentow
                              "stats_pro",                 // zaawansowane statystyki w wersji Pro
                              "multi_lang",                // obsluga multi-lang
                              "main_keys",                 // doladowywanie kodow do produktow, sprzedaz kodow on-line,
                              "partners",                  // program partnerski    
                              #"confirm_online",           // potwierdzanie online platnosci
                              "happy_hour",                // modul happy hour                           
                              "cd", 					   // wersja CD 
                              "reviews",                   // recenzje 
                              "extbasket",                 // zalaczanie plików i opisów do zamowienia
                              "in_category",			   // produkty w tej samej kategorii
                              "paypal",                    // system platnosci paypal
                              "przelewy24",                // p³atno¶æ przez system przelewy24.pl,
                              "platnoscipl",               //  p³atno¶æ przez system platnosciPL
                              );

    var $plugins_0x01f4=array(
                              "accessories",               // akcesoria
                              "available",                 // dostepnosc
                              "newsedit",                  // edycja newsow                          
                              "producer_list",             // listy producentow w kategoriach
                              "order_by_list",             // sortowanie
                              "choose_list",               // format wyswietlania rekordow short|long
                              "newsletter",				   // newsletter - korespondencja seryjna
                              "reviews",				   // recenzje
                              "in_category",			   // produkty w tej samej kategorii
                              "accessories",               // akcesoria
                              "hidden_price",              // nie pokazuj ceny
                              "partners",                  // program partnerski    
                              "pasaz.onet.pl",             // integracja z pasaz.onet.pl
                              "producers_category",        // "podlisty" kategorii dla producentow
                              );
}

$config = new NccpConfig;
$config->nccp=$__nccp;
$plugins="plugins_".$config->nccp;
$config->plugins=&$config->$plugins;
?>

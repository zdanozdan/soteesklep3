<?php
/**
 * Konfiguracja glowna
 *
 * @author  m@sote.pl
 * @version $Id: config.inc.php,v 1.2 2004/12/20 18:01:32 maroslaw Exp $
* @package    default
 */

class Config {
    var $version="2.6.0";                // wersja SOTEeSKLEP

    var $devel=1;                        // devel=1, wersje debveloperska sklepu

    var $dbtype="mysql";                 // rodzaj bazy danych [pgsql|mysql|oracle|...], obecnie tylko mysql
    var $dbname;                         // nazwa bazy danych
    var $dbuser;                         // dane anonimowego uzytkwonika
    var $dbpass;                         // jw. haslo
    var $dbhost;                         // serwer bazy danych    

    var $demo="no";                      // yes - wersja demo, no - wersja produkcyjna
    var $demo_time="no";                 // yes - demo czasowe
    
    var $logs=1;                         // poziom logowania
    
    var $cd=0;                           // cd = 1; wesja CD

    // start sv:
    var $simple="no";			         // yes - simple virtual no - na dwoch domenach	
    var $htdocs_dir="";                  // prefix URL do htdocs dla SV
    var $admin_dir="";                   // prefix URL do admin dla SV
    var $url_prefix="";                  // prefix URL = htdocs_dir lub admin_dir w zaleznosci skad skrypt jest wywolywany
    // end sv:

    var $www="soteesklep2";              // adres internetowy sklepu

    var $lang="pl";                      // domyslny jezyk
    var $base_lang="pl";                 // jezyk bazowy sklepu
                                         // tablica z dostepnymi jezykami   
    var $languages=array("pl","de","en");
    
    var $languages_names=array("pl"=>"Polski",
                               "en"=>"English",
                               "de"=>"German"
                               );              


    // tematy wygladu sklepu
    var $base_theme="base_theme";        // nazwa bazowego tematu
    var $theme="blue";                   // nazwa tematu wygladu sklepu
    // lista dotepnych tematow wygladu sklepu   
    var $themes=array("redball"=>"redball",
                      "blueball"=>"blueball",
                      "art_orange"=>"art orange",
                      "blue"=>"blue",
                      "red"=>"red",
                      "green"=>"green",
                      "brown"=>"brown"
                      );     


    // tematy wygladu panelu administratora
    var $admin_base_theme="base_theme";  // nazwa bazowego tematu
    var $admin_theme="green";            // nazwa tematu wygladu sklepu
    // lista dotepnych tematow wygladu panelu administracyjnego
    var $admin_themes=array("base_theme"=>"standard",
                            "green"=>"jungle"
                            );
    

    // adres sklepu, ssl
    var $ssl="no";                       // czy sklep dziala z SSL'em?

    var $currency="PLN";                 // domyslna waluta
    var $default_vat="22";               // jesli vat nie jest zdefiniowany, to wstaw zdefiniowana stawke vat

    var $order_email="m@local";          // konto, na ktore sa wysylane zamowienia
    var $from_email="m@local";           // od kogo beda wysylane wiadomosci z zamowieniem
    var $newsletter_email="m@local";     // na to konto beda wysylane adresy z newslettera

    var $merchant=array();               // dane adresowe sprzedawcy

    // 100 KB
    var $max_file_size=1000000;          // maksymalna wielkosc uploadowanego pliku w bajtach
    
    // dane konta ftp, na ktorym jest zainstalowany program
    var $ftp_dir="/home/maroslaw/soteesklep2/devel";
    //var $ftp_user="maroslaw";
    var $ftp_password=-1;                // UWAGA! nie wpisywac tu hasla!
    //var $ftp_host="192.168.1.1";
    var $ftp_port="21";
    
    // salt - dla kazdego sklepu nazlezy dowolnie zmienic ta wartosc
    var $salt='12345678901234567890123456789012';                        // sol - indywidualny kod wymagany do kodowania 

    // _firm  - dane dot. odbiorcow hutorych
    var $firm_login="hurt";
    var $firm_password="12345678901234567890123456789012"; // md5("haslo dla odbiorcow hurtowych");
        
    // eCard
    var $ecard_servlet="http://adres_servleta_ecardu";

    // /go/_basket/_photo zalaczanie zdjec do produktow
    var $basket_photo=false;

    // czy zdjecia robione sa aparatem cyfrowym? Jesli tak to nadawaj automatycznie nazwy zdjeciom wg. id 
    var $cyfra_photo="yes";

    // listy produktow na stornie, "short" - lista uproszczona bez zdjec i opisu, "long" - pelna lista ze zdjeciami i krotkim opisem
    var $products_on_page=array("short"=>20,
                                "long"=>10                                
                                );
    // domylny rodzaj listy proudktow "short", "long" jw.
    var $record_row_type_default="long"; 

    /**
     * Okresl katalog "tematu"
     *
     * @return string katalog np. /home/www/webapps/htdocs/themes/_pl/standard
     */
    function theme_dir(){
        global $_SERVER;
        $this->theme_dir=$_SERVER['DOCUMENT_ROOT']."/themes/_".$this->lang."/".$this->theme;
        return $this->theme_dir;
    }

    // id+nazwy metod platnosci
    var $pay_method=array("1"=>"Za zaliczeniem",
                          "2"=>"eCard",
                          "3"=>"PolCard",
			  "4"=>"Inteligo",
			  "5"=>"mBank"
			 );


    // rodzaj prezentacji kategorii
    var $category=array("type"=>"standard",  // "treeview" - dynamiczne JS+DHTML, "standard" - statyczne z przeladowaniem strony
                        "use_frames"=>"yes"  // "yes" - uzyj ramek dla kategorii
                        );
    var $browsers_nojavascript=array("Mozilla/4","konqueror","safari"); // przegladarki, ktore nie obsluguja javascript wymaganego dla Treeview

    // dostepnosc - wartosc tablicy jest definiowana dynamicznie w ./auto_config/user_config.inc.php
    var $availabale=array();
    
    // zmienne, ktore sa zpisywane przez uzytkwonika w ./auto_config/user_config.inc.php
    var $user_vars=array("db","ftp","salt","md5_pin","license","auth_sign","config_setup",
                         "order_points","available","currency_data","currency_name",
                         "category","stats","merchant","order_email","from_email","newsletter_email","www",
                         "currency");

    var $in_category_down=3;     // [1-5] ilosc porownywanych kategorii przy liscie produktow z tej samej kategorii
    // czy promocje, nowosci oraz wyszukiwanie maja zalezec od wybranego producenta?
    var $producers_category_filter="yes";    
    // wprowadz id producenta i odpowiedni dla niego temat
    var $themes_producers=array("12"=>"art_orange");
    // wprowadz id kategorii i odpowieni temat dla danej kategorii np. 18, 18_1, 18_1_4 itp.
    var $themes_category=array("18"=>"art_orange");
    // end plugins

    // ocena ryzyka transakcji  \@depend  $lang->pay_fraud
    // true - nie wyswietlaj ostrzezenia, false - wyswietl ostrzezenie przy transakcji
    // wartosc <0 oznacza inne zagrozenia, ktore nalezy zglosic pilnie do amdinistratora
    var $pay_fraud=array("1"=>-1,
                         "2"=>-1,
                         "10"=>-1,
                         "300"=>true,
                         "301"=>true,
                         "302"=>false,
                         "303"=>false
                         );

    // ilosc dni przed koncem terminu rozliczenia transakcji, kiedy system ostrzega sprzedawce o koniecznosci potwierdzenia transakcji
    var $order_alert_days=3;
    // ilosc dni, po ktorych transakcja nie bedzie przyjeta wg. id_pay_method
    var $order_timeout=array("2"=>7,
                             "3"=>7,
                             "4"=>30
                             );

}

// ------------------------------ koniec konfiguracji----------------------------------------

// odczytaj konfiguracje wygenerowana automatycznie i utworz obiekt $config
require_once("config/auto_config/config.inc.php"); 

// odczytaj konfiguracje uzytkownika (ustawiane przez panel on-line)
require_once("config/auto_config/user_config.inc.php");

// odczytaj dane licencji
$lckey=substr($config->license['nr'],12,2);
switch ($lckey) {
 case "01": $__nccp="0x1388";  break;
 case "11": $__nccp="0x1388";  break;
 case "02": $__nccp="0x01f4";  break;
 default: $__nccp="0x01f4"; break;
}
// end

// odczytaj konfiguracje nccp
require_once ("config/auto_config/nccp_config.inc.php");

if (empty($config)) {
    $config = new Config;
}

$config->theme_dir();

// sprawdz czy jest zdefiniowany indywidualny klucz aplikacji
$secure_key=ini_get("disable_function");
if ((! empty($secure_key)) && (eregi("^[0-9a-z]${32}"))) {
    $config->salt=$secure_key;
}

// wlacz demo tylko w panelu demo
if (ereg("htdocs$",$DOCUMENT_ROOT)) {
    $config->demo="no";
}

// sprawdz przegladarke i jesli przegladarka nie obsluguje javascript (tj. treeview) to wlacz statyczne menu
foreach ($config->browsers_nojavascript as $browser) {
    if (eregi($browser,$_SERVER['HTTP_USER_AGENT'])) {
        $config->category['type']="standard";   
    }
} // end foreach

// start patch simple_virtual
// Dodanie zmiennych $config->admin_dir i $config->htdocs_dir, ktore zaweiraja siczki
// instalacji sklepu i panelu administracyjnego
// Wartosci tych zmiennych sa okreslone w dodatkowym pliku konfiguracyjnym
// config/auto_config/server_config.inc.php
if($config->simple == 'yes') {
    $config->url_prefix='';
    @include_once ("config/auto_config/server_config.inc.php");
    if ((! empty($config->htdocs_dir)) && (! empty($config->admin_dir))) {
        if (ereg("admin$",$DOCUMENT_ROOT)) {
    	    $config->url_prefix=&$config->admin_dir;
        } else {
            $config->url_prefix=&$config->htdocs_dir;
        }
    }
}

$config->theme_dir=$DOCUMENT_ROOT."/themes/_".$config->lang."/".$config->theme;

//end patch simple_virtual

// UWAGA! po zamknieciu PHP nie moze byc zadnych znakow! inaczej pojawi sie warning przed
// otwarciem sesji
?>

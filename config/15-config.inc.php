<?php
/**
* Konfiguracja systemowa sklepu.
*
* UWAGA! Plik tem mo¿e byæ edytowany tylko przez progamistów, którzy dok³adnie wiedz± co zmieniaj±. Nie jest to
* plik konfiguracji sklepu dla uzytkowników sklepu.
*
* Wiele warto¶ci zdefiniowanych i opisach w klasie Config,
* jest nadpisywana przez inne pliki konfiguracyjne np. plik tworzony z definicjami w wprowadzanymi w panelu
* config/auto_config/user_config.inc.php, dlatego te¿ zmiana warto¶ci nie zawsze spodowuje to, czego oczekujemy.
* Je¶li chcemy wprowadzaæ zmiany to nale¿y dok³adnie prze¶ledziæ ca³± drogê generowania danych dla obiektu
* $config.
*
* @author  m@sote.pl lech@sote.pl
* @version $Id: config.inc.php,v 2.129 2006/07/07 06:47:37 cvs Exp $
*
* @package    default
* \@lang
* \@encoding
*/

/**
* G³ówna klasa konfiguracji sklepu.
* @package config
* @subpackage base
*/
class Config {

    /**
    * Wersja SOTEeSKLEP. Seria.
    */
    var $version="3.5.x";

    /**
    * Numer pakietu aktualizcyjnego, który ma byæ instalowany dla tej wersji jako pierwszy.
    * Uwaga! Warto¶c ta MUSI byæ zmieniana przy ka¿dym generowaniu nowego numeru wersji. 
    * Wstawiamy tu numer kolejnego uaktualnienia, które zostanie wydane po wydaniu wersji.
    */
    var $pkg_first_number=13;

    
    /**
    * devel=1, wersje debveloperska sklepu.
    * @ignore
    * @todo dodac obs³ugê trybu dla developerów
    */
    var $devel=1;

    /**
    * Rodzaj bazy danych; obecnie tylko mysql.
    */
    var $dbtype="mysql";

    /**
    * Nazwa bazy danych. Pod t± zmienn± zostan± podstawione odszyfrowane dane dot. bazy danych.
    */
    var $dbname;

    /**
    * Nazwa u¿ytkownika dostêpu do bazy danych.
    */
    var $dbuser;

    /**
    * Has³o dostêpu do bazy danych.
    */
    var $dbpass;

    /**
    * Serwer bazy danych.
    */
    var $dbhost;

    /**
    * Okre¶lenie czy dana wersja jest demonstracyjn?: yes - wersja demo, no - wersja produkcyjna
    * Je¶li demo jest w³±czone to panel sklepu jest tylko w trybie do odczytu.
    * @todo zmieni? "yes"=>1, "no"=>0
    */
    var $demo="no";

    /**
    * Okre¶lenie poziomu logowania. 1 - logowanie w³±czone, 0 - wy³aczone
    */
    var $logs=1;                         // poziom logowania

    /**
    * Okre?lenie trybu parcy sklepu.
    * Je¶li cd=1 to wy³±czane s± niektóre funkcje, dziêki czemu sklep ³atwiej jest zgraæ na CD.
    * Opcja ta jest prze³±czana z panelu.
    */
    var $cd=0;

    /* @deprecated since 3.0 */
    var $simple="no";

    /**
    * Prefix URL do htdocs dla SV
    * @deprecated since 3.0
    */
    var $htdocs_dir="";

    /**
    * Prefix URL do admin dla SV
    * @deprecated since 3.0
    */
    var $admin_dir="";

    /**
    * prefix URL = htdocs_dir lub admin_dir
    * @deprecated since 3.0
    */
    var $url_prefix="";
    // end sv:

    /**
    * Adres internetowy sklepu. Zmienna konfigurowana z panelu.
    */
    var $www;

    /**
    * @var int category_multi 1 - w³±cz opcjê: 1 produkt w kilku kategoriach, 0 - w p.w.
    */
    var $category_multi=1;

    /**
    * @var int Zmienna odpowiedzialna za wy¶wietlenie w sklepie listy walut do wyboru.
    */

    var $currency_show_form=1;
    
    // ************** LANG
    var $langs_symbols = array(
        0 => "pl",
        1 => "en",
        2 => "de",
        3 => "cz",
        4 => "ru",
    );

    var $langs_names = array(
        0 => "Polski",
        1 => "English",
        2 => "Deutsch",
        3 => "Cestina",
        4 => "Russkij",
    );

    var $langs_encoding = array(
        0 => "052|iso-8859-2",
        1 => "018|iso-8859-1",
        2 => "031|iso-8859-1",
        3 => "015|iso-8859-2",
        4 => "000|utf-8",
    );

    var $langs_active = array(
        0 => 1,
        1 => 1,
        2 => 1,
        3 => 1,
        4 => 1,
        );
    
    var $lang_id = 0;

    // ************** LANG - END
    
    /**
    * Jêzyk w którym bêdzie domy¶lnie pracowaæ sklep. Aktualna warto¶æ jezyka, w którym pracuje sklep.
    * Po zmianie jêzyka jest modyfikaowana ta zmienna.
    */
    var $lang="en";

    /**
    * Domy¶lny jêzyk w sklepie (nie w panelu). Zmienna ta ma t± sam± warto¶æ co $config->lang.
    * Jest ona wykorzystywana w panlu do sprawdzenia jêzyka zdefiniowanego dla sklepu, gdy¿
    * w panelu zmienna $config->lang ma warto¶æ aktualnie wy¶wietlanego jêzyka dla panelu, co
    * nie musi sie zgadzaæ z ustawieniami dla sklepu.
    */
    var $htdocs_lang="en";

    /**
    * Bazowy jêzyk sklepu. Wed³ug tego jezyka s± przypisywane g³ówne warto¶ci $lang, nastêpnie
    * odczytywane s± warto¶ci dla jêzyka $config->lang, które nadpisuj± wcze¶niejsze definicje.
    * Aktualnie zawsze warto¶æ "pl". 
    */
    var $base_lang="pl";

    /**
    * Jêzyk w którym bêdzie domy¶lnie pracowaæ panel administracyjny sklepu.
    */
    var $admin_lang="en";

    /**
    * Dostêpne jêzyki w sklepie. Oznaczenia.
    */
    var $languages=array("en","de","pl");
    /**
    * Nazwy jêzyków wg oznacze?.
    */
    var $languages_names=array
    (
    "en"=>"English",
    "de"=>"Deutsch",
    "pl"=>"Polski",
    );

    var $lang_active=array(
    "pl"=>1,
    "en"=>1,
    "de"=>1,

    );

    /**
    * @var array Zmienna odpowiedzialna za przypisanie odpowiedniej waluty odpowiediej wersji jêzykowej.
    */

    var $currency_lang_default=array("pl"=>1);

    // start tematy wygl±du sklepu:
    /**
    * Nazwa tematu bazowego
    */
    var $base_theme="base_theme";

    /**
    * Nazwa tematu koñcowego(tematu  wygl±du).
    * temat okre¶la katalog, w którym bêd± wyszukiwane odpowiednie pliki/szablony prezentacji itp.
    */
    var $theme="blue";

    /**
    * Lista dotêpnych tematow wygl±du sklepu
    */
    var $themes=array
    (
    "redball"=>"redball",
    "blueball"=>"blueball",
    "red"=>"red",
    "blue"=>"blue",
    "green"=>"green",
    "brown"=>"brown",
    "blueday"=>"blueday",
    "grayday"=>"grayday",
    "bluelight"=>"bluelight",
    "pinklight"=>"pinklight",
    );
    // end tematy wygl?du sklepu:

    // start tematy wygladu panelu administratora:
    /**
    * Nazwa bazowego tematu w panelu amdinistracyjnym.
    */
    var $admin_base_theme="base_theme";

    /**
    * Nazwa tematu koñcowego w panelu amdinistracyjnym.
    */
    var $admin_theme="base_theme";

    /**
    * Lista dotêpnych tematów wygladu panelu administracyjnego.
    */
    var $admin_themes=array
    (
    "base_theme"=>"standard",
    "green"=>"jungle",
    "box"=>"box",
    );
    // end tematy wygladu panelu administratora:

    /**
    * Okre¶lenie czy dla sklepu dostêpna jest obs³uga SSL.
    */
    var $ssl=0;

    /**
    * @var string Domy¶lna waluta, w której bêda prezentowane i zapisywane ceny.
    *             Jest to waluta rozliczenia.
    */
    var $currency="PLN";

    /**
    * Konto, na które s± wysylane zamówienia.
    */
    var $order_email='';

    /**
    * Od kogo bêd± wysy³ane wiadomo¶ci z zamówieniem.
    */
    var $from_email='';

    /**
    * Dane sprzedawcy - edytowane z panelu.
    */
    var $merchant=array();

    /**
    * @var array lista edytowalnych tematow wygladu sklepu
    */
    var $editable_themes=array(
    "blue"=>"blue",
    "redball"=>"redball",
    "blueday"=>"blueday",
    "grayday"=>"grayday",
    "bluelight"=>"bluelight",
    "pinklight"=>"pinklight",
    );

    /**
    * Maksymalna wielko?? uploadowanego pliku w bajtach: 1000000=1MB
    */
    var $max_file_size=1000000;


    // start FTP:
    // dane konta ftp, na ktorym jest zainstalowany program
    var $ftp_dir='';
    var $ftp_password=-1;                // UWAGA! nie wpisywac tu hasla!
    var $ftp_port="21";
    // end FTP:

    /**
    * Dodatkowy klucz wykorzystywany do kodowania.
    * Po zainstalowaniu sklepu NIE WOLNO zmieniaæ tej warto¶ci.
    */
    var $salt='12345678901234567890123456789012';

    /**
    * Adres servleta eCard
    * @deprecated since 3.0
    */
    var $ecard_servlet="http://adres_servleta_ecardu";
    // Ujednolicenie kolorów elementach sklepu
    var $colors=array("light"=>"#E9F0F8",
    "dark"=>"#6699cc",
    );

    /**
    * Opcja okre¶la, czy w sklepie mo¿na do³±czaæ zdêcia do zamówionych produktów np. zdjêcie na nadruki na koszulki.
    * /go/_basket/_photo zalaczanie zdjec do produktow
    */
    var $basket_photo="no";

    /**
    * Czy zdjêcia robione sa aparatem cyfrowym? Jesli tak to nadawaj automatycznie nazwy zdjeciom wg. id
    */
    var $cyfra_photo=1;

    /**
    * Typ ceny jaki siê ma wyswietlaæ: netto, brutto, netto/brutto
    */
    var $price_type="netto/brutto";

    /**
    * Ilo¶c produktów na listach w zale¿no¶ci od typu listy.
    * "short" - lista uproszczona bez zdjec i opisu, "long" - pelna lista ze zdjeciami i krotkim opisem
    */
    var $products_on_page=array
    (
    "short"=>20,
    "long"=>10
    );

    /* Domy¶lny rodzaj listy proudktow "short", "long" jw. */
    var $record_row_type_default="long";

    var $vat_confirm=1;

    /**
    * Rozmiary du¿ych i ma³ych zdjêæ na listach i w informacjach szczeg³oowych produktów.
    */
    var $image=array
    (
    "max_size" =>"300",
    "min_size" =>"115",
    );
	
    /**
    * Poka¿ numer id produktu w sklepie
    */
    
    var $show_user_id=1;
    
    /**
    * Od jakiego numeru numerowaæ transakcje, domy¶lne id startowe transakcji
    */

    var $id_start_orders_default=1;

    /**
    * Okre¶lenie czy wstawiamy okienko newsletter na stronie
    */
    var $newsletter=1;

    /**
    * Okre¶lenie czy wstawiamy newsedit na g³ównej stronie sklepu
    */

    var $newsedit=0;

    /**
    * Newsedit w kolumnach jednej czy dwoch
    */

    var $newsedit_columns_default=1;

    /**
    * Dpmy¶lna ilo¶æ produktów kolumnach promocje,nowosci itd
    */
    var $random_on_page=array("promotion"=>2,
    "newcol"=>3,
    "bestseller"=>2,
    );

    /**
    * Domy¶lny rodzaj sortowania produktów na listach.
    */
    var $main_order_default="name_L0";

    /**
    * Pola, ktore musz byc zaselectowane do odczytania nazwy produktu, producenta i ceny
    */
    var $select_main_price_list="id,user_id,name_L0,name_L1,name_L2,name_L3,name_L4,producer,price_brutto,vat,price_brutto_detal,photo,price_brutto_2,hidden_price,ask4price,discount,price_currency,id_currency,id_category1,id_category2,id_category3,id_category4,id_category5,id_producer,max_discount,points,points_value";


    /**
    * Metody p³atno¶ci dostêpne w sklepie.
    * UWAGA! Nie mo¿na zmieniaæ ID.
    */
    var $pay_method=array
    (
    "1"=>"Za zaliczeniem",
    "2"=>"eCard",
    "3"=>"PolCard",
    //"4"=>"Inteligo",
    "5"=>"mBank",
    // "6"=>"CitiConnect",
    // "7"=>"PayU",
    "8"=>"WBK",
    "81"=>"Przy odbiorze",
    // "9"=>"SMS",
    "11"=>"Przelew",
    "12"=>"Przelewy24",
    "20"=>"PlatnosciPL",
    "21"=>"Allpay",
    "101"=>"PayPal",
    "110"=>"P³atno¶æ Kart±",
    // "30"=>"AllPay",
    "999"=>"DefaultPay",
    );

    /**
    *Aktywacja wybranej metody platnosci
    */
    var $pay_method_active=array
    (
    "1"=>1,
    "11"=>1,
    "110"=>0,
    );



    /**
    * Rodzaj prezentacji kategorii
    * "treeview" - dynamiczne JS+DHTML, "standard" - statyczne z przeladowaniem strony
    */
    var $category=array
    (
    "type"=>"standard",
    );

    /**
    * Przegladarki, ktore nie obs³uguj± javascript wymaganego dla Treeview.
    *
    * zachowana dla zgodno?ci
    * @deprecated since 3.0
    */
    var $browsers_nojavascript=array();
    // var $browsers_nojavascript=array("Mozilla/4","konqueror","safari");

    /**
    * Dostepno¶æ. Tablica ID->nazwa.
    * Warto¶æ tablicy jest definiowana dynamicznie w ./auto_config/user_config.inc.php
    */
    var $availabale=array();

    /**
    * @var array tablica ze zmiennymi, ktore sa zpisywane przez uzytkwonika w ./auto_config/user_config.inc.php
    */
    var $user_vars=array("db","ftp","salt","md5_pin","license","auth_sign","config_setup",
    "order_points","available","currency_data","currency_name",
    "category","stats","merchant","order_email","from_email","newsletter_email",
    "www","currency","cd_setup","theme","themes_active",
    "record_row_type_default","producers_category_filter","google",
    "price_type","currency","products_on_page","google","image",
    "main_order_default","vat_confirm","id_start_orders_default","newsedit_columns_default",
    "lang","lang_id","lang_active","currency_lang_default",
    "category_multi","newsedit","newsletter","currency_show_form","cyfra_photo",
    "basket_photo","htdocs_lang","pay_method_active","random_on_page","themes","theme","fields",
    "editable_themes","admin_lang","home","in_category_down","catalog_mode","rss_link","happy_hour"	,"country_select",
    "langs_symbols","langs_names","langs_active","langs_encoding","users_online","unit","id_shop","ssl","catalog_mode_options",
    "ranking1_max_length","ranking2_max_length","ranking1_enabled","ranking2_enabled","depository",
    "basket_ext","basket_wishlist","display_availability","show_user_id",
    );

    // w³±czenie linków rss pod newsami
    var $rss_link="1";
	
    // wy³±czenie poszerzonych informacji o produkcie w koszyku
    var $basket_ext="0";

    var $themes_active=array();
    // w³±czenie trybu dla programistu
    var $debug=0;
    // w³±czenie trybu katalogowego - wy³±czenie koszyka
    var $catalog_mode=0;
    // opcje katalogu
    var $catalog_mode_options=array(
    "currency"=>"0",
    "users"=>"0",
    "newsletter"=>"0",
    "newsedit"=>"0",
    "price"=>"0",
    );
    // [1-5] ilosc porownywanych kategorii przy liscie produktow z tej samej kategorii
    var $in_category_down=3;
    // czy promocje, nowosci oraz wyszukiwanie maja zalezec od wybranego producenta?
    var $producers_category_filter="yes";
    // wprowadz id producenta i odpowiedni dla niego temat
    var $themes_producers=array("12"=>"art_orange");
    // wprowadz id kategorii i odpowieni temat dla danej kategorii np. 18, 18_1, 18_1_4 itp.
    var $themes_category=array("18"=>"art_orange");
    // end plugins


    /**
    * Ocena ryzyka transakcji  \@depend  $lang->pay_fraud
    * true - nie wyswietlaj ostrzezenia, false - wyswietl ostrzezenie przy transakcji
    * wartosc <0 oznacza inne zagrozenia, ktore nalezy zglosic pilnie do amdinistratora
    */
    var $pay_fraud=array
    (
    "1"=>-1,
    "2"=>-1,
    "10"=>-1,
    "300"=>true,
    "301"=>true,
    "302"=>false,
    "303"=>false
    );

    /**
    * Ilosc dni przed koncem terminu rozliczenia transakcji, kiedy system ostrzega sprzedawce o koniecznosci potwierdzenia transakcji
    */
    var $order_alert_days=3;

    /**
    * Ilo¶æ dni, po ktorych transakcja nie bedzie przyjeta wg. id_pay_method
    */
    var $order_timeout=array("2"=>7,
    "3"=>7,
    "4"=>30
    );

    /**
    * Okre¶lenie kolumn sortowania wg parametru $order - dla tablicy main
    */
    var $dbedit_order_names=array('main'=>array
    (
    "1"=>"name",
    "-1"=>"name DESC",
    "2"=>"price_brutto",
    "-2"=>"price_brutto DESC",
    "3"=>"producer",
    "-3"=>"producer DESC",
    "default"=>"price_brutto"
    )
    );

    var $default_country = 'PL';

    /**
    * Domy¶lna konfiguracja nazwy, tytu³u strony itp.
    */
    var $google=array("title"=>"SOTEeSKLEP",
    "keywords"=>"sklep internetowy",
    "description"=>"sklep internetowy");

    var $users_online = 1;
    
    var $unit = "kg";
    
    var $supported_encoding = array (
    "utf-8" => "000|utf-8",
    "ISO" => array(
        "Afrikaans (iso-8859-1 Latin-1)"                              =>  "001|iso-8859-1" ,
        "Albanian (iso-8859-1 Latin-1)"                               =>  "002|iso-8859-1" ,
        "Albanian (iso-8859-16 Latin-10 South-Eastern European)"      =>  "003|iso-8859-16",
        "Arabic (iso-8859-6 Arabic)"                                  =>  "004|iso-8859-6" ,
        "Azerbaijani (iso-8859-9 Latin-5 Turkish)"                    =>  "005|iso-8859-9" ,
        "Baltic Rim (iso-8859-13 Latin-7 Baltic Rim)"                 =>  "006|iso-8859-13",
        "Basque (iso-8859-1 Latin-1)"                                 =>  "007|iso-8859-1" ,
        "Belarusian (iso-8859-5 Cyrillic)"                            =>  "008|iso-8859-5" ,
        "Brazilian portuguese (iso-8859-1 Latin-1)"                   =>  "009|iso-8859-1" ,
        "Breton (iso-8859-14 Latin-8 Celtic)"                         =>  "010|iso-8859-14",
        "Bulgarian (iso-8859-5 Cyrillic)"                             =>  "011|iso-8859-5" ,
        "Catalan (iso-8859-1 Latin-1)"                                =>  "012|iso-8859-1" ,
        "Croatian (iso-8859-2 Latin-2)"                               =>  "013|iso-8859-2" ,
        "Croatian (iso-8859-16 Latin-10 South-Eastern European)"      =>  "014|iso-8859-16",
        "Czech (iso-8859-2 Latin-2)"                                  =>  "015|iso-8859-2" ,
        "Danish (iso-8859-1 Latin-1)"                                 =>  "016|iso-8859-1" ,
        "Dutch (iso-8859-1 Latin-1)"                                  =>  "017|iso-8859-1" ,
        "English (iso-8859-1 Latin-1)"                                =>  "018|iso-8859-1" ,
        "English (iso-8859-15 Latin-9 Latin-0)"                       =>  "019|iso-8859-15",
        "Esperanto (iso-8859-3 Latin-3 South European)"               =>  "020|iso-8859-3" ,
        "Estonian (iso-8859-1 Latin-1)"                               =>  "021|iso-8859-1" ,
        "Estonian (iso-8859-4 Latin-4 North European)"                =>  "022|iso-8859-4" ,
        "Faroese (iso-8859-1 Latin-1)"                                =>  "023|iso-8859-1" ,
        "Finnish (iso-8859-1 Latin-1)"                                =>  "024|iso-8859-1" ,
        "Finnish (iso-8859-16 Latin-10 South-Eastern European)"       =>  "025|iso-8859-16",
        "French (iso-8859-1 Latin-1)"                                 =>  "026|iso-8859-1" ,
        "French (iso-8859-15 Latin-9 Latin-0)"                        =>  "027|iso-8859-15",
        "French (iso-8859-16 Latin-10 South-Eastern European)"        =>  "028|iso-8859-16",
        "Gaelic (iso-8859-14 Latin-8 Celtic)"                         =>  "029|iso-8859-14",
        "Galician (iso-8859-1 Latin-1)"                               =>  "030|iso-8859-1" ,
        "German (iso-8859-1 Latin-1)"                                 =>  "031|iso-8859-1" ,
        "German (iso-8859-15 Latin-9 Latin-0)"                        =>  "032|iso-8859-15",
        "German (iso-8859-16 Latin-10 South-Eastern European)"        =>  "033|iso-8859-16",
        "Greek (iso-8859-7 Greek)"                                    =>  "034|iso-8859-7" ,
        "Greenlandic (iso-8859-4 Latin-4 North European)"             =>  "035|iso-8859-4" ,
        "Hebrew (iso-8859-8)"                                         =>  "036|iso-8859-8" ,
        "Hungarian (iso-8859-2 Latin-2)"                              =>  "037|iso-8859-2" ,
        "Hungarian (iso-8859-16 Latin-10 South-Eastern European)"     =>  "038|iso-8859-16",
        "Indonesian (iso-8859-1 Latin-1)"                             =>  "039|iso-8859-1" ,
        "Icelandic (iso-8859-1 Latin-1)"                              =>  "040|iso-8859-1" ,
        "Irish (iso-8859-1 Latin-1)"                                  =>  "041|iso-8859-1" ,
        "Irish Gaelic (iso-8859-16 Latin-10 South-Eastern European)"  =>  "042|iso-8859-16",
        "Italian (iso-8859-1 Latin-1)"                                =>  "043|iso-8859-1" ,
        "Italian (iso-8859-16 Latin-10 South-Eastern European)"       =>  "044|iso-8859-16",
        "Latin (iso-8859-1 Latin-1)"                                  =>  "045|iso-8859-1" ,
        "Latvian (iso-8859-4 Latin-4 North European)"                 =>  "046|iso-8859-4" ,
        "Lithuanian (iso-8859-4 Latin-4 North European)"              =>  "047|iso-8859-4" ,
        "Malay (iso-8859-1 Latin-1)"                                  =>  "048|iso-8859-1" ,
        "Maltese (iso-8859-3 Latin-3 South European)"                 =>  "049|iso-8859-3" ,
        "Nordic (iso-8859-10 Latin-6)"                                =>  "050|iso-8859-10",
        "Norwegian (iso-8859-1 Latin-1)"                              =>  "051|iso-8859-1" ,
        "Polish (iso-8859-2 Latin-2)"                                 =>  "052|iso-8859-2" ,
        "Polish (iso-8859-16 Latin-10 South-Eastern European)"        =>  "053|iso-8859-16",
        "Portuguese (iso-8859-1 Latin-1)"                             =>  "054|iso-8859-1" ,
        "Portuguese (iso-8859-15 Latin-9 Latin-0)"                    =>  "055|iso-8859-15",
        "Romanian (iso-8859-1 Latin-1)"                               =>  "056|iso-8859-1" ,
        "Romanian (iso-8859-2 Latin-2)"                               =>  "057|iso-8859-2" ,
        "Romanian (iso-8859-16 Latin-10 South-Eastern European)"      =>  "058|iso-8859-16",
        "Russian (iso-8859-5 Cyrillic)"                               =>  "059|iso-8859-5" ,
        "Sami (iso-8859-4 Latin-4 North European)"                    =>  "060|iso-8859-4" ,
        "Scotish (iso-8859-1 Latin-1)"                                =>  "061|iso-8859-1" ,
        "Serbian (in Latin transcription) (iso-8859-2 Latin-2)"       =>  "062|iso-8859-2" ,
        "Serbocroatian (iso-8859-2 Latin-2)"                          =>  "063|iso-8859-2" ,
        "Slovak (iso-8859-2 Latin-2)"                                 =>  "064|iso-8859-2" ,
        "Slovenian (iso-8859-2 Latin-2)"                              =>  "065|iso-8859-2" ,
        "Slovenian (iso-8859-16 Latin-10 South-Eastern European)"     =>  "066|iso-8859-16",
        "Sorbian (Upper and Lower) (iso-8859-2 Latin-2)"              =>  "067|iso-8859-2" ,
        "Spanish (iso-8859-1 Latin-1)"                                =>  "068|iso-8859-1" ,
        "Spanish (iso-8859-15 Latin-9 Latin-0)"                       =>  "069|iso-8859-15",
        "Swahili (iso-8859-1 Latin-1)"                                =>  "070|iso-8859-1" ,
        "Swedish (iso-8859-1 Latin-1)"                                =>  "071|iso-8859-1" ,
        "Thai (iso-8859-11)"                                          =>  "072|iso-8859-11",
        "Turkish (iso-8859-3 Latin-3 South European)"                 =>  "073|iso-8859-3" ,
        "Turkish (iso-8859-9 Latin-5 Turkish)"                        =>  "074|iso-8859-9" ,
        "Ukrainian (iso-8859-5 Cyrillic)"                             =>  "075|iso-8859-5" ,
        "Welsh (iso-8859-14 Latin-8 Celtic)"                          =>  "076|iso-8859-14",
        "(iso-8859-12)"                                               =>  "077|iso-8859-12",
        ),
    "Windows" => array (
        "Latin I (windows-1252)"                     =>  "078|windows-1252",
        "Albanian (windows-1250 Central Europe)"     =>  "079|windows-1250",
        "Arabic (windows-1256)"                      =>  "080|windows-1256",
        "Bulgarian (windows-1251 Cyrillic)"          =>  "081|windows-1251",
        "Croatian (windows-1250 Central Europe)"     =>  "082|windows-1250",
        "Czech (windows-1250 Central Europe)"        =>  "083|windows-1250",
        "Estonian (windows-1257 Baltic)"             =>  "084|windows-1257",
        "Greek (windows-1253)"                       =>  "085|windows-1253",
        "Hebrew (windows-1255)"                      =>  "086|windows-1255",
        "Hungarian (windows-1250 Central Europe)"    =>  "087|windows-1250",
        "Latvian (windows-1257 Baltic)"              =>  "088|windows-1257",
        "Lithuanian (windows-1257 Baltic)"           =>  "089|windows-1257",
        "Polish (windows-1250 Central Europe)"       =>  "090|windows-1250",
        "Romanian (windows-1250 Central Europe)"     =>  "091|windows-1250",
        "Russian (windows-1251 Cyrillic)"            =>  "092|windows-1251",
        "Serbian (windows-1251 Cyrillic)"            =>  "093|windows-1251",
        "Slovak (windows-1250 Central Europe)"       =>  "094|windows-1250",
        "Slovene (windows-1250 Central Europe)"      =>  "095|windows-1250",
        "Thai (cp874)"                               =>  "096|cp874"       ,
        "Turkish (windows-1254)"                     =>  "097|windows-1254",
        "Ukrainian (windows-1251 Cyrillic)"          =>  "098|windows-1251",
        "Vietnamese (windows-1258)"                  =>  "099|windows-1258",
        ),
    "DOS" => array (
        "Latin US (cp437)"     =>  "100|cp437",
        "Greek (cp737)"        =>  "101|cp737",
        "BaltRim (cp775)"      =>  "102|cp775",
        "Latin1 (cp850)"       =>  "103|cp850",
        "Latin2 (cp852)"       =>  "104|cp852",
        "Cyryllic (cp855)"     =>  "105|cp855",
        "Turkish (cp857)"      =>  "106|cp857",
        "Portuguese (cp860)"   =>  "107|cp860",
        "Iceland (cp861)"      =>  "108|cp861",
        "Hebrew (cp862)"       =>  "109|cp862",
        "Canada (cp863)"       =>  "110|cp863",
        "Arabic (cp864)"       =>  "111|cp864",
        "Nordic (cp865)"       =>  "112|cp865",
        "Cyryllic (cp866)"     =>  "113|cp866",
        "Greek2 (cp869)"       =>  "114|cp869",
        ),
    "MAC" => array(
        "x-mac-cyrillic"  => "115|x-mac-cyrillic",
        "x-mac-greek"     => "116|x-mac-greek",
        "x-mac-icelandic" => "117|x-mac-icelandic",
        "x-mac-ce"        => "118|x-mac-ce",
        "x-mac-roman"     => "119|x-mac-roman",
        ),
    "..." => array(
        "cp037"                       => "120|cp037",
        "cp424"                       => "121|cp424",
        "cp500 "                      => "122|cp500",
        "cp856"                       => "123|cp856",
        "cp875"                       => "124|cp875",
        "cp1006"                      => "125|cp1006",
        "cp1026"                      => "126|cp1026",
        "koi8-r (Cyrillic)"           => "127|koi8-r",
        "koi8-u (Cyrillic Ukrainian)" => "128|koi8-u",
        ),
    );
        

    /**
    * Adres serwisowy dot. komunikatów systemowych.
    */   
    var $service_email="service_soteshop@sote.pl";
    
    /**
    * Konfiguracja maksymalnych d³ugo¶ci list produktów polecanych
    */
    var $ranking1_max_length=5;
    var $ranking2_max_length=5;
    
    var $ranking1_enabled='1';
    var $ranking2_enabled='1';
    
    var $depository = array(
        'show_unavailable' => "1",
        'general_min_num' => "5",
        'update_num_on_action' => 'on_paid',
        'return_on_cancel' => "1",
        'available_type_to_hide'=>"3",
        'display_availability'=>"1",
    );
    
    var $basket_wishlist = array(
        'prod_ext_info' => "0",
    );

/*

 "euc" => "Japanese (ja-euc)",
 "sjis" => "Japanese (ja-sjis)",
 "ks_c_5601-1987" => "Korean (ko-ks_c_5601-1987)",
 "dos-866" => "Russian (ru-dos-866)",
 "koi8-r" => "Russian (ru-koi8-r)",
 "tis-620" => "Thai (th-tis-620)",
    );
*/  
    /**
    * Okresl katalog "tematu"
    *
    * @return string katalog np. /home/www/webapps/htdocs/themes/_pl/standard
    */
    function theme_dir(){
        global $_SERVER;
        $this->theme_dir=$_SERVER['DOCUMENT_ROOT']."/themes/_".$this->lang."/".$this->theme;
        return $this->theme_dir;
    } // end theme_dir()

} // end class Config

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
    $config =& new Config;
}

if (!in_array("multi_lang",$config->plugins)) {
    $config->lang="pl";
    $config->languages=array("pl");
    $config->languages_names=array("pl"=>"Polski");
}

$config->theme_dir();

/**
* Ustaw odpowiedni jezyk dla panelu
*/
if ($shop->admin) {    
    $config->lang=$config->admin_lang;
}


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

// start cd:
if ((in_array("cd",$config->plugins)) && (@$config->cd_setup['cd']==1) && ($_SERVER['REMOTE_ADDR']==@$config->cd_setup['IP']) && ($shop->admin==0))  {
    $config->cd=1;
    $config->lang_active=array();         // dezaktywuj linki do roznych wersji jezykowych
    $config->category['type']="standard"; // wlacz statyczne kategorie
    // sprawdz jakie ceny maj± byæ wy¶wietlane
    if ($config->cd_setup['price']=="netto") {
        $config->price_type="netto";
    }
} else $config->cd=0;
// end cd:

if (!in_array("extbasket",$config->plugins)) {
    $config->basket_photo=0;
}

// nowy obiektowy koszyk

 $config->new_basket=true;

// nie wstawiaæ zakoñczenia PHP

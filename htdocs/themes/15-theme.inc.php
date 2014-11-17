<?php
/**
* Elementy zwiazane z wygladem sklepu tzw. "tematem". Modyfikacja
* elementow zwiazanych z ta klasa, pozwalaja na zmiena grafiki w
* sklepie. Klasa ta powiazana jest bezposredno z klasa Lang.
*
* @author m@sote.pl lech@sote.pl
* @$Id: theme.inc.php,v 2.146 2006/03/10 16:20:45 lukasz Exp $
* @version    $Id: theme.inc.php,v 2.146 2006/03/10 16:20:45 lukasz Exp $
* @package    themes
* \@lang
* \@ask4price
*/

require_once("themes/include/buttons.inc.php");
require_once("include/image.inc");

class Theme {

    var $dir;                            // katalog tematu
    var $bg_bar_color="#6699cc";         // kolor tla paskow typu bar
    var $bg_form_color="#ffffff";        // kolr tla formularzy zamowienia
    var $bg_basket_top_color="#abcdef";  // kolor tla w formularzu koszyka - naglowek
    var $bg_basket_row_color="#fedcba";  // kolor tla w formularzu ksozyka - wiersze
    var $bg_bar_color_light="#d5e6ed";
    var $before_main_obj="";             // obiekt zawierajacy funkcje wywolywana przed dbedit
    var $before_main_func="";            // nazwa funkcji jw.
    var $form=array();                   // tablica z danymi z formularza(y)
    var $form_error=false;               // oznacznie poprawnosci wypelnienia formularza
    var $onclick="onclick=\"window.open('','window','width=760,height=580,scrollbars=0,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
    var $record_row_fun="record_row";    // domyslna funkcja prezentacji rekordu
    var $img_border=0;                   // obramowanie wokol zdjec produktow
    var $dbedit_bar_size="100%";         // domyslna szerokosc paska bar nad listami produktow
    var $producer_filter_name;           // nazwa producenta (filtru kategorii)
    var $max_producer_chars=20;          // maksymalna liczba znakow wyswietlanej na liscie nazwy producenta
    var $record_odd_color="#ffffff";           // kolor komorki nieparzystej w liscie skroconej (domyslna "#ffffff")
    var $record_even_color="#ffffff";          // kolor komorki parzystej w liscie skroconej (domyslna "#ffffff")

    /**
    * Wy¶wietl buttony w menu g³ównym wg konfiguracji z tenmatow TEMAT/config/config.inc.php
    *
    * @author m@sote.pl lech@sote.pl
    * @return none
    */
    function autoButtons() {
        global $config, $prefix;

        reset($config->theme_config['head']['main_menu']['buttons']);
        print "<table>\n";
        print "<tr>\n";
        foreach ($config->theme_config['head']['main_menu']['buttons'] as $name=>$tab) {
            $img_over=$prefix . $tab['over'];
            $img_out=$prefix . $tab['out'];
            $url=$tab['url'];
            $desc=@$tab['desc'];
            print "<td>";
            print "<a href=\"$url\"><img src='";
            $this->img($img_out);
            print "' alt='$desc' border=\"0\" onmouseover='this.src=\"";
            $this->img($img_over);
            print "\"' onmouseout='this.src=\"";
            $this->img($img_out);
            print "\"'></a>";
        }
        print "</tr>";
        print "</table>\n";
        return;
    } // end autoButtons()

    /**
    * Otworz obszar ramki
    *
    * @author       rdiak@sote.pl
    * \@modified_by  m@sote.pl
    *               20030317 zmiana kolejnosci atrybutow, atrybuty domyslne zostaly przeniesione na koniec wywolania,
    *                        dzieki czemu mozna wywolac prosciej funkcje np.
    *                        wystarczy wywolac $theme->frame_open("nazwa")
    *
    * @param string $width szerokosc elementu frame (ramki)
    * @param string $align wyrownanie
    */
    function frame_open($title="frame",$width="100%",$align="center") {
        $file="frame_open.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end frame_open()

    /**
    * Zamknij obszar ramki
    *
    * \@depend $this->frame_open()
    */
    function frame_close() {
        $file="frame_close.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end frame_close()


    /**
    * Wyswietl formularz newslettera
    */
    function newsletter() {
        global $DOCUMENT_ROOT, $image;
        $file="newsletter.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end foot()


    /**
    * Funckja dodaje link "Drukuj" pozwalajacy wydrukowac bierzaca strone.
    *
    * @desc do poprawnego dzialania potrzebny jest JavaScript printPage.js
    * @author rp@sote.pl
    *
    * @param string $format sposob generoania linku (submit - formularz | * - <a href>Drukuj<a>
    *
    * @return void
    */
    function printPage($format="submit"){
        global $lang;
        if($format=="submit"){
            print "<form action=\"\">\n";
            print "    <input type=\"button\" value=\"".$lang->printPage["button"]."\" onClick=\"javascript:printPage('".$lang->printPage["info"]."');\">\n";
            print "</form>";
        } else {
            print "<a href=\"javascript:printPage('".$lang->printPage["info"]."');\">".$lang->printPage["button"]."</a>";
        }
        return;
    }

    /**
    * Funckja sprawdza czy istnieje tablica z bitmapami dla aktualnego tematu.
    * Jesli istnieje przeszukuje w celu odszukania lokalizacji bitmapy na dysku
    * oraz wyswietla pelna sciezke
    *
    * @param string $file_name  nazwa bitmapy jesli jest z rozszerzeniem
    *                           to nastepna funkcja z obiektu Image pomija sprawdzanie
    *                           tablicy z bitmapami w celu zmnieszenia czasu wykonania zadania
    * @param string $location   polozenie bitmapy w temacie lub katalogu, jesli nie ma wskazania
    *                           lokalicacje przybierana jest domyslna wartosc default
    *                           i wtedy sciezka przeszukiwania zaczyna sie od _bmp/default/...
    * @param string $theme_name nazwa szablonu strony z ktorego bitmapa ma byc pobrana
    *
    * @return none
    */
    function bmp($file_name="",$location="",$theme_name=""){
        return $this->img($file_name);
    } // end bmp()

    /**
    * Funkcja zwracajaca odpowiedni kod Javascript do otwierania nowego okna w zaleznosci od podanych parametrow
    *
    * @author piotrek@sote.pl
    *
    * @param  $width  szerokosc okna
    * @param  $height wysokosc okna
    *
    * @access public
    *
    * @return string $click
    */
    function onclick($width,$height) {
        $click="onclick=\"window.open('','window','width=$width,height=$height,scrollbars=0,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
        return $click;
    }

    /**
    * Wyswietl naglowek programu
    *
    * \@global float $global_basket_amount kwota zakupow
    * \@global int   $global_backet_count  ilosc produktow w koszyku
    * \@global array $_SESSION
    */
    function head() {
        global $_SESSION;
        global $global_basket_amount,$global_basket_count;
        global $config,$lang;
        global $global_wishlist_count;

        if ($config->lang!=$config->base_lang) @$config->google=@$lang->google;

        if (! empty($_SESSION['global_basket_amount'])) {
            $global_basket_amount=$_SESSION['global_basket_amount'];
        }
        if (! empty($_SESSION['global_basket_count'])) {
            $global_basket_count=$_SESSION['global_basket_count'];
        }
        if (! empty($_SESSION['global_wishlist_count'])) {
            $global_wishlist_count=$_SESSION['global_wishlist_count'];
        }

        if (empty($global_basket_amount)) $global_basket_amount=0;
        if (empty($global_basket_count)) $global_basket_count=0;
        if (empty($global_wishlist_count)) $global_wishlist_count=0;

        global $DOCUMENT_ROOT;
        $file="head.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end head()

    /**
    * Wyswietl stopke programu
    */
    function foot() {
        global $DOCUMENT_ROOT, $image;
        $file="foot.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end foot()

    /**
    * Wyswietl naglowek programu
    *
    * \@global float $global_basket_amount kwota zakupow
    * \@global int   $global_backet_count  ilosc produktow w koszyku
    * \@global array $_SESSION
    */
    function head_simple() {
        global $DOCUMENT_ROOT;
        $file="head_simple.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end head()

    /**
    * Wyswietl prosta stopke programu
    */
    function foot_simple() {
        global $DOCUMENT_ROOT;
        $file="foot_simple.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end foot()

    /**
    * Wyswietl plik z katalogu _tematu html_files
    */
    function file($file,$lang_name='') {
        global $config;
        global $DOCUMENT_ROOT;

        if($lang_name=="") {
            $lang_name=$config->lang;
        }

        global $_SERVER;
        @include_once("$DOCUMENT_ROOT/themes/_$lang_name/_html_files/$file");

        return(0);
    }

    /**
    * Wyswietl plik z biezacego katalogu theme, jesli pliku nie ma, to wez plik z $base_theme lub z base_theme
    * @param array $vars zmienne przekazywane do funkcji
    */
    function theme_file($file,$vars=array()) {
        global $lang,$config;

        while (list($key,$val) = each($vars)) {
            $$key=$val;
        }
        global $DOCUMENT_ROOT;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end file()

    /**
    * Wyswietl sciezke (+nazwa) do obrazeka z katalogu tematu, lub z base_theme
    *
    * @param string $image nazwa pliku
    */
    function img($image) {
        global $config;
        global $DOCUMENT_ROOT;

        $base_theme=$config->base_theme;

        // sprawdz czy jest plik w zdefiniowanym temacie (katalog jezykowy)
        $inode=@fileinode($config->theme_dir."/$image");

        if ($inode>0) {
            print $config->htdocs_dir."/themes/_$config->lang/$config->theme/$image";
        } else {
            //sprawdzam czy plik jest w katlogu base tematu zdefiniowanego
            $inode2=@fileinode("$DOCUMENT_ROOT/themes/base/$config->theme/$image");
            if ($inode2>0) {
                print $config->htdocs_dir."/themes/base/$config->theme/$image";
            } else {

                // sprawdzam czy istnieje plik w $base_theme (katalog jezykowy)
                $inode3=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$image");
                if ($inode3>0) {
                    print $config->htdocs_dir."/themes/_$config->lang/$base_theme/$image";
                } else {

                    //sprawdzam czy plik istnieje w $base_theme (katalog base)
                    $inode4=@fileinode("$DOCUMENT_ROOT/themes/base/$base_theme/$image");
                    if ($inode4>0) {
                        print $config->htdocs_dir."/themes/base/$base_theme/$image";
                    } else {

                        //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog jezykowy)
                        $inode5=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$image");
                        if ($inode5>0) {
                            print $config->htdocs_dir."/themes/_$config->lang/base_theme/$image";
                        } else {

                           //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog base)
                            $inode6=@fileinode("$DOCUMENT_ROOT/themes/base/base_theme/$image");
                            if ($inode6>0) {
                                print $config->htdocs_dir."/themes/base/base_theme/$image";
                            } else {

                               //sprawdzam czy plik istnieje w glownym temacie - base_theme/_img (katalog base)
                               $inode7=@fileinode("$DOCUMENT_ROOT/themes/base/base_theme/_img/$image");
                               if ($inode7>0) {
                                  print $config->htdocs_dir."/themes/base/base_theme/_img/$image";
                               } else {
                                print $config->htdocs_dir."/themes/base/base_theme/_img/_mask.gif";
                               }
                            }
                        } //end if
                    } //end if
                } //end if
            } // end if
        }// end if
        return(0);
    } // end img()

    /**
    * Zwróæ sciezke (+nazwa) do pliku z katalogu tematu, lub z base_theme
    *
    * @param string $image nazwa pliku
    */
    function filepath($image) {
        global $config;
        global $DOCUMENT_ROOT;

        $base_theme=$config->base_theme;

        // sprawdz czy jest plik w zdefiniowanym temacie (katalog jezykowy)
        $inode=@fileinode($config->theme_dir."/$image");

        if ($inode>0) {
            return $config->htdocs_dir."/themes/_$config->lang/$config->theme/$image";
        } else {
            //sprawdzam czy plik jest w katlogu base tematu zdefiniowanego
            $inode2=@fileinode("$DOCUMENT_ROOT/themes/base/$config->theme/$image");
            if ($inode2>0) {
                return $config->htdocs_dir."/themes/base/$config->theme/$image";
            } else {

                // sprawdzam czy istnieje plik w $base_theme (katalog jezykowy)
                $inode3=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$image");
                if ($inode3>0) {
                    return $config->htdocs_dir."/themes/_$config->lang/$base_theme/$image";
                } else {

                    //sprawdzam czy plik istnieje w $base_theme (katalog base)
                    $inode4=@fileinode("$DOCUMENT_ROOT/themes/base/$base_theme/$image");
                    if ($inode4>0) {
                        return $config->htdocs_dir."/themes/base/$base_theme/$image";
                    } else {

                        //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog jezykowy)
                        $inode5=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$image");
                        if ($inode5>0) {
                            return $config->htdocs_dir."/themes/_$config->lang/base_theme/$image";
                        } else {

                            //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog base)
                            $inode6=@fileinode("$DOCUMENT_ROOT/themes/base/base_theme/$image");
                            if ($inode6>0) {
                                return $config->htdocs_dir."/themes/base/base_theme/$image";
                            } else {
                                return $config->htdocs_dir."/themes/base/base_theme/_img/_mask.gif";
                            }
                        } //end if
                    } //end if
                } //end if
            } // end if
        }// end if
    } // end filepath()

    /**
    * Wy¶wietl pelna sciezke do pliku lub domyslna bitmape systemowa
    * Funkcja ma m.in. na celu wyeliminowanie pojawiania sie okienek z bledami, je¶li nie ma zdjêcia
    *
    * @author rp@sote.pl m@sote.pl
    * @param string $file_name nazwa pliku
    *
    * @deprecated since 3.0 alfa
    * @return none
    */
    function path($file_name="_img/_mask.gif"){
        return $this->img($file_name);
    } // end path()

    /**
    * Przejdz na glowna strone. Strona wywolywana w przypadku, kiedy klient dokonal
    * jakiejs nieprawidlowej operacji (np. bledne wywolania back,forward) i trzeba go
    * odeslac na glowna strone, bo za bardzo zamieszal;)
    */
    function go2main($rtime=0) {
//    	print "<pre>";
//    	print_r (debug_backtrace());
//    	print "</pre>";
        $this->refresh_time=$rtime;
        $this->theme_file("go2main.html.php");
    } // end go2main()

    /**
    * Tekst (HTML) na glownej stronie
    */
    function main_html(){
        $this->theme_file("main.html.php");
        return(0);
    } // end main_html()

    /**
    * Formatowanie formatu pienieznego
    *
    * @author  m@sote.pl
    * @param  string|real $price np. 2000.3423
    * @return $price w odpowiednim formacie np. 2000.34 (wartosc numeryczna!)
    */
    function price($price) {
        return number_format($price,2,".","");
    } // end price()

    /**
    * Funkcja wyswietla glowna czesc strony (poza naglowkiem i stopka).
    * Sa to domyslnie: kolumna lewa, srodek i prawa. Oczywiscie uklad ten moze zostac zmieniony.
    *
    * @param string $left  funkcja okreslajaca lewa kolumne
    * @param string $main  funkcja okreslajaca srodkowa kolumne
    * @param string $right funkcja okreslajaca prawa kolumne
    * @param class  $cl_left  klasa zawierajaca funkcje $left (jesli jest inna niz $this)
    * @param class  $cl_main  klasa zawierajaca funkcje $main jw.
    * @param class  $cl_right klasa zawierajaca funkcje $right jw.
    * @param string $page_file plik zawierajacy glowny podzial strony np. na 3 kolumny
    */
    function page_open($left="left",$main="main",$right="right",$cl_left="",$cl_main="",$cl_right="",$page_file="page_open") {
        global $config;

        if (empty($cl_left))  $o_left=$this;  else $o_left = new $cl_left;
        if (empty($cl_main))  $o_main=$this;  else $o_main = new $cl_main;
        if (empty($cl_right)) $o_right=$this; else $o_right = new $cl_right;

        global $DOCUMENT_ROOT;
        $file=$page_file.".html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end page_open()

    /**
    * Jak page_open(), z ta roznica, ze podawany jest tu adres obiektu
    * zawierajacego element czesci tzw. "main"
    *
    * @param string $main nazwa funkcji
    * @param object &$o_main adres obiektu
    * @param string $page_file jak w page_open()
    */
    function page_open_object($main,&$o_main,$page_file) {
        $left="left";$right="right";
        $o_left=$this;
        $o_right=$this;

        global $DOCUMENT_ROOT;
        $file=$page_file.".html.php";
        //print "before:".$page_file;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        //print "after";

        return(0);
    } // end page_open_object()

    /**
    * Otworz glowna tabele strony
    *
    * @param strong $file nazwa pliku zawierajacago naglowek
    */
    function page_open_head($file) {
        $this->theme_file("$file.html.php");
    } // end page_open_head()

    /**
    * Zamknij glowna tabele strony
    *
    * @param strong $file nazwa pliku zawierajacago stopke
    */
    function page_open_foot($file) {
        $this->theme_file("$file.html.php");
    } // end page_open_foot()

    /**
    * Lewa strona
    */
    function left() {
        global $rand_prod;
        if (! is_object($rand_prod)) {
            include_once ("include/random_products.inc");
            $rand_prod =  new RandProduct;
        }

        global $DOCUMENT_ROOT;
        $file="left.html.php";$include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end left()

    /**
    * Prawa strona
    */
    function right() {
        global $rand_prod;
        if (! is_object($rand_prod)) {
            include_once ("include/random_products.inc");
            $rand_prod =  new RandProduct;
        }

        global $DOCUMENT_ROOT;
        $file="right.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end right()

    /**
    * Glowna czesc strony, srodek
    */
    function main() {
        $this->theme_file("main.html.php");
        return(0);
    } // end main()

    /**
    * Dolna czesc strony, ladowana po produktach na stronie glownej
    * uzyta w htdocs/index.php
    *
    * @access public
    *
    * @retyrn void
    */
    function mainBottom() {

        $this->theme_file("main_bottom.html.php");

        return;
    } // end mainBottom()


    /**
    * @desc wyswietla rekordy plugin'u NewsEdit
    *
    * @author rp@sote.pl
    * @return void
    */
    function mainNews() {
        global $lang;
        global $_REQUEST;
        global $mdbd;

        $news_title=$lang->main_news;
        if (@ereg("^[0-9]+$",$_REQUEST['group'])) {
            $group=$_REQUEST['group'];
            if ($group>0) {
                $title=$mdbd->select("name","newsedit_groups","id=?",array($group=>"int"),"LIMIT 1");
                if ($title!="0") $news_title=$title;
                else {
                    $this->go2main();
                    exit;
                }
            }
        }

        $this->win_top($news_title,380,1,1);
        @include_once ("plugins/_newsedit/include/newsedit.inc.php");
        if (is_object(@$newsedit)) {
            $newsedit->show_list();
        }
        $this->win_bottom(380);

        return;
    } // end mainNews()

    /**
    * Tytul
    */
    function title($title) {
        print "<table border=1><tr><td>$title</td></tr></table>";
        return(0);
    } // end title()

    /**
    * Pasek z napisem "bar"
    */
    function bar($text,$width="100%") {
        global $DOCUMENT_ROOT;
        $file="bar.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end bar()

    /**
    * Przycisk z napisem
    */
    function button($text,$url="/",$width=100) {
        global $config;
        $url=@$config->url_prefix.$url;
        print "<form action='$url'><input type=button value='$text' onClick=\"this.form.submit();\"></form>\n";
        return(0);
    } // end bar()

    /**
    * Przycisk podsumuj w koszyku
    */
    function calc_button() {
        global $lang;

        $order_update=$lang->basket_order_update;

        print "<input type=submit name=submit_update value='$order_update'>";
        return(0);
    } // end calc_button()


    /**
    * Aktualna data
    */
    function date() {
        global $lang;
        print "$lang->date:".(date("d-m-Y"));
        return(0);
    } // end date()

    /**
    * Elementy pojawiajace sie nad lista produktow. Np. wybor listy skroconej rozszezonej itp.
    */
    function top_dbedit() {
        require_once("include/record_row_links.inc");

        global $DOCUMENT_ROOT;
        $file="list/list_top.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end top_dbedit()

    /**
    * Wyglad wiersza w prezentacji rekordu w liscie
    */
    function record_row(&$rec) {
        global $image;
        global $description;
        global $config;

        // dodaj obsluge automatycznego generowania skrotu opisu
        if (! is_object($description)) {
            include_once ("include/description.inc");
        }

        global $DOCUMENT_ROOT;
        $file="record_row.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end record_row()

    /**
    * Wyglad wiersza prezentacji rekordu
    */
    function record_row_short(&$rec) {
        global $config;
        global $DOCUMENT_ROOT;

        // wartosc ktora pozwoli naprzemiennei wyswietlac komorki jako parzyste i nieparzyste
        static $odd=0;
        $file="record_row_short.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        if($odd==0){
            $odd=1;
        } else {
            $odd=0;
        }
        return(0);
    } // end record_row_short()
    
       /**
    * Wyglad wiersza w prezentacji rekordu w liscie
    */
    function record_row_search(&$rec) {
        global $image;
        global $description;
        global $config;

        // dodaj obsluge automatycznego generowania skrotu opisu
        if (! is_object($description)) {
            include_once ("include/description.inc");
        }

        global $DOCUMENT_ROOT;
        $file="record_row_search.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end record_row()
        
    /**
    * Sprawd¼ ustawienia parametrów produktu i w zale¿no¶ci od opcji wy¶iwetl cenê, info, koszyk itp.
    * Funkcja jest wykorzystywana w info record_row itp. do obslugi pól m.in. hidden_price, ask4price, discount
    * Przyk³ad wtwo³ania np. je¶li chcemy wy¶wietliæ cenê wywo³ujemy funkcjê:<br>
    * $theme->recPrice($price);<br>
    * W funckje recPrice() jest wywo³ane sparawdzanie odpowiednich parametrów i poprzez wywo³anie:<br>
    * $this->_checkView($rec,"price") itp.
    *
    * @author  m@sote.pl
    *
    * @param string $type typ zapytania: basket,info,discount,price
    * @param object &$rec adres obiektu z danymi produktu $rec->data
    *
    * @access private
    * @return bool true mo¿na pokazaæ dan± opcjê, false w p.w.
    */
    function checkView($type,&$rec) {
        global $config;

        // jesli sklep jest w trybie CD, to nie pokazuj koszyka
        if (($config->cd==1) && ($type=="basket"))   return false;

        switch ($type) {
            case "info": return true;
            break;
            case "ask4price": if ($rec->data['ask4price']==1) return true;
            break;
            case "points": if ($rec->data['points']==1) return true;
            break;
            default:
            // basket, discout, price
            if ((@$rec->data['hidden_price']==0) && (@$rec->data['ask4price']==0)) return true;
            break;
        }
        return false;
    } // end checkView()

    /**
    * Wy¶wietl informacje o cenie (netto, brutto, netto/brutto ).
    *
    * @author rdiak@sote.pl
    * @param  int $id id produktu (z tabeli main)
    * @access private
    * @return string rodzaj ceny
    */
    function info_price() {
        global $config;
        global $lang;

        if($config->price_type == 'netto') {
            return $lang->cols['price_netto'];
        } elseif($config->price_type == 'netto/brutto') {
            return $lang->cols['price_nettobrutto'];
        } else {
            return $lang->cols['price_brutto'];
        }
    }

    function info_points() {
    	global $lang;
    	return $lang->cols['points'];
    }
    
    /**
    * Wy¶wietl cene (netto, brutto).
    *
    * @author rdiak@sote.pl
    * @param  int $id id produktu (z tabeli main)
    * @access private
    * @return string rodzaj ceny
    */
    function print_price(&$rec) {
        global $config;

        if ($config->price_type == 'netto') {
            return $this->price($rec->data['price_netto']);
        } elseif($config->price_type == 'netto/brutto') {
            return $this->price($rec->data['price_netto'])."/".$this->price($rec->data['price_brutto']);
        } else {
            return $this->price($rec->data['price_brutto']);
        }
    } // end print_price

    /**
    * Wy¶wietl ikonkê info odsy³aj±c± do informacji szczegó³owych o produkcie.
    * Od wersji 3.0 funckja ta zmienia swoje znaczenie. Patrz recInfo().
    *
    * @author m@sote.pl
    * @param  int $id id produktu (z tabeli main)
    * @access private
    * @return none
    * @todo   opisaæ lub jawnie zdefiniowaæ zmienn± $prefix (m@sote.pl->lech@sote.pl)
    */
    function _info($id) {
        global $config, $prefix, $lang;
        print "<a href=/go/_info/?id=".$id." alt=\"".$lang->tooltip['info']."\">";
        print "<img title=\"".$lang->tooltip['info']."\" src='";$this->img($prefix . $config->theme_config['icons']['info']);print "' border=0>";
        print "</a>";
        return;
    } // end _info()

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ ikonkê info i je¶li tak, to wy¶wietl j±
    * Funckja ta zastêpuje wcze¶niejsze wywo³ania postaci $theme->info().
    *
    * @author m@sote.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recInfo($id,&$rec) {
        if ($this->checkView("info",$rec)) {
            return $this->_info($id);
        } else return;
    } // end recInfo()

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ opis ikonki info i je¶li tak, to wy¶wietl go
    *
    * @author tomasz@mikran.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recInfoDescription($id,&$rec) {
       global $lang;
        if ($this->checkView("info",$rec) == true) 
        {
           print "<a href=/go/_info/?id=".$id.">";
           print $lang->icons_description['description'];
           print "</a>";
        } 
        return;
    } // end recInfoDescription()

    /**
    * Wyswietl link do koszyka
    */
    function basketLink() {
        global $DOCUMENT_ROOT, $image;
        $file="basketlink.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end foot()


    /**
    * Wy¶wietl formularz zamówienia wraz z opcjami.
    * Funkcja generuje pe³en formularz <form> ... </form> + przycisk submit->zamów
    *
    * @param int    $id id  produktu
    * @param string $xml_options opcje
    */
    function _basketOptions($id,$xml_options) {
        // atrybuty
        if (! empty($xml_options)) {
            // dodaj obsluge pola xml_options
            global $result,$my_xml_options;
            include_once ("include/xml_options.inc");
            $my_xml_options->show($result);
        } else {
            $this->_basket();
        }
    } // end _basketOptions()

    /**
    * Wy¶wietl formularz dodania produktu do koszyka.
    * Je¶li nie przekazujemy do funkcji ¿adnych opcji (np. L, XL itp), to zostanie wy¶wietlony
    * standardowy koszyk. Je¶li dla danego produktu s± zdefiniowane jakie¶ opcje, poka¿e siê formularz
    * wybrania opcji + przycisk submit->zamów.
    *
    * @param  int    $id           identyfikator produktu (id z tabeli main)
    * @param  string $xml_options  opcje   
    * @access private
    * @return none
    */
    function _basket($id,$xml_options) {
        if (! empty($xml_options)) 
        {
           return $this->_basketOptions($id,$xml_options);
        }
        $this->_basketSimple($id);
        return;
    } // end _basket()

    /**
    * Wy¶wietl ikonkê (formularz) koszyka.
    * Funkcja powoduje wy¶wietlenie zwyk³ego koszyka. Ró¿ni sie od basket() tym, ¿e nie powoduje
    * wy¶wietlania formularza z opcjami.
    *
    * @param  int    $id identyfikator produktu (id z tabeli main)
    * @access private
    * @return none
    */
    function _basketSimple($id) {
        global $config;
        global $lang;
        if (@$config->catalog_mode==1){
            return;
        }
        global $config, $prefix;
        print "<form action=\"/go/_basket/index.php\">\n";
        print "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
        print "<input class=border0 type=\"image\" src=\"";
        $this->img( $prefix . $config->theme_config['icons']['basket']);
        print "\" title=\"".$lang->tooltip['basket']."\">";
        print "</form>\n";
	
        return;
    } // end _basketSimple()

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ ikonkê koszyk i je¶li tak, to wy¶wietl j±.
    * Funckja ta zastêpuje wcze¶niejsze wywo³ania postaci $theme->basket().
    *
    * @author m@sote.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recBasket($id,&$rec) {
        if ($this->checkView("basket",$rec)) 
        {
           //           print "XML Options:";
           //print @$rec->data['xml_options'];
           return $this->_basket($id,@$rec->data['xml_options']);
        } 
        elseif ($this->checkView("ask4price",$rec)) 
        {
           $this->ask4price($rec);
        } 
        elseif (ereg("^music",@$rec->data['xml_options'])) 
        {
            // nawet je¶li jest za³±czona opcja "nie pokazuj ceny", ale
            // produkt zawiera utwory do zakupu, to poka¿ listê atrybutów
            return $this->_basket($id,@$rec->data['xml_options']);
        }
        return;
    } // end recInfo()
    // end Basket:

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ opis ikonki koszyk i je¶li tak, to wy¶wietl j±.
    *
    * @author tomasz@mikran.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recBasketDescription($id,&$rec) 
    {
        global $lang;
        if ($this->checkView("basket",$rec) == true) 
        {
           print "<form action=\"/go/_basket/index.php\" method=\"POST\" name=\"add2basketItem_".$id."\">";
           print "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
           print "<a onclick=\"document.forms['add2basketItem_".$id."'].submit(); \" style='cursor: pointer;'>";
           print $lang->icons_description['basket'];
           print "</a>";
           print "</form>\n";
        }
       return;
    } // end recBasketDescription()
	
    /**
    *Wy¶wietl drukuj i poka¿ strone prezentacji produktu do wydruku
    *
    * @author krzys@sote.pl
    */
         function print_page($url) {
        global $config, $prefix;
        print "<a href=$url onclick=\"window.open('', 'window_popup', 'width=590, height=450, rezisable=1, scrollbars=1, toolbar=0, status=0');\" target='window_popup'>";
        global $lang;
        print "<img src=\"";
        $this->img("_img/_icons/druk.gif");
        print "\" style='border-width: 0px;'>";
        print "</a>";
        return;
    } // end _print()
    
    

    /**
    * Przyciski podsumuj wprowadzone zmiany, dalej, wartosc zamowienia
    *
    * @param float  $amount        wartosc zakupow (bez kosztow dostawy)
    * @param float  $order_amount  kwota do zaplaty
    * @param string $delivery_name nazwa dostawcy
    * @param float  $delivery_cost koszt dostawy
    */
    function basket_submit($amount,$order_amount,$delivery_name,$delivery_cost) {
        global $config;

        global $DOCUMENT_ROOT;
        $file="basket_delivery_submit.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end basket_submit()

    /**
    * Przyciski podsumuj wprowadzone zmiany, dalej, wartosc zamowienia - w przypadku zamówienia produktów za punkty
    *
    * @param float  $amount        wartosc zakupow (bez kosztow dostawy)
    * @param float  $order_amount  kwota do zaplaty
    * @param string $delivery_name nazwa dostawcy
    * @param float  $delivery_cost koszt dostawy
    */
    function basket_points_submit($amount,$order_amount,$delivery_name,$delivery_cost) {
        global $config;

        global $DOCUMENT_ROOT;
        $file="basket_delivery_points_submit.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end basket_submit()


    /**
    *
    * Wyswietl podsumowanie kosztow dot. zakupow
    *
    * @param float  $amount        wartosc zakupow (bez kosztow dostawy)
    * @param float  $order_amount  kwota do zaplaty
    * @param string $delivery_name nazwa dostawcy
    * @param float  $delivery_cost koszt dostawy
    */
    function basket_points_amount($amount,$order_amount,$delivery_name,$delivery_cost) {
        global $config;
        global $DOCUMENT_ROOT;

        $file="basket_points_amount.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end basket_amount()
        
    /**
    *
    * Wyswietl podsumowanie kosztow dot. zakupow
    *
    * @param float  $amount        wartosc zakupow (bez kosztow dostawy)
    * @param float  $order_amount  kwota do zaplaty
    * @param string $delivery_name nazwa dostawcy
    * @param float  $delivery_cost koszt dostawy
    */
    function basket_amount($amount,$order_amount,$delivery_name,$delivery_cost) {
        global $config;
        global $DOCUMENT_ROOT;

        $file="basket_amount.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end basket_amount()

    /**
    * Koszyk jest pusty
    */
    function basket_empty() {
        global $lang;

        $this->bar($lang->basket_title);
        print "<p><center>$lang->basket_empty</center>";
        return(0);
    } // end basket_empty()

    /**
    * Przycisk powrotu do poprzedniej strony
    */
    function back() {
        global $lang;
        global $buttons;

        print "<form><input type=button value='$lang->back' onClick=\"history.back();\"></form>";
    } // end back()

    /**
    * Przycisk powrotu do glownej strony
    */
    function back2main() {
        global $lang;
        print "<form action=/><input type=submit value='$lang->back'></form>";
    } // end back()


    /**
    * Formularz rejestracji - billing
    *
    * @param array  $form       dane z formularza
    * @param object $form_check obiekt klasy FormCheck - sprawdzanie formularza
    */
    function register_billing_form(&$form,&$form_check){
        global $lang;
        $this->form=&$form;
        $this->form_check=&$form_check;
        global $DOCUMENT_ROOT;

        if (! empty($_SESSION['global_login'])) {
            include_once("$DOCUMENT_ROOT/go/_users/include/menu.inc.php");
        }

        $this->bar($lang->bar_title['register_billing']);

        $file="register_billing.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end register_billing_form()

    /**
    * Formularz rejestracji - billing w panelu zalogowanego uzytkownika
    *
    * @param array  $form       dane z formularza
    * @param object $form_check obiekt klasy FormCheck - sprawdzanie formularza
    */
    function register_billing_form_users(&$form,&$form_check){
        global $lang;
        $this->form=&$form;
        $this->form_check=&$form_check;
        global $DOCUMENT_ROOT;

        if (! empty($_SESSION['global_login'])) {
            include_once("$DOCUMENT_ROOT/go/_users/include/menu.inc.php");
        }

        $this->bar(@$lang->bar_title['register_billing']);

        $file="register_billing_users.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end register_billing_form()

    /**
    * Formularz rejestracji - adres korespondencyjny
    *
    * @param array $form        dane z formularza
    * @param object $form_check obiekt klas FormCheck
    */
    function register_cor_form(&$form,&$form_check){
        global $lang;
        global $DOCUMENT_ROOT;
        $this->form=&$form;
        $this->form_check=&$form_check;

        if (! empty($_SESSION['global_login'])) {
            include_once("$DOCUMENT_ROOT/go/_users/include/menu.inc.php");
        }

        $this->bar($lang->bar_title['register_cor']);

        $file="register_cor.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end register_cor_form()

    /**
    * Podsumowanie wprowadzonych danych
    *
    * @param array $form dane z formularza - dane bilingowe
    * @param object $form_cor dane z formularza - adres korespondencyjny
    */
    function register_confirm(&$form,&$form_cor) {
        global $lang;
        global $DOCUMENT_ROOT;
        $this->form=&$form;
        $this->form_cor=&$form_cor;

        if (! empty($_SESSION['global_login'])) {
            include_once("$DOCUMENT_ROOT/go/_users/include/menu.inc.php");
        }

        $this->bar($lang->bar_title['register_confirm']);

        $file="register_confirm.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

    } // end register_confirm()

    /**
    * Formularz rejestracji uzytkownikow, logowanie - nowy user
    *
    * @param array $form dane z formularza
    * @param object $form_check obiekt klas FormCheck
    */
    function users_form(&$form,&$form_check,$file="users.html.php"){
        global $lang;
        $this->form=&$form;
        $this->form_check=&$form_check;

        //if (empty($_SESSION['global_id_user'])) {
        $this->bar(@$lang->bar_title['users']);
        //}

        global $DOCUMENT_ROOT;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end users_form()

    /**
    * Wybor sposobu platnosci
    */
    function register_pay_method(){
        $this->theme_file("register_pay_method.html.php");
        return(0);
    } // end register_pay_method()

    /**
    * Wartosc elementu formularza value=$this->form_val('nazwa_pola')
    *
    * @param string $name nazwa pola formularza
    */
    function form_val($name) {
        $form=&$this->form;
        if (! empty($form[$name])) {
            print $form[$name];
        }
        return(0);
    } // end form_val()

    /**
    * Blednie wypelnione pole formularza
    *
    * @param string $name nazwa pola formularza
    * @return wyswietla komunikat o bledzie, jesli takowy zostal wykrypty przez $this->form_check->test()
    */
    function form_error($name) {
        if (! @empty($this->form_check->errors_found[$name])) {
            print "<font color=red>";
            print $this->form_check->errors_found[$name];
            print "</font>\n";
        }
        return(0);
    } // end form_error()

    /**
    * Formularz wyszukiwania
    *
    * @param string $view rodzaj prezentacji fromularza wyszukiwania "vertical" - pionowo, "horizontal" - poziomo
    */
    function search_form($view="vertical"){
        global $lang;
        global $config;

        // start plugin cd:
        if ($config->cd==1) return;
        // end plugin cd:ss

        if ($view=="vertical") $br="<BR>";
        else $br="";

        print "<div align=\"left\">\n";
        print "  <form action=\"$config->url_prefix/go/_search/full_search.php\" method=\"get\" name=\"SearchForm\">\n";
        print "    <input type=\"text\" name=\"search_query_words\" size=\"15\">\n";
        print "    <input type=\"submit\" value=\"$lang->search\">$br\n";
        /*
        print "    <input type=\"checkbox\" name=\"search_category\"    value=\"1\">$lang->search_category $br";
        print "    <input type=\"checkbox\" name=\"search_description\" value=\"1\">$lang->search_description";
        print "    <select name=\"search_category\">";
        print "      <option name=\"product\">".$lang->search_category['products']."</option>\n";
        print "      <option name=\"product_desc\">".$lang->search_category['products_desc']."</option>\n";
        print "      <option name=\"all\">".$lang->search_category['all']."</option>\n";
        print "    </select>";
        */
        print "  </form>\n";
        print "<a href='/go/_search/advanced_search.php'>".@$lang->search_advanced."</a>";   
        print "</div>\n";
    } // end search_form()

    /**
    * Informacja o tym ,z e zamowienie zostalo wyslane
    */
    function send_confirm() {
        $this->theme_file("send_confirm.html.php");
        return(0);
    } // end send_confirm()

    /**
    * Nie udalo sie wysalc zamowienia do sklepu
    */
    function send_error() {
        $this->theme_file("send_error.html.php");
        return(0);
    } // end send_error()

    /**
    * Bledy ciag wyszukiwania
    */
    function search_empty() {
        global $lang;
        $this->bar($lang->search_empty_title);
        print "<center>".$lang->search_empty_query."</center>";
    } // end search_empty()

    /**
    * Okno prezentacji rekordu (losowanie)
    */
    function random_row(&$rec) {
        global $image,$config;

        global $DOCUMENT_ROOT;
        $file="random_record.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end random_row()

    /**
    * Uzytkwonik zostal zarejestrowny
    */
    function users_registered() {
        $this->theme_file("users_registered.html.php");
        return(0);
    } // end users_registered()

    /**
    * Uzytkwonik zostal zarejestrowny, realizuj zamowienie (koszyk nie jest pusty)
    */
    function users_go2register() {
        $this->theme_file("users_go2register.html.php");
        return(0);
    } // end users_registered()

    /**
    * Formularz logowania uzytkownikow; wylogowanie.
    */
    function login_form(){
        require_once("include/login.inc");
        $sys_login->login_form();
        return(0);
    } // end login_form()

    /**
    * Formularz logowanie odbiorcy hurtowego; wylogowanie.
    */
    function firm_login_form() {
        require_once("include/firm_login.inc");
        $f_login->login_form();
        return(0);
    } // end firm_login_form()

    /**
    * Wyswietl liste tematow do wyboru. Je¿eli lista aktywnych (dostêpnych) tematów
    * sk³ada siê tylko z jednego tematu, to nie jest wy¶wietlona wogóle
    */
    function show_themes() {
        global $config, $lang;

        // start plugin cd:
        if ($config->cd==1) return '';
        // end plugin cd:

        if (sizeof($config->themes_active) < 2 ) return;

        reset($config->themes);

        print "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
        print "  <tr>\n";
        print "    <td>".$lang->right_choose_layout."&nbsp; </td>\n";
        print "      <form action=\"".$config->url_prefix."/go/_themes/index.php\">";
        print "    <td>\n";
        print "<select name=\"theme\" onChange=\"this.form.submit();\">\n";

        // wy¶wietlenie listy tematów dostêpnych dla u¿ytkownika sklepu (przegl±daj±cego sklep).
        // Przechodzimy po ca³ej li¶cie tematów, ale wy¶wietlanmy tylko te, które
        // znajduj± siê na li¶cie dostêpnych (aktywnych) dla klienta
        while (list($key_theme,$value_theme) = each($config->themes)) {
            $bExists = false;

            // sprawd¼ czy temat nale¿y do aktywnych tematów
            foreach($config->themes_active as $key_theme_active=>$value_theme_active) {
                if ($key_theme_active == $key_theme) {
                    // Je¿eli temat nale¿y do tematów z listy aktywnych
                    // to mo¿na go wy¶wietliæ.
                    $bExists = true;
                    break;
                }
                else {
                    // Tematu nie wy¶wietlamy poniewa¿ nie nale¿y on do listy
                    // aktywnych tematów.
                    $bExists = false;
                }
            }

            // przepu¶æ te tematy, które nale¿± do zbioru aktywnych
            if ($bExists == true)
            {
                if ($key_theme==$config->theme) $selected="selected";
                else $selected="";
                print "<option value=\"$key_theme\" $selected>$value_theme</option>\n";
                $bExists = false;
            }
        }
        print "</select>\n";
        print "</td>\n";
        print "    <td><input class=\"border0\" type=\"image\" src=\"";
        $this->bmp("next.gif","layout_buttons");
        print "\" value=\">\">";
        print "</td>\n";
        print "      </form>";
        print "  </tr>\n";
        print "</table>\n";

        return(0);
    } // end show_theme()

    // --- start Plugins ----

    // --- start InCategory --
    /**
    * Wiersz prezentacji produktu z tej samej kategorii na liscie w info
    *
    * @param object $rec obiekt z danymi produktu $rec->data
    */
    function category_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        global $DOCUMENT_ROOT;
        $file="in_category_row.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end category_row()
    // --- end InCategory ---

    // --- start Reviews ----
    /**
    * Wiersz prezentacji recenzji na liscie w info
    *
    * @param object $rec obiekt z danymi produktu $rec->data
    * @author piotrek@sote.pl
    */
    function reviews_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        global $DOCUMENT_ROOT;
        $file="plugins/_reviews/reviews_row.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end reviews_row()

    // end Reviews ---

    // --- start HiddenPrice ---
    /**
    * Wstaw link zapytaj o cene
    *
    * @param string $name nazwa produktu
    * @public
    */
    function ask4price($rec = '') {
        global $lang,$config, $_SESSION;
        if((!empty($_SESSION['ask4price_list'])) || (!empty($rec))) {
            //        if(1) {
            if(!empty($rec)) {
                $name_url=urlencode($rec->data['name']);
                $producer_url=urlencode($rec->data['producer']);
                $id_url=urlencode($rec->data['user_id']);
                print "<a href='/plugins/_ask4price/?action=add&id=$id_url&name=$name_url&producer=$producer_url' onclick=\"window.open('','window','width=400,height=300,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=1');\" target='window'>".$lang->ask4price."</a>";
            }
            else {
                print "<a href='/plugins/_ask4price/?action=show' onclick=\"window.open('','window','width=400,height=300,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=1');\" target='window'>".$lang->ask4price_list."</a>";
            }
        }
        return(0);
    } // end ask4price
    // --- end HiddenPrice ---

    //-- start UserTrans
    /**
    * Nazwy elementow nad lista transakcji
    */
    function trans_list_th() {
        global $lang, $_SESSION;
        $o="<BR><center>$lang->trans_desc</center>";
        $o.="<BR><table align=center>";
        $o.="<tr bgcolor=$this->bg_bar_color_light><th>$lang->trans_id</th><th>$lang->trans_date</th><th>$lang->trans_amount</th><th>$lang->trans_stat</th><th>$lang->trans_pay_conf</th><th>$lang->trans_payment</th>";
        if(empty($_SESSION['id_partner'])) {
            $o .= "<th>$lang->trans_ask4trans</th></tr>\n";
        }
        else {
            $o .= "\n";
        }
        return $o;
    }
    
      //-- start UserPoints
    /**
    * Nazwy elementow nad liscie historii punktow 
    */
    
    function points_list_th() {
        global $lang;
        global $lang;
        $o="<BR><center></center>";
        $o.="<BR><table align=center>";
        $o.="<tr bgcolor=$this->bg_bar_color_light><th>$lang->points_action</th><th>$lang->users_points</th><th>$lang->points_time</th><th>$lang->trans_stat</th><th>$lang->trans_id</th><th>$lang->points_id_product</th></tr>\n";
        return $o;
        
    }
    
      /**
    * Wiersz prezentacji historii punktow
    *
    * @param object $rec obiekt z danymi produktu $rec->data
    */
    function points_record_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        global $DOCUMENT_ROOT;
        $file="points_record_row.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end order_record_row()
    
    /**
    * Wiersz prezentacji transakcji
    *
    * @param object $rec obiekt z danymi produktu $rec->data
    */
    function trans_record_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        global $DOCUMENT_ROOT;
        $file="trans_record_row.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end order_record_row()

    /**
    * Edycja transakcji
    *
    * @param object $rec obiekt z danymi produktu $rec->data
    */
    function trans_product(&$rec) {
        global $lang;
        global $config;
        global $DOCUMENT_ROOT;
        $file="trans_products.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end order_edit()

    /**
    * Wstaw link, icone z opisem
    *
    * @param string $image nazwa fotki z katalogu _img/_icons (wzgledem katalogu tematu)
    * @param string $link  URL wzgledem domeny
    * @text  string $text  podpis pod ikonka
    */
    function icon($image,$link,$text) {
        print "
          <table>
          <tr>
           <td valign=top align=center><a href='$link'>";
        print "<img src='";$this->img("_img/_icons/$image");print "' border=0></a></td>
          </tr>
          <tr><td align=center valign=top>$text</td></tr>
         </table>";

        return(0);
    } // end icon()
    // -- end UserTrans

    // -- start producers_category
    /**
    * Wyswietl liste producentow, zapamietaj wybranego przez usera producenta
    *
    * \@global string $this->producer_filter_name nazwa producenta (filtru kategorii)
    */
    function producers_category() {
        global $lang;
        global $_REQUEST;
        global $__all_producers;
        global $config;
        include_once("include/lang_functions.inc");

        // start plugin cd:
        if ($config->cd==1) return '';
        // end plugins cd:

        if (empty($__all_producers)) {
            include_once("config/tmp/producer.php");
        }

        global $_SESSION;

        // odczytaj kategorie dla danego producenta
        if (ereg("^[0-9]+$",@$_REQUEST['producer_filter'])) {
            $__producer_filter=$_REQUEST['producer_filter'];
        } elseif (ereg("^[0-9]+$",@$_SESSION['__producer_filter'])) {
            $__producer_filter=$_SESSION['__producer_filter'];
        } else {
            $__producer_filter='';
        }

        if (! empty($__all_producers)) {
            print "<form action=$config->url_prefix/index.php method=GET name=producers>\n";
            print "<select name=producer_filter onChange=\"this.form.submit();\" style='width: 98%;'>\n";
            print "<option value='0'>$lang->producer_select</option>\b";
            while (list($producer,$id_producer) = each($__all_producers)) {
                $producer=stripslashes($producer);
                if ($__producer_filter==$id_producer) {
                    $selected=" selected";
                    $this->producer_filter_name=$producer;
                } else $selected="";
                if (strlen($producer)>$this->max_producer_chars) $producer=substr($producer,0,$this->max_producer_chars)."...";
                print "<option value='$id_producer'$selected>" . LangF::translate($producer) . "</option>\n";
            }
            print "</select>";
            //            print "<input type=image src="; $this->bmp("next.gif","layout_buttons"); print " class=\"border0\"></nobr>\n";
            print "</form>\n";
        }
        return;
    } // end producers_category()
    // -- end  producers_category

    // --- end Plugins ---

    /**
    * Funkcja generujca otwarcie okienka z lewej lub prawej strony sklepu
    *
    * @param  int    $width     szerokosc tabeli w px
    * @param  string $data      tekst do wyswietlenia jako nazwa naglowka
    * @param  int    $width     szerokosc tabeli
    * @param  int    $bar       generowac naglowek czy okno 1 - naglowek / 0 - tabela
    * @param  int    $open_body generowac otwarcie okienka czy sam bar 1 - okno / 0 - bar
    *
    * @access public
    *
    * @return void
    */
    function win_top($data='',$width=180,$bar=0,$open_body=1){
        global $config, $prefix;
        if($bar==1){
            $img_file="bar";
        } else {
            $img_file="top";
        }
        if($data == '&nbsp;')
        $data = '';
        $left      = $prefix . $config->theme_config['box']['img'][$img_file]['left'];
        $center    = $prefix . $config->theme_config['box']['img'][$img_file]['center'];
        $right     = $prefix . $config->theme_config['box']['img'][$img_file]['right'];

        /**
    	* pomniejsz szerokosc kolumny
    	* o szerokosc naroznikow tabeli
    	* o ile nie wpisano wartosci w %
    	*/
        if (preg_match ("/(\%)$/", $width)) {
            $cell_width="";
            $open_body=0; // dla wartosc procentowych szerokosci mozna generowac tylko bar'y z tekstem
        } else {
            $cell_width=$width-30;
        }
        print "<table width=\"$width\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
        print "  <tr>\n";
        print "    <td  align=\"left\" background=\"";
        $this->img($center);
        print "\"><img alt=\"\" src=\"";
        $this->img($left);
        print "\" ></td>\n";
        print "    <td width=\"$cell_width\" background=\"";
        $this->img($center);
        print "\" align=\"center\" style=\"color: ";
        if ($bar==1){
            print  $config->theme_config['colors']['header_font'];
        } else {
            print $config->theme_config['colors']['base_font'];
        }
        print "; font-weight: bold;\">";
        print $data;
        print "</td>\n";
        print "    <td  align=\"right\" background=\"";
        $this->img($center);
        print "\"><img alt=\"\" src=\"";
        $this->img($right);
        print "\" ></td>\n";
        print "  </tr>\n";
        print "</table>\n";

        /**
    	* jesli nie jest to bar to zalacz cialo tabelki
    	*/
        if ($open_body==1){
            $this->win_body_open($width);
        }

        return;
    } // end win_top()

    /**
    * Funkcja generujca zamkniecie okienka z lewej lub prawej strony sklepu
    *
    * @param int $width szerokosc tabeli w px
    *
    * @return void
    */
    function win_bottom($width=180){

        global $config, $prefix;
        $this->win_body_close();
        $cell_width=$width-30;

        $left      = $prefix . $config->theme_config['box']['img']['bottom']['left'];
        $center    = $prefix . $config->theme_config['box']['img']['bottom']['center'];
        $right     = $prefix . $config->theme_config['box']['img']['bottom']['right'];

        print "<table width=\"$width\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
        print "  <tr>\n";
        print "    <td ><img alt=\"\" src=\"";
        $this->img($left);
        print "\" ></td>\n";
        print "    <td width=\"100%\" background=\"";
        $this->img($center);
        print "\" align=\"center\" style=\"color: #FFFFFF; font-weight: bold;\"></td>\n";
        print "    <td ><img alt=\"\" src=\"";
        $this->img($right);
        print "\" ></td>\n";
        print "  </tr>\n";
        print "</table>\n";

        return;
    } // end win_bottom()


    /**
    * Funkcja generujca otwarcie ciala okienka z lewej lub prawej strony sklepu
    *    
    * @param  int        $width szerokosc tabeli w px
    *
    * @access private
    *
    * @return void
    */
    function win_body_open($width=180){
        /**
    	* pomniejszona szerokosc kolumny o szerokosc ramki
    	* @var int
    	*/
        $cell_width=$width-2;

        global $config, $prefix;

        print "<table width=\"".$width."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\">\n";
        print "  <tr>\n";
        print "    <td width=\"1\" background=\"";
        $this->path($prefix . $config->theme_config['box']['img']['middle']['left']);
        print "\"><img alt=\"\" src=\"";
        //    	$this->img("_img/_mask.gif");
        $this->path($prefix . $config->theme_config['box']['img']['middle']['left']);
        print "\" ></td>\n";
        print "    <td width=\"100%\" align=\"left\">";

        return;
    } // win_body_open();

    /**
    * Funkcja generujca otwarcie ciala okienka z lewej lub prawej strony sklepu
    *    
    * @param  int        $width szerokosc tabeli w px
    *
    * @private
    * @return none
    */
    function win_body_close(){
        global $config, $prefix;
        print "</td>\n";
        print "    <td width=\"1\" background=\"";
        $this->path($prefix . $config->theme_config['box']['img']['middle']['right']);
        print "\"><img alt=\"\" src=\"";
        //    	$this->img("_img/_mask.gif");
        $this->path($prefix . $config->theme_config['box']['img']['middle']['right']);
        print "\" ></td>\n";
        print "  </tr>";
        print "  </table>";

        return;
    } // end win_body_close()

    /**
    * Link odsy³aj±cy do pe³nej informacji o artykule itp.
    *
    * @param string $link link do strony
    * @param int    $img  format wyswietlanego odsylacza (0 - text/1 - image)
    *
    * @return void
    */
    function infoOnPageURI($uri="", $img=0) {
        global $lang;

        if(empty($uri)) return;

        print "<a href=\"".$uri."\">";
        if($img==1){
            print "<img src=\"";
            $this->img("_img/info.gif");
            print "\" border=\"0\" alt=\"info\" align=\"absmiddle\">";
        } else print $lang->infoOnPageURI['name'];

        print "</a>&nbsp;";

        return;
    } // end info()

    /**
    * wyswietla logo firmy sote oraz link do strony producenta oprogramowania
    * xHTML 4.01
    *
    * @access public
    *
    * @return void
    */
    function copyrightSOTE(){
        global $lang;

        print "<table>\n";
        print "  <tr>\n";
        print "    <td>";
        print "<a href=\"http://www.sote.pl\" target=\"_blank\">";
        print $lang->foot_soft;
        print "</a>";
        print "</td>\n";
        print "    <td>";
        print "<a href=\"http://www.sote.pl\" target=\"_blank\">";
        print "<img src=\"";
        $this->path("_img/_bmp/foot/logo_foot.gif");
        print "\" border=\"0\" alt=\"Sklepy internetowe\">";
        print "</a>";
        print "</td>\n";
        print "  </tr>\n";
        print "</table>\n";

        return;
    } // end copyrightSOTE()

    /**
    * Generuje link do okienka popup
    * aby funkcja dzialala poprawnie nalezy w head.html.php
    * zalaczyc skrypt JavaScript (popupWindow.js) lub napisac funkcje
    * wywolujaca okno popup i przekazac do niej odpowiednie parametry
    *
    * @param string $file   nazwa pliku wyswietlanego w okienku lub adres URI
    * @param string $alt    informacja wyswietlana jako info po najechaniu myszka na bitmape
    *                       lub nazwa linku tekstowego
    * @param int    $img    link w postaci tekstowej lub graficznej (0 - text/1 - bitmapa)
    * @param int    $width  szerokosc okienka popUp
    * @param int    $height wysokosc okienka popUp
    *
    * @access public
    *
    * @return void
    */
    function helpPopup($file="",$alt="Info",$img=0,$width=400,$height=300){
        global $DOCUMENT_ROOT, $config;

        if(empty($file)) return;

        $data=ereg_replace("\.\.","",$file);
        if(preg_match("([.html]$)",$file)){
            $_prefix="/themes/_".$config->lang."/_html_files/";
            if(file_exists($DOCUMENT_ROOT.$_prefix.$data)) $data=$_prefix.$file;
            else return;
        }
        else if(preg_match("([.php]$)",$file)){
            if(!preg_match("(^[/])",$file)) $file="/".$file;
            if(!file_exists($DOCUMENT_ROOT.$file)) return;
        }

        print "<a href=\"javascript:popup('".$file."','".$width."','".$height."','20','20','0')\" onMouseOver=\"window.status=' '; return true;\">";

        if($img==1){
            print "<img src=\"";
            $this->bmp("help","layout_buttons");
            print "\" border=\"0\" alt=\"".$alt."\">";
        } else print $alt;

        print "</a>\n";

        return;
    } // end helpPopup()

    /**
    * pokaz dostepne promocje
    */
    function showPromotions(){
        global $shop;

        print "<div align=\"left\">\n";
        $shop->promotions();
        $shop->promotions->basketForm();
        print "</div>\n";

        return;
    } // end showPromotions()

    /**
    * Poka¿ kwotê zamówienia, warto¶æ koszyka w odpowiedniej walucie.
    * Funckja wykorzystywana do podgl±du warto¶ci zmówienia.
    *
    * @author m@sote.pl
    * @return string warto¶c zamówienia  + waluta
    */
    function basketAmount() {
        global $shop,$_SESSION;
        $shop->currency();
        if (! empty($_SESSION['global_basket_amount'])) {
            $price=$_SESSION['global_basket_amount'];
            return $shop->currency->price($price)." ".$shop->currency->currency;
        } else return "0 ".$shop->currency->currency;
    } // end basketAmount()


    /**
    * Wy¶wietl obiekt SELECT
    *
    * @author lech@sote.pl
    * @param string $name Nazwa i identyfikator obiektu, nazwa zmiennej przekazanej przy zatwierdzeniu formularza
    * @param array $options Tablica warto¶ci opcji do wyboru, klucz tablicy stanowi warto¶æ pola, warto¶æ tablicy - tekst wy¶wietlany opcji
    * @param string $selected_value Warto¶æ domy¶lnie wybrana w obiekcie (jeden z kluczy w tablicy opcji)
    * @param string $javascript dodatkowe parametry znacznika SELECT - w tym kod javascriptu
    */
    function inputSelect($name, $options, $selected_value, $javascript = '') {
        global $lang;
        echo "<select name='$name' id='$name' $javascript>";
        print "<option value=0>".$lang->country_user_def."</option>";
        while(list($key, $val) = each($options)) {
            $sel = '';
            if($key == $selected_value)
            $sel = 'selected';
            echo "
            <option value='$key' $sel>$val</option>
            ";
        }
        echo "</select>";
    }

    /**
    * Wstaw ukryte pole formularza
    *
    * @author lech@sote.pl
    * @param string $name Nazwa i identyfikator pola, nazwa zmiennej przekazanej przy zatwierdzeniu formularza
    * @param string $value Warto¶æ domy¶lna pola
    * @param string $show_value Opcjonany tekst, który mo¿na wy¶wietliæ
    */
    function inputHidden($name, $value, $show_value='') {
        echo "<input type=hidden name='$name' id='$name' value='$value'>$show_value";
    }

    /**
    * Wstaw pole z krajami
    *
    * @author lech@sote.pl
    * @param string $name Nazwa i identyfikator pola, nazwa zmiennej przekazanej przy zatwierdzeniu formularza
    * @param string $value Warto¶æ domy¶lna pola
    * @param string $locked Blokada pola: je¶li 0: pojawi siê lista rozwijana z mo¿liwo¶ci± wyboru kraju; 1: pojawi siê tylko nazwa kraju bez mo¿liwo¶ci wyboru
    * @param string $javascript dodatkowe parametry znacznika - w tym kod javascriptu
    */
    function inputCountries($name, $value, $locked = 0, $javascript = '') {
        global $lang;
        if($locked == 0) {
            $this->inputSelect($name, $lang->country, $value, $javascript);
        }
        else {
            $this->inputHidden($name, $value, $lang->country[$value]);
        }
    }

    /**
    * Wy¶wietl flagi jêzykowe
    *
    * @author lech@sote.pl
    */
    function showFlags() {
        global $config, $config_flags, $DOCUMENT_ROOT;
        include_once ("$DOCUMENT_ROOT/themes/base/base_theme/_flags/config_flags.inc.php");
        $lang_count = 0;
        for($i = 0; $i < count($config->langs_symbols); $i++) {
            if($config->langs_active[$i])
            $lang_count++;
        }
        if($lang_count > 1) {
            for($i = 0; $i < count($config->langs_symbols); $i++) {
                if($config->langs_active[$i]) {
                    $lang_name = $config->langs_names[$i];
                    echo "<a href='/go/_lang/?lang_id=$i'><img src='"; $this->img("_flags/" . $config_flags->files[$config->langs_symbols[$i]]); echo "' border=0 alt='$lang_name'>&nbsp;";
                }
            }
        }
    }

    /**
    * Wy¶wietl ikonki GG uwzglêdniaj±c odpowiednie statusy wg pliku syatusów.
    *
    * @author lech@sote.pl m@sote.pl
    * @param int $gg_id numer GG
    * @return void
    */
    function gg($gg_id) {
        global $DOCUMENT_ROOT;

        $file_gg="$DOCUMENT_ROOT/plugins/_gg/config/gg_status.txt";
        if ($fd=fopen($file_gg,"r")) {
            $gg=unserialize(fread($fd,filesize($file_gg)));
            if (! empty($gg[$gg_id])) {
                echo "<a href=\"gg:$gg_id\"><img src='"; $this->img("_img/_bmp/gg/gg_" . $gg[$gg_id] . ".gif"); echo "' border=\"0\">$gg_id</a>";
            }
        }
    } // end gg()


    /**
    * Wy¶wietl wszystkie kategorie przegl±daj±c je w g³±b rekurencyjnie
    *
    * Funkcja wywo³uje sam± siebie dla ka¿dej podkategorii, która nie jest li¶ciem
    *
    * @author lech@sote.pl
    * @param array $sub_arr Tablica kategorii (kopia $__category) lub przekazana podtablica
    * @param int $level Poziom zagnie¿d¿enia rekurencji
    * @param string $type google -> linki do stron statycznych, "other" -> linki do stron dynamicznych
    *
    * @see config/tmp/category.php
    */
    function categoriesRecursive($sub_arr, $level = 0, $type="other") {
        global $ocnfig;
        reset($sub_arr);
        while (list($key, $val) = each($sub_arr)) {
            $id_cat = $key;
            $subtree = array();
            unset($subtree);
            $subtree = $val;
            if($level > 0) {
                if ((is_array($val)) && (empty($val['name']))) {
                    $arr = array_keys($val);
                    $subtree = $val[$arr[0]];
                    $id_cat = $arr[0];
                }
            }

            if((!empty($subtree['name'])) && (is_array($subtree))) {
                if($level == 0) {
                    if ($type=="google") {
                        echo "<li><a href='/html/cat_$id_cat".".html'>" . $subtree['name'] . "</a></li>\n";
                    } else {
                        echo "<li><a href='/go/_category/?idc=$id_cat'>" . $subtree['name'] . "</a></li>\n";
                    }
                }
                else {
                    if ($type=="google") {
                        echo "<li><a href='/html/cat_$id_cat".".html'>" . $subtree['name'] . "</a</li>\n";
                    } else {
                        echo "<li><a href='/go/_category/?idc=$id_cat'>" . $subtree['name'] . "</a</li>\n";
                    }
                }
                if (!empty($subtree['elements'])) {
                    $subsubtree = array();
                    $subsubtree = $subtree['elements'];
                    // print "<ul>\n";
                    $this->CategoriesRecursive($subsubtree, $level + 1);
                    // print "</ul>\n";
                }
            }
            else {
                if ($type=="google") {
                    echo "<li><a href='/html/cat_$val".".html'>" . $key . "</a></li>\n";
                } else {
                    echo "<li><a href='/go/_category/?idc=$val'>" . $key . "</a></li>\n";
                }
            }

            //        if (is_array())
        }
        return;
    }


    /**
    * Wstaw link do wersji Google dla Google;)
    *
    * @author  m@sote.pl
    * @return void    
    */
    function google() {
        global $config,$lang;
        if (@$config->google_active) {
            print "<a href=\"/google.php\">$lang->google_up_link</a>\n";
        }
    } // end google()

    function _wishlist($id,$xml_options) {
    	if (! empty($xml_options)) return 0;
        $this->_wishlistSimple($id);
        return;
    } // end _basket()

    /**
    * Wy¶wietl ikonkê (formularz) koszyka.
    * Funkcja powoduje wy¶wietlenie zwyk³ego koszyka. Ró¿ni sie od basket() tym, ¿e nie powoduje
    * wy¶wietlania formularza z opcjami.
    *
    * @param  int    $id identyfikator produktu (id z tabeli main)
    * @access private
    * @return none
    */
    function _wishlistSimple($id) {
        global $config;
        global $lang;
        if (@$config->catalog_mode==1){
            return;
        }
        global $config, $prefix;
        print "<form action=\"/go/_basket/index3.php\" method=POST>\n";
        print "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
        print "<input type=\"hidden\" name=\"formName\" value=\"wishlistForm\">";
        print "<input class=border0 type=\"image\" src=\"";
        print $this->filepath("_img/_bmp/" . $config->theme_config['icons']['wishlist']);
        print "\" title=\"".$lang->tooltip['wishlist']."\">";
        print "</form>\n";

        return;
    } // end _basketSimple()

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ ikonkê koszyk i je¶li tak, to wy¶wietl j±.
    * Funckja ta zastêpuje wcze¶niejsze wywo³ania postaci $theme->basket().
    *
    * @author m@sote.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recWishlist($id,&$rec) {
       if (@$rec->data['points']!=1 && $this->checkView('Basket',$rec)) { 
            return $this->_wishlist($id,@$rec->data['xml_options']);
    	}
    } // end recInfo()
    // end Basket:

    /**
    * Sprawd¼ czy mo¿na wy¶wietliæ opis ikonki schowka i je¶li tak, to wy¶wietl go.
    *
    * @author tomasz@mikran.pl
    * @param  int     $id  id produktu (z tabeli main)
    * @param  object &$rec adres obiektu z danymi produktu $rec->data
    * @return none
    */
    function recWishlistDescription($id,&$rec) {
       global $lang;
       if (@$rec->data['points']!=1 && $this->checkView('Basket',$rec)) 
       { 
          print "<form action=\"/go/_basket/index3.php\" method=\"POST\" name=\"add2wishlistItem_".$id."\">";
          print "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
          print "<a onclick=\"document.forms['add2wishlistItem_".$id."'].submit(); \" style='cursor: pointer;'>";
          print $lang->icons_description['wishlist'];
          print "</a>";
          print "</form>\n";
       }
       return;
    } // end recInfo()

    /**
    * Przechowalnia jest pusta
    */
    function wishlist_empty() {
        global $lang;

        $this->bar($lang->wishlistForm);
        print "<p><center>$lang->wishlist_empty</center>";
        return(0);
    } // end basket_empty()

    
    /**
    * Wyswietl link do przechowalni
    */
    function wishlistLink() {
        global $DOCUMENT_ROOT, $image;
        $file="wishlistlink.html.php"; $include_once=true;
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        return(0);
    } // end foot()

    
    /**
    * Formularz do filtrowania zamówieñ dla partnerów od daty do daty
    * uzyta w htdocs/index.php
    *
    * @access public
    *
    * @return void
    */
    function ordersFilter() {

        $this->theme_file("orders_filter.html.php");

        return;
    } // end ordersFilter()
    
} // end class Theme

// sprawdz czy sa rozszezenia klas Theme z ktoryms ze zdefinicowanych tematow
$inode=@fileinode("$DOCUMENT_ROOT/themes/base/$config->theme/theme.inc.php");
if ($inode>0) {
    // temat koncowy
    include_once("$DOCUMENT_ROOT/themes/base/$config->theme/theme.inc.php");
} else {
    // sprawdz temat glowny
    $inode2=@fileinode("$DOCUMENT_ROOT/themes/base/$config->base_theme/theme.inc.php");
    if ($inode2>0) {
        include_once("$DOCUMENT_ROOT/themes/base/$config->base_theme/theme.inc.php");
    }
} // end if

// sprawdz czy s± pliki konfiguracyjne w zdefiniowanej hierarchii tematów, odczytaj wszystkie
// definicje konfiguracji w kolejno¶ci od g³ównego tematu do koñcowego

@include_once ("themes/base/base_theme/config/config.inc.php");          // temat g³ówny
@include_once ("themes/base/$config->base_theme/config/config.inc.php"); // temat bazowy
@include_once ("themes/base/$config->theme/config/config.inc.php");      // temat koñcowy
@include_once ("themes/base/$config->theme/config/user_config.inc.php");      // temat koñcowy u¿ytkownika


// sprawdz czy sa lokalne rozszerzenia klasy Theme
@include_once ("./themes/theme.inc.php");

// jesli nie znaleziono zadnej klasy ExtTheme, wedlug ktorej jest utowrzony obiekt $theme
// to utworz standardowy obiekt $theme
if (empty($theme)) 
{
   $theme =& new Theme;
}
?>

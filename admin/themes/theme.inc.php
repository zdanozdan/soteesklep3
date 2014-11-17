<?php
/**
* Klasa obslugi tematu wygladu panelu administracyjnego
*
* @author  m@sote.pl
* @version $Id: theme.inc.php,v 2.65 2005/12/14 08:59:21 lechu Exp $
* @package    themes
* \@lang
* \@encoding
*/

require_once ("include/metabase.inc");
require_once ("include/forms.inc.php");
include_once ("WYSIWYG/wysiwyg.inc.php");

class ThemeAdmin {
    var $bg_bar_color       = "#6699cc";   // kolor tla paskow typu bar
    var $bg_bar_color2      = "#f0f0f0";
    var $bg_bar_color_light = "#d5e6ed";   // jw. light
    var $bg_select          = "#c7d0e8";
    var $bg_select2         = "#a1c6c3";
    var $bg_select3         = "#F2E1E9";
    var $img_border         = 0;
    var $dir                = "/themes/_pl/standard";  // katalog tematu wzgledem URL
    var $theme_dir          = "themes/_pl/standard/";  // katalog tematu wzgledem include_path
    var $max_producer_chars = 20;
    var $onclick            = "onclick=\"open_window(760,580)\"";

    var $dbedit_bar_size    = "98%";            // szerokosc paska bar nad listami produktow

    /**
    * Konstruktor
    */
    function ThemeAdmin() {
        global $config;
        $this->dir=$config->admin_dir."/themes/_pl/standard";
        return(0);
    } // end ThemeAdmin()

    /**
    * Przekieruj u¿ytkownika na wskazan± stronê.
    * Domy¶lnie u¿ytkownik jest przekierowywany na stronê g³ówn±.
    *
    * @param  string $url
    * @param  int    $time ilo¶æ sekund, po których nastêpuje przekierowanie
    * @return none
    */    
    function go2main($url="index.php",$time=0) {
        global $sess;

        print "<html>\n";
        print "<head>\n";
        print "<meta HTTP-EQUIV=\"refresh\" content=\"".$time.";url=$url?$sess->param=$sess->id\">\n";
        print "</head>\n";
        print "<html>\n";
        
        return;
    } // end go2main()

    /**
    * Funkcja wyswietlajaca 1/0 -> tak/nie
    *
    * @param  bool $active
    * @return text "yes"+"no"
    */
    function yesNo($active=0) {
        global $lang;
        if ($active==1) return $lang->yes;
        else return "<font color=red>".$lang->no."</font>";
    } // end yesNo()

    /**
    * Wysiwetl przycisk submit "usun" + ikonke koszyka
    *
    * @access public
    * @param string $window Je¶li $window=='window' - linkuj do nowego okna popup
    * @return void
    */
    function trashSubmit($window='') {
        global $lang;
        require_once ("themes/include/java_script/select_all.js");
        if($window == 'window') {
            echo "<button type='button' onclick=\"window.open('', 'window', 'width=300, height=200, scrollbars=0, resizable=1, status=0, toolbar=0'); this.form.submit();\">" . $lang->delete . "</button>";
        }
        else {
            print "<input type=submit value=\"$lang->delete\">";
        }
        print "<img src=/themes/base/base_theme/_img/trash.png>\n";
        print "<br><nobr><input type=button onClick=select_all(this.form) value='[x]'><input type=reset value=$lang->reset></nobr>";
        return;
    } // end trashSubmit()

    /**
    * Wysiwetl przycisk submit "usun" + ikonke koszyka
    *
    * @access public
    * @return void
    */
    function trashSubmitOnly() {
        global $lang;
        require_once ("themes/include/java_script/select_all.js");
        //print "<input type=submit value=\"$lang->delete\">";
        //print "<img src=/themes/base/base_theme/_img/trash.png>\n";
        print "<br><nobr><input type=button onClick=select_all(this.form) value='[x]'><input type=reset value=$lang->reset></nobr>";
        return;
    } // end trashSubmit()

    /**
    * Wyswietl ostatni wiersz listy + przycisk "zaznacz wszystkie" i usun
    *
    * @param int $max ilosc kolumn (bez pola usun)
    * @param string '' lub 'window', jesli window wynik pojawia sie w nowym oknie
    *
    * @access public
    * @return void
    */
    function lastRow($max,$window='') {
        global $dbedit, $__no_head, $_print_mode, $_SERVER;
        if ($dbedit->last_record_on_page == 1) {
            print "<tr>";
            if($window == 'orders_print') {
                if (@$__no_head!=1 || !@$_print_mode) {
                	$qry_str = $_SERVER['QUERY_STRING'];
                	$qry_str = "?print_mode=1&" . $qry_str; 
                	$php_self = $_SERVER['PHP_SELF'];
                    echo "<td align=right colspan=$max><a href=$php_self" . $qry_str . " onclick=\"window.open('', 'popup1', 'width=600, height=500, resizable=1, scrollbars=1, status=0, toolbar=0');\" target='popup1'><img src='"; $this->img("_img/druk.gif"); echo "' border=0></a></td>";
                }
            }
            else {
                for ($i=1;$i<=$max;$i++ ){
                    print "<td></td>";
                }
            }
            print "<td>";$this->trashSubmit($window);print "</td>";
            print "</tr>";
        }

        return;
    } // end lastRow()

    /**
    * Wyswietl ostatni wiersz listy + submita do przedzia³ów dostêpno¶ci + przycisk "zaznacz wszystkie" i usun
    *
    * @param int $max ilosc kolumn (bez pola usun)
    * @param string '' lub 'window', jesli window wynik pojawia sie w nowym oknie
    *
    * @access public
    * @return void
    */
    function lastRowIntervals($max,$window='') {
        global $dbedit, $lang;
        $onclick = "document.getElementById('FormList').action='index.php?update_intervals=1'; document.getElementById('FormList').submit();";
        $max = $max - 2;
        if ($dbedit->last_record_on_page==1) {
            print "<tr>";
            for ($i=1;$i<=$max;$i++ ){
                print "<td></td>";
            }
            print "
            <td colspan=2 align=center bgcolor='#dddddd'>
                <button type='button' onclick=\"$onclick\">" . $lang->confirm . "</button>
            </td>
            ";
            print "<td>";$this->trashSubmit();print "</td>";
            print "</tr>";
        }

        return;
    } // end lastRow()

    /**
    * Wyswietl ikonki kwadratowe w 1 kolorze
    *
    * @param string $color  r - red, g - green, b - blue
    * @param int    $width  szerokosc
    * @param int    $height wysokosc
    */
    function point($color,$width=10,$height=10) {
        if ($color=="rg") {
            $width=intval($width/2);
            print "<nobr>";
            print "<img src=/themes/base/base_theme/_img/r.png width=$width height=$height>";
            print "<img src=/themes/base/base_theme/_img/g.png width=$width height=$height>";
            print "</nobr>";
        } elseif ($color=="rblack") {
            $width=intval($width/2);
            print "<nobr>";
            print "<img src=/themes/base/base_theme/_img/r.png width=$width height=$height>";
            print "<img src=/themes/base/base_theme/_img/black.png width=$width height=$height>";
            print "</nobr>";
        } else {
            print "<img src=/themes/base/base_theme/_img/$color.png width=$width height=$height>";
        }
        return(0);
    } // end point()

    /**
    * Funkcja zwracajaca odpowiedni kod Javascript do otwierania nowego okna w zaleznosci od podanych parametrow
    *
    * @author piotrek@sote.pl
    * @param  $width   szerokosc okna
    * @param  $height  wysokosc okna
    *
    * @public
    */
    function onclick($width,$height) {
        $click="onclick=\"window.open('','window','width=$width,height=$height,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
        return $click;
    } // end onclick()

    /**
    * Naglowek HTML z panelem nawigacjyjnym
    */
    function head() {
        $file="head.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return (0);
    } // end head()

    /**
    * Stopka HTML
    */
    function foot() {
        $file="foot.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end foot()

    /**
    * Naglowek HTML bez panelu nawigacyjnego, uproszczony
    */
    function head_window() {
        $file="head_window.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end head_window()

    /**
    * Naglowek HTML bez panelu nawigacyjnego, uproszczony, w stronie kodowej UTF-8
    */
    function head_window_utf8() {
        $file="head_window_utf_8.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end head_window()
    
    /**
    * Stopka uproszczona
    */
    function foot_window() {
        $file="foot_window.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end foot_window()

    /**
    * Otworz obszar desktop
    *
    * @param string $width szerokosc elementu dekstop
    * @param string $align wyrownanie
    */
    function desktop_open($width='98%',$align='') {
        $file="desktop_open.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end desktop_open()

    /**
    * Zamknij obszar desktop
    *
    * \@depend $this->desktop_open()
    */
    function desktop_close() {
        $file="desktop_close.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end desktop_close()

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
    function frame_open($title='frame',$width='100%',$align='') {
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
    * Wyswietl plik z tematu
    *
    * @param string $file nazwa pliku (sciezka do pliku wzgledem glownego katalogu tematu)
    */
    function theme_file($file) {
        global $lang,$config;
        global $permf;
        global $time;

        $include_once=false;
        include ("themes/include/theme_file.inc.php");

        return(0);
    } // end theme_file()

    /**
    * Wy¶wietl wartosc w formacie ceny
    *
    * @author  m@sote.pl
    *
    * @param float $price cena
    * @return float cena w odpowiednim formacie
    */
    function price($price) {
        return number_format($price,2,".","");
    } // end price()

    /**
    * Wyswietl plik z katalogu tematu html_files
    *
    * param $file - nazwa wyswietlanego pliku
    * param $lang_name - nazwa jezyka
    */
    function file($file,$lang_name) {
        global $config;

        if ($lang_name=="") {
            $lang_name=$config->lang;
        }

        include_once("themes/_$lang_name/_html_files/$file");

        return(0);
    } // end file()

    /**
    * Naglowek glownego obszaru strony (podzial na kolumny)
    */
    function page_open_head(){
        $file="page_open_head.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end page_open_head()

    /**
    * Zakniecie glownego obszaru strony
    */
    function page_open_foot(){
        $file="page_open_foot.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end page_open_foot()

    /**
    * Lewa kolumna
    */
    function left() {
        $file="left.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return;
    } // end left()

    /**
    * Wyswietl sciezke (+nazwa) do obrazeka z katalogu tematu, lub z base_theme
    *
    * @param string $image nazwa pliku
    * @param bool   $stdout true wyswietlaj sciezke, false zwroc wartosc
    * @return string|bool
    */
    function img($image,$stdout=true) {
        global $config;
        global $DOCUMENT_ROOT;

        $o='';

        $base_theme=$config->admin_base_theme;

        // sprawdz czy jest plik w zdefiniowanym temacie (katalog jezykowy)
        $inode=@fileinode($config->admin_theme_dir."/$image");

        if ($inode>0) {
            $o=$config->admin_dir."/themes/_$config->lang/$config->admin_theme/$image";
        } else {

            // sprawdzam czy plik jest w katlogu base tematu zdefiniowanego
            $inode2=@fileinode("$DOCUMENT_ROOT/themes/base/$config->admin_theme/$image");
            if ($inode2>0) {
                $o=$config->admin_dir."/themes/base/$config->admin_theme/$image";
            } else {

                // sprawdzam czy istnieje plik w $base_theme (katalog jezykowy)
                $inode3=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$image");
                if ($inode3>0) {
                    $o=$config->admin_dir."/themes/_$config->lang/$base_theme/$image";
                } else {

                    //sprawdzam czy plik istnieje w $base_theme (katalog base)
                    $inode4=@fileinode("$DOCUMENT_ROOT/themes/base/$base_theme/$image");
                    if ($inode4>0) {
                        $o=$config->admin_dir."/themes/base/$base_theme/$image";
                    } else {

                        //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog jezykowy)
                        $inode5=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$image");
                        if ($inode5>0) {
                            $o=$config->admin_dir."/themes/_$config->lang/base_theme/$image";
                        } else {

                            //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog base)
                            $inode6=@fileinode("$DOCUMENT_ROOT/themes/base/base_theme/$image");
                            if ($inode6>0) {
                                $o=$config->admin_dir."/themes/base/base_theme/$image";
                            }

                        } //end if
                    } //end if

                } //end if
            } // end if
        } // end if

        if ($stdout==true) print $o;
        else return $o;

        return(0);
    } // end img()


    /**
    *
    * Ikonka+link dodania do koszyka
    * @deprecated since 3.0
    *
    */
    function basket($rec='') {
        if (empty($rec)) {
            global $rec;
        }
        global $config;

        if ($config->cd==1) return;

        print '<a href='.$config->htdocs_dir."/go/_basket/?id=".$rec->data['id'].">";
        print "<img src='";$this->img("_img/basket.gif");print "' border=0>";
        print "</a>";
    } // end basket()

    /**
    * Ikonka+link dodania do koszyka jako element formularza
    *
    * global object $rec dane o produkcie z bazy danych ($rec->data)
    * @deprecated since 3.0
    */
    function basket_f() {
        global $rec;
        global $config;

        if (empty($rec)) {
            global $rec;
        }

        // start plugin cd:
        if ($config->cd==1) return '';
        // end plugin cd:

        print "<form action=\"/go/_basket/index.php\">\n";
        print "  <input type=\"hidden\" name=\"id\" value=\"".$rec->data['id']."\">";
        print "  <input class=\"border0\" type=\"image\" src=\"";
        $this->img("_img/basket.gif");
        print "\">";
        print "</form>\n";
        return(0);
    } // end basket_f()


    /**
    * Ikonka+link dodania do koszyka jako element formularza
    *
    * global object $rec dane o produkcie z bazy danych ($rec->data)
    * @deprecated since 3.0
    */
    function basket_f2() {
        global $rec;
        global $config;

        if ($config->cd==1) return;


        print "<input type=hidden name=id value='".$rec->data['id']."'>";
        print "<input type=image src="; $this->img("_img/basket.gif"); print " border=0>";

        return(0);
    } // end basket_f()


    /**
    * Wstaw link, icone z opisem
    *
    * @param string $image nazwa ikonki z tematu _img/_icons
    * @param string $link  URL do ktorego prowadzi ikonka
    * @param string $text  tekst pod ikonka, opis ikonki
    * @return string HTML z ikonka, opisem ikonki i linkiem
    */
    function icon($image,$link,$text) {
        global $permf;

        // sprawdz uprawnienia uzytkwonika
        if (! $permf->check_link($link)) return;

        $o="<center><a href='$link'><img src=".$this->img("/_icons/".$image,false)." border=0></a><br><nobr>$text</nobr></center>";

        return $o;
    } // end folder()


    /**
    * Przycisk powrotu do poprzedniej strony
    */
    function back() {
        global $lang;
        print "<form><input type=button value='$lang->back' onClick=\"history.back();\"></form>";
    } // end back()


    /**
    * Przycisk zamknij bie¿±ce okno.
    */
    function close() {
        global $lang;
        print "<form><input type=button value='$lang->close' onClick=\"window.close();\"></form>";
    } // end back()


    /**
    * Pasek z napisem "bar"
    *
    * @param string $text tekst pokaujacy sie na psaku BAR
    */
    function bar($text) {
        $file="bar.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return;
    } // end bar()

    /**
    * Pasek z informacja o statusie operacji
    */
    function status_bar($text="") {
        if (! empty($text)) {
            print "</b>$text</b><br>";
        }
        return;
    } // end status_bar()

    /**
    * Wyswietl wiersz w prezentacji rekordu w liscie
    *
    * @param object $rec dane produktu np. $rec->data=array("name"=>"Komputer A100","producer"=>"Toshiba",...)
    */
    function record_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        $file="record_row.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end record_row()

    /**
    * Emulacja funkcji skroconej prezentacji rekordu jw.
    *
    * @param object $rec dane produktu np. $rec->data=array("name"=>"Komputer A100","producer"=>"Toshiba",...)
    */
    function record_row_short(&$rec) {
        return $this->record_row($rec);
    } // end record_row_short()

    /**
    * Wyswietl wiersz prezentacji uzytkwonika
    */
    function users_record_row(&$rec) {
        // nie wstawiac include_once, bo plik ma byc ladowany wiele razy!
        $file="users_record_row.html.php"; $include_once=false;
        include ("themes/include/theme_file.inc.php");
        return(0);
    } // end users_record_row()

    /**
    * Ikonka+link - informacja szczegolowa o produkcie (info)
    *
    * \@global object $rec dane z bazy ($rec->data['id'])
    */
    function info() {
        global $rec;
        print "<a href=/go/_info/?id=".$rec->data['id']."><img src=";$this->img("_img/info.gif");print " border=0></a>";
        return (0);
    } // end info()

    /**
    * Menu main dla listy produktow
    * @deprecated since 3.0
    */
    function menu_list() {
        return;
    }

    /**
    * Nazwy elementow nad lista produktow
    *
    * \@global bool $__disable_trash true - nie pokazuj pola "usun"
    *
    * @access public
    * @return string HTML table
    */
    function list_th() {
        global $__disable_trash;
        global $lang;

        $o="<table align=center>\n";
        $o.="<tr bgcolor=$this->bg_bar_color_light><th>".$this->nameOrder("ID",1)."</th>\n";
        $o.="<th></th>\n";
        $o.="<th><nobr>".$this->nameOrder($lang->cols['name'],2)."</nobr></th>\n";
        $o.="<th><nobr>".$this->nameOrder($lang->cols['producer'],3)."</nobr></th>\n";
        $o.="<th><nobr>".$this->nameOrder($lang->cols['category1'],4)."</nobr></th>\n";
        $o.="<th><nobr>".$this->nameOrder($lang->cols['price_brutto'],5)."</nobr></th>\n";
        $o.="<th></th>";
        $o.="<th><nobr>".$this->nameOrder($lang->cols['photo'],6)."</nobr></th>\n";
        if (@$__disable_trash!=true) {
            $o.="<th><nobr>".$lang->trash."</nobr></th>\n";
        }
        $o.="</tr>\n";

        return $o;
    } // end list_th()

    /**
    * Wyswietl tekst link do sortowania + ikonke sortowania
    *
    * @param string $name      nazwa tektu, ktory bedzie podlinkowany (okreslenie nazwy kolumny)
    * @param int    $set_order indeks kolumny sortowania (1,-1,2,-2, ...)
    *
    * @access public
    * @return string kod HTML wysweitlenia ikonek z linkami okreslajacymi sortowanie
    */
    function nameOrder($name,$set_order) {
        global $dbedit;

        if (empty($dbedit)) $dbedit = new DBEdit;

        if (@$_REQUEST[$dbedit->order_param]) {
            $order=$_REQUEST[$dbedit->order_param];
            if (! ereg("^[0-9-]+$",$order)) return $name;
        } else $order='';

        $click_order=$order*(-1);
        $url_current_order=$dbedit->page_url(1,array("order"=>$click_order));
        $url=$dbedit->page_url(1,array("order"=>$set_order));

        if (($order==$set_order) || (($click_order==$set_order))) {
            $o="<a href=\"$url_current_order\" alt=\"\">$name";
            if ($order>0) {
                $o.="</a> <img src=/themes/base/base_theme/_img/down.png border=0>";
            } else {
                $o.="</a> <img src=/themes/base/base_theme/_img/up.png border=0>";
            }
        } else {
            $o="<a href=\"$url\" alt=\"\">$name</a>";
        }
        return $o;
    } // end nameOrder()



    /**
    * Link powrotu do edycji rekordu
    */
    function back2edit($id, $text) {
        print "<a href=index.php?id=$id>$text</a>";
        return;
    }

    /**
    * Udalo sie zalaczyc plik photo
    */
    function photo_upload_ok($photo) {
        print "Zdjêcie <B>$photo</B> zosta³o za³±czone:)";
    } // end photo_upload_ok()

    /**
    * Blednie wypelnione pole formularza
    */
    function form_error($name) {
        if (! empty($this->form_check)) {
            if (! empty($this->form_check->errors_found[$name])) {
                print "<font color=red>";
                print $this->form_check->errors_found[$name];
                print "</font>\n";
            }
        }
        return;
    } // end form_error()

    /**
    * Zalacz tekst z html/$file
    *
    * @param string $file zalaczany plik {THEME}/html/$file
    */
    function html_file($file) {
        $file="html/$file";
        include ("themes/include/theme_file.inc.php");
        return;
    } // end html_file()

    /**
    * Dodatkwoe elementy w naglowku listy. Funkcja wymagana ze wzgledu, na wspole wywolanie
    * W aktualizaji i sklepie.
    */
    function top_dbedit() {
        return(0);
    } // end dbedit()


    /**
    * Rechunek faktura pro-forma
    *
    * @param addr $rec dane z bazy ($rec->data)
    * @param addr $xml2html
    */
    function invoice(&$rec,&$xml2html) {
        $file="invoice_edit.html.php";
        include ("themes/include/theme_file.inc.php");
        return (0);
    } // end order_edit()

    /**
    * Edycja danych uzytkownikow
    *
    * @param addr $rec wskaznik na obiekt zawierajacy wlasciwosci transakcji $rec->data['nazwa_pola']
    */
    function users_edit(&$rec) {
        $file="users_edit.html.php"; $include_once=true;
        include ("themes/include/theme_file.inc.php");
        return (0);
    } // end order_edit()

    /**
    * Wartosc elementu formularza value=$this->form_val('nazwa_pola')
    *
    * @param string nazwa pola formularza
    */
    function form_val($name) {
        $form=&$this->form;
        if (! empty($form[$name])) {
            print $form[$name];
        }
        return(0);
    } // end form_val()

    /**
    * Funkcja {} - zachwoanie zgodnowsci z htdocs
    */
    function open_page_links_top() {
        return;
    } // end open_page_links_top()

    /**
    * Obsluga "TIPSOW". Wyswietl dodatkowa ciekawostke o panelu lub wylosuj jesli danych jest wiecej niz 1
    *
    * @param array|string informacje o danym module, ciekawostki
    */
    function tips($tips) {
        if (! is_array($tips)) print $tips;
        else {
            $ltips=sizeof($tips);
            $rand=rand(0,$ltips-1);
            print $tips[$rand];
        }
        return(0);
    } // end tips();

    /**
    * Wybor jezyka (przy aktualizacji np. tekstow, opisow)
    *
    * @param string $action
    * @param int    $id     id edytowanego rekordu
    * @param string $name   nazwa pola formularza
    *
    * @return none
    */
    function choose_lang($action="index.php",$id="",$name="item[lang_id]") {
        global $database;
        global $lang;
        global $config;
        global $_REQUEST;

        // sprawdz, czy jest modul multi_lang, jesli nie ma ustaw domyslny jezyk
        if (! in_array("multi_lang",$config->plugins)) {
            print "<input type=hidden name=$name value=".$config->lang_id.">\n";
            return;
        }

        // odczytaj wybrany jêzyk
        if (isset($_REQUEST['item']['lang_id'])) {
            $my_lang=$_REQUEST['item']['lang_id'];
        } elseif (isset($_REQUEST[$name])) {
            $my_lang=$_REQUEST[$name];
        } else $my_lang=$config->lang_id;
        if (!isset($config->langs_symbols[$my_lang])) {
            $my_lang=0;
        }
        // end
        print "<table>\n";
        print "<tr>\n";
        print "<td>";
        print $lang->choose_language;

        print "</td><td>";

        echo "<form action=\"$action\" method=\"post\" name=\"MyForm\">";
        echo "<input type=hidden name=id value='$id'>";
        echo "<select name=\"lang_id\" onchange=\"javascript:document.MyForm.submit();\">";
        for($i = 0; $i < count($config->langs_symbols); $i++) {
            if($config->langs_active[$i] == 1) {
                $selected = '';
                if($my_lang == $i)
                    $selected = ' selected';
                
                echo "
                <option value='$i' $selected>" . $config->langs_names[$i] . "</option>";
            }
        }
        echo "</select></form>";
        /*
        $forms =& new Forms;
        $forms->auto_update=false;
        $forms->open($action,$id);                         // otwarcie formularza
        if (! ereg("^item\[",$name)) $forms->item=0;         // nie dodawaj item do nazwy pola formularza
        $forms->select("lang",$my_lang,"",$config->languages_names,"","","f_empty","f_empty");  // wyswietlanie selecta
        $forms->close();                                   // zamkniecie formularza
        */
        print "</td>\n";
        print "</tr>\n";
        print "</table>";

        return;
    } // end choose_lang()

    /**
    * Pokaz liste liter z danego jezyka
    *
    * @param string $action link, do ktorego beda sie odnosic poszczegolne litery
    *
    * @acccess public
    * @return  none
    */
    function az($action="az.php") {
        global $lang;
        for ($i=0;$i<strlen($lang->az);$i++) {
            print "<a href=$action?char=".$lang->az[$i].">".$lang->az[$i]."</a> ";
        }
        return(0);
    } // end az()

    /**
    * Pokaz elementy w tabelce wg kolejnosci danych w tabeli, automatycznie generuj nowy wiersz tabeli
    * jesli elementow jest wiecej niz jest zdefiniowanych kolumn.
    * Np. dla $data=array("A","B","C","D","E","F","G"); $cols=4;
    * elementy zostana wyswietlone w postaci:
    * [A] [B] [C] [D]
    * [E] [F] [G]
    * Funckja ta jest uzywana m.in. do wyswietlania ikonek, w zalenosci od tego ktore sa aktywne, ikonki
    * automatycznie ukladaja sie jedna za druga. Bez wykorzystania tej funkcji wystepowaly by luki prz ikonkach
    * ktore nie sa aktywne.
    *
    * @param array $data  dane wyswietlane w poszczegolnych polach
    * @param int   $cols  maksymalna liczba kolumn
    * @param int   $width szerokosc 1 kolumny
    */
    function table_list($data,$cols=10,$width="") {
        reset($data);$i=0;$tr=1;
        if (empty($data)) return (0);

        print "<table border=0>\n";
        print "<tr>";

        foreach ($data as $element) {
            $num=$i%$cols;
            if ($num==0) print "<tr>\n";
            print "\t<td width=$width>\n";
            print $element;
            print "\t</td>\n";
            if ($num==$cols) print "</tr>";
            $i++;
        } // end foreach
        print "</table>\n";

        return(0);
    } // end table_list()


    /**
    * Wyswietl liste tematow do wyboru
    */
    function show_themes() {
        global $config,$lang;

        if ($config->nccp!="0x1388") return (0);

        reset($config->themes);

        print '<form action='.$config->url_prefix.'/go/_themes/index.php>';
        print "<select name=theme onChange=\"this.form.submit();\">";
        while (list($theme,$info) = each($config->admin_themes)) {
            if ($theme==$config->admin_theme) $selected="selected";
            else $selected="";
            print "<option value='$theme' $selected>$info</option>\n";
        }
        print "</select> ";
        print "<input type=submit value='>'>";
        print "</form>";

        return(0);
    } // end show_theme()

    /**
    * Wyswietl link z przekeirowaniem do slownika
    *
    * @param string $text tlumaczony tekst
    *
    * @access public
    * @return void
    */
    function add2Dictionary($text) {
        global $config,$lang;
        
        if (empty($text)) return;
        if (! in_array("multi_lang",$config->plugins)) return;

        $text=urlencode(trim($text));
        print "<a href=$config->url_prefix/plugins/_dictionary/add.php?word=$text onClick=\"open_window(300,500);\" target=window\">$lang->translate</a>";
        return;
    } // end add2Dictionary

    /**
    * Wyswietl link do formularza wysiwyg dla podanego pola
    *
    * @param string $textareaId parametr ID danego pola textarea
    * @param int $wysiwyg_enabled parametr wskazuj±cy, czy link ma zostaæ wy¶wietlony
    *
    * @access public
    * @return void
    * @author lech@sote.pl
    */
    function wysiwygTextarea($textareaId, $wysiwyg_enabled = WYSIWYG_ENABLED){
        global $lang;
        if($wysiwyg_enabled){
            print "<a href='javascript:void(0)' onclick='window.open(\"/go/_text/forms_wysiwyg.php?textareaname=$textareaId&action=open_window\", \"wysiwyg\", \"menubar=0, tootlbar=0, width=800, height=600\")'>" . $lang->wysiwyg_button . "</a>";
        }
    }

    /**
    *
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
    *
    */
    function inputHidden($name, $value, $show_value='') {
        echo "<input type=hidden name='$name' id='$name' value='$value'>$show_value";
    }

    /**
    *
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
} // end class ThemeAdmin

$theme = new ThemeAdmin;

// zaladuj pluginy i utworznowy obiekt $theme z rozszezona klasa ThemePlugins
@include_once ("themes/theme_plugins.inc.php");

// zaladuj o obsluge dynamicznie generowanych butonow
include_once ("themes/include/buttons.inc.php");
$buttons = new Buttons;

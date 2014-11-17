<?php
/**
* @version    $Id: buttons.inc.php,v 1.5 2004/12/20 18:01:27 maroslaw Exp $
* @package    themes
*/

class Buttons {
    var $perm=true;      // sprawdzaj uprawnienia przed wyswietleniem buttona

    /**
     * Sprawdz link i w zaleznosci czy jest wlaczony tryb SV dodaj prefix
     *
     * @param  string $url link 
     * @return string link
     */
    function sv_url($url) {
        global $config;

        if (ereg("^javascript",$url)) {
            return $url;
        } 
        if (ereg("/",$url)) {
            $url2=$config->url_prefix.$url;
        } else {
            $url2=$url;
        }        
        
        return $url2;
    } // end sv_url()

    /**
     * Sprawdz czy obecny wywolany aders odpowiada adersowi zdefiniowanemu dla danego buttona
     *
     * @param  string $url link przypisany do buttona
     * @return bool   true - dany butto jest wywolany; false wpw.
     */
    function check_button($url,$name='') {
        global $_SERVER;
        
        // sprawdz uprawnienia, czy mozna wyswietlic dany przycisk dla danego uzytkownika
        global $permf;
        if (! $permf->check_link($url)) return false;
        // end


        if ($name=="<<") return false;

        $REQUEST_URI=$_SERVER['REQUEST_URI'];
        preg_match("/([a-zA-Z_\/0-9-.]+)/",$REQUEST_URI,$matches);
        preg_match("/([a-zA-Z_\/0-9-.]+)/",$url,$matches_url);
        $current_url=$matches[1];                       
        if (! empty($matches_url[1])) {
            $url=$matches_url[1];
        }

        // sprawdz linki postaci href=index.php href=search.php - odwolania wzgledne
        if (! ereg("/",$url)) {
            if ((ereg("$url$",$current_url)) && (! empty($url)))
                return true;
            if (($url=="index.php") && (! ereg("php$",$current_url))) return true;
        }
        
        // sprawdz linki bez index.php
        // print "<nobr>current_url=$current_url url=$url&nbsp</nobr><BR>";
        if ($current_url."/index.php"==$url) {
            return true;
        }

        
        if ($url==$current_url) return true;
        else return false;
    } // end check_button()

    /**
     * Funckja generuje dynamicznie przyciski (menu)+ linki
     *
     * @param array $buttons np. array("nazwa1"=>"link1","nazwa2"=>"link2")
     */
    function menu_buttons($buttons,$level=1) {
        // sprawdz liczbe przyciskow
        $num=sizeof($buttons); 
     
        // wez 1 klucz+wartosc z tablicy $buttons
        reset($buttons);
        $name=key($buttons);$url=@$buttons[$name]; 

        print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        print "<TR>\n";
        if ($num <= 1) {
            // jesli jest 1 przycisk, to wyswietl wszystkie boki           
            print "<TD>\n";
            $this->button_left($name,$url);
            print "</TD>\n";
        } else {
            $i=0;
            print "<TD>\n";
            $this->button_left($name,$url);
            print "</TD>";$first=false;
            while (list ($name,$url) = each($buttons)) {
                if ($first==true) { 
                    print "<TD>\n";
                    $this->button_right($name,$url);
                    print "</TD>\n";
                } else $first=true;
            }
        }
        print "<TD>&nbsp; &nbsp; </TD>";
        if ($level>1) {
            $i=1;
            while ($i<2) {
                print "<TD> &nbsp; &nbsp; </TD>";
                $i++;
            }
        }
        print "</TR>\n";
        print "</TABLE>\n";
        
        return;
    } // end buttons()

    /**
     * Wyswietl 1 pelny przycisk 
     *
     * @param string $name tekst na przycisku
     * @param string $url link 
     */
    function button_left($name,$url) {       
        global $config;
        global $theme;

        // sprawdz uprawnienia, czy mozna wyswietlic dany przycisk dla danego uzytkownika
        global $permf;
        if (! $permf->check_link($url)) return false;
        // end

        $url=$this->sv_url($url);

        if (! $this->check_button($url,$name)) {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/b1.jpg"); print "></TD>\n";
            print "    <TD background=";$theme->img("_img/_buttons/b2.jpg"); print "><nobr>&nbsp;<A href=$url>$name</A>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/b3.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        } else {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src="; $theme->img("_img/_buttons/xb1.jpg"); print "></TD>\n";
            print "    <TD background="; $theme->img("_img/_buttons/xb2.jpg"); print "><nobr>&nbsp;<A href=$url>$name</a>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src="; $theme->img("_img/_buttons/xb3.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        }
        
        return;
    } // end button_left()
    
    /**
     * Wyswietl przycisk bez lewej krawedzi
     *
     * @param string $name tekst na przycisku
     * @param string $url link 
     */
    function button_right($name,$url) {       
        global $config;
        global $theme;

        // sprawdz uprawnienia, czy mozna wyswietlic dany przycisk dla danego uzytkownika
        global $permf;
        if (! $permf->check_link($url)) return false;
        // end

        $url=$this->sv_url($url);

        if (! $this->check_button($url,$name)) {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/b1a.jpg"); print "></TD>\n";
            print "    <TD background=";$theme->img("_img/_buttons/b2.jpg"); print "><nobr>&nbsp;<A href=$url>$name</A>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/b3.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        } else {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/xb1a.jpg"); print "></TD>\n";
            print "    <TD background=";$theme->img("_img/_buttons/xb2.jpg"); print "><nobr>&nbsp;<A href=$url>$name</a>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/xb3.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        }
    } // end button_right()


    /**
     * Wyswietl 1 pelny "samodzielny" przycisk z tekstem 
     *
     * @param string $name tekst na przycisku
     * @param string $url link 
     */
    function button($name,$url) {
        global $config;
        global $theme;

        // sprawdz uprawnienia, czy mozna wyswietlic dany przycisk dla danego uzytkownika
        global $permf;       
        if (! $permf->check_link($url)) return false;
        // end

        $url=$this->sv_url($url);

        if (! $this->check_button($url,$name)) {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/button_left.jpg"); print "></TD>\n";
            print "    <TD background=";$theme->img("_img/_buttons/button_bg.jpg"); print "><nobr>&nbsp;<A href=$url>$name</A>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/button_right.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        } else {
            print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
            print "  <TR>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/xbutton_left.jpg"); print "></TD>\n";
            print "    <TD background=";$theme->img("_img/_buttons/xbutton_bg.jpg"); print "><nobr>&nbsp;<A href=$url>$name</a>&nbsp;</nobr></TD>\n";
            print "    <TD><IMG src=";$theme->img("_img/_buttons/xbutton_right.jpg"); print "></TD>\n";
            print "  </TR>\n";
            print "</TABLE>\n";
        }
        
        return;
    } // end button_left()
} // end class Buttons

?>

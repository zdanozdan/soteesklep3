<?php
/**
* Obs³uga buttonów. Wyswietlanie menu buttonów itp.
*
* @author m@sote.pl rp@sote.pl
* @version $Id: buttons.inc.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
*/

/**
* Buttony
* @package themes
* @subpackage buttons
*/
class Buttons {
    /**
    * Sciezka do obrazkow.
    * @deprecated since 3.0
    */
    var $img_dir="_img/_layout_buttons";
    
    /**
    * Sprawdz czy obecny wywolany aders odpowiada adersowi zdefiniowanemu dla danego buttona
    *
    * @param  string $url link przypisany do buttona
    * @return bool   true - dany butto jest wywolany; false wpw.
    */
    function check_button($url,$name='') {
        global $_SERVER;
        
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
        $name=key($buttons);$url=$buttons[$name];
        print "\n";
        print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">";
        print "  <tr>";
        if ($num <= 1) {
            // jesli jest 1 przycisk, to wyswietl wszystkie boki
            print "    <td><div class=\"buttons\">";
            $this->button_left($name,$url);
            print "</div></td>\n";
        } else {
            $i=0;
            print "    <td><div class=\"buttons\">";
            $this->button_left($name,$url);
            print "</td>";
            $first=false;
            while (list ($name,$url) = each($buttons)) {
                if ($first==true) {
                    print "    </div><td><div class=\"buttons\">";
                    $this->button_right($name,$url);
                    print "</div></td>";
                } else $first=true;
            }
        }
        print "    <td>&nbsp;&nbsp;</td>";
        if ($level>1) {
            $i=1;
            while ($i<2) {
                print "<td>&nbsp;&nbsp;</td>";
                $i++;
            }
        }
        print "  </tr>\n";
        print "</table>\n";
        
        return;
    } // end buttons()
    
    /**
    * Wyswietl 1 pelny przycisk
    *
    * @param string $name tekst na przycisku
    * @param string $url link
    */
    function button_left($name,$url) {
        global $theme;
        global $config;
        
        // jesli $url jest linkiem wzglednym lokalnym, to nie dodawaj prefixu
        if (! ereg("/",$url)) {
            $url_prefix="";
        } else $url_prefix=$config->url_prefix;
        
        if (! $this->check_button($url,$name)) {
            print "&nbsp;<a href=\"$url_prefix"."$url\" class=\"buttons\">$name</a>&nbsp;";
        } else {
            

            print "&nbsp;<a href=\"$url_prefix"."$url\" class=\"buttons\">$name</a>&nbsp;";

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
        global $theme;
        global $config;
        
        // jesli $url jest linkiem wzglednym lokalnym, to nie dodawaj prefixu
        if (! ereg("/",$url)) {
            $url_prefix="";
        } else $url_prefix=$config->url_prefix;
        
        // nazewnictwo bitmap: bln - button left normal, bcn - button central (back) normal
        if (! $this->check_button($url,$name)) {
            print "\n";
            print "&nbsp;<a href=\"$url_prefix"."$url\" class=\"buttons\">$name</a>&nbsp;";
        } else {
            print "&nbsp;<a href=\"$url_prefix"."$url\" class=\"buttons\">$name</a>&nbsp;";

        }
    } // end button_right()
    
    
    /**
    * Wyswietl 1 pelny "samodzielny" przycisk z tekstem
    *
    * @param string $name tekst na przycisku
    * @param string $url link
    */
    function button($name,$url) {
        global $theme;
        global $config;
        
        // jesli $url jest linkiem wzglednym lokalnym, to nie dodawaj prefixu
        if (! ereg("/",$url)) {
            $url_prefix="";
        } else $url_prefix=$config->url_prefix;
        
        if (! $this->check_button($url,$name)) {

            print "&nbsp;<a href=$url_prefix"."$url>$name</a>&nbsp;";
        } else {

            print "&nbsp;<a href=$url_prefix"."$url>$name</a>&nbsp;";

        }
        return;
    } // end button_left()
} // end class Buttons
?>

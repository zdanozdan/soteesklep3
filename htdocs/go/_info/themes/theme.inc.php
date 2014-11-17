<?php
/**
* Dodatkowe funkcje klasy Theme
*
* @author  rp@sote.pl
* @version $Id: theme.inc.php,v 1.11 2004/12/20 18:01:41 maroslaw Exp $
* @package    info
*/

if (empty($theme)) {
    class MyTheme extends Theme{};
}

class LocalTheme extends MyTheme {
    
    /**
    * Wyswietl pelna prezentacja rekordu
    *
    * \@global object $rec    dane produktu $rec->data
    * \@global object $image  obiekt klasy Image include/image.inc.php
    * \@global object $config konfiguracja
    */
    function record_info() {
        global $rec;
        global $image;
        global $config;
        global $wp_config;
        global $DOCUMENT_ROOT;
        global $_SESSION;
		
        if (in_array("pasaz.wp.pl",$config->plugins)) {
			include_once ("config/auto_config/wp_config.inc.php");
		}
       	// rejestracja w statystykach wp
        if(!empty($wp_config->wp_shop_id) && $_SESSION['global_partner_id'] == 47474747) { 
            print "<img src=\"http://zakupy.wp.pl/stat_view.html?sid=$wp_config->wp_shop_id\" width=\"1\" height=\"1\" border=\"0\">";
        }
		$file="info.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        
        return(0);
    } // end record_info()

    /**
    * Wyswietl pelna prezentacja rekordu
    *
    * \@global object $rec    dane produktu $rec->data
    * \@global object $image  obiekt klasy Image include/image.inc.php
    * \@global object $config konfiguracja
    */
    function record_info_options_only() {
        global $rec;
        global $image;
        global $config;
        global $wp_config;
        global $DOCUMENT_ROOT;
        global $_SESSION;
		
        if (in_array("pasaz.wp.pl",$config->plugins)) {
			include_once ("config/auto_config/wp_config.inc.php");
		}
       	// rejestracja w statystykach wp
        if(!empty($wp_config->wp_shop_id) && $_SESSION['global_partner_id'] == 47474747) { 
            print "<img src=\"http://zakupy.wp.pl/stat_view.html?sid=$wp_config->wp_shop_id\" width=\"1\" height=\"1\" border=\"0\">";
        }
        $file="require_options.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
        
        return(0);
    } // end record_info()

    
    /**
    * Punkty wyrazone w znakach np. gwiazdki np.: ***** funkcja wyswietla takze polowe gwiazdki :)
    *
    * @author piotrek@sote.pl rp@sote.pl m@sote.pl
    * @param int     $user_score ilosc znakow punkow
    * @param string  $img wyswietlany znak
    * @return none
    */
    function user_score($user_score,$img) {
        global $theme;
        
        $star=0;
        $half_star=0;
        $my_img=ereg_replace(".gif$","",$img);
        $img_half=$my_img."_half.gif";
        $before_point=ereg_replace("\..+$","",$user_score);
        
        // jezeli srednia ocena jest niepelna (wystepuje kropka)
        if (ereg("\.",$user_score)) {
            $before_point=ereg_replace("\..+$","",$user_score);  // dowiedz sie jaka jest liczba przed kropka
            $point=ereg_replace(".\.(.+$)","\\1",$user_score);   // dowiedz sie jaka jest liczba po kropce
            if (ereg("^[0-9]$",$point))  $point=$point."0";      // jesli po przecinku jest tylko jedna liczba dodaj do niej 0
            
            // jezeli liczba po kropce miescie sie w zakresie od 25 do 75
            if (($point>=25)&&($point<75)) {
                // dodaj pol gwiazdki
                $half_star=1;
                // jezeli liczba po kropce jest wieksza od 75
            } elseif($point>=75) {
                // dodaj cala gwiazdke
                $star=1;
            }
            
            
            if ($before_point>5) $before_point=5;
            if ($before_point>0) {
                // wyswietl tyle pelnych gwiazdek ile wskazuje before_point
                for ($i=0;$i<$before_point;$i++) {
                    print "<img src=\"";$this->img("_img/$img"); print "\" border=\"0\" alt=\"\" align=\"absmiddle\">";
                }
                if ($half_star==1) {
                    print "<img src=\"";$this->img("_img/$img_half"); print "\" border=\"0\" alt=\"\" align=\"absmiddle\">";                     // dodaje pol gwiazdki do zwracanego stringu $o
                } elseif ($star==1) {
                    print "<img src=\"";$this->img("_img/$img"); print "\" border=\"0\" alt=\"\" align=\"absmiddle\">";                           // dodaje cala gwiazdke do zwracanego stringu $o
                }
            }
        } else {
            // wyswietl normalna ilosc gwiazdek w zaleznosci od user_score
            if ($user_score>5) $user_score=5;
            if ($user_score>0) {
                for ($i=0;$i<$user_score;$i++) {
                    print "<img src=\"";$this->img("_img/$img"); print "\" border=\"0\" alt=\"\" align=\"absmiddle\">";
                }
            }
        }
        
        return;
    } // end user_score()
    
} // end class LocalTheme

$theme = new LocalTheme;
?>

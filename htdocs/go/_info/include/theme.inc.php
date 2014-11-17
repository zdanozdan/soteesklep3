<?php
/**
 * Dodatkowe funkcje klasy Theme
 * 
 * @author  m@sote.pl
 * @version $Id: theme.inc.php,v 2.3 2004/12/20 18:01:41 maroslaw Exp $
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

        global $DOCUMENT_ROOT;
        $file="info.html.php";
        include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");

        return(0);
    } // end record_info()

    /**
     * Punkty wyrazone w znakach np. gwiazdki np.: ***** funkcja wyswietla takze polowe gwiazdki :)
     *
     * \@modified_by piotrek@sote.pl
     * @param int     $user_score ilosc znakow punkow
     * @param string  $img wyswietlany znak
     * @return string HTML znaki gwiazek itp. wg. ilosci $user_score
     */
    function user_score($user_score,$img) {
        $o="";
        $star=0;
        $half_star=0;
        $my_img=ereg_replace(".gif$","",$img);
        $img_half=$my_img."half.png";
        $before_point=ereg_replace("\..+$","",$user_score);

        if (ereg("\.",$user_score)) {                            // jezeli srednia ocena jest niepelna (wystepuje kropka)
            
            $before_point=ereg_replace("\..+$","",$user_score);  // dowiedz sie jaka jest liczba przed kropka
            $point=ereg_replace(".\.(.+$)","\\1",$user_score);   // dowiedz sie jaka jest liczba po kropce
            if (ereg("^[0-9]$",$point))  $point=$point."0";      // jesli po przecinku jest tylko jedna liczba dodaj do niej 0
            
            if (($point>=25)&&($point<75)) {                     // jezeli liczba po kropce miescie sie w zakresie od 25 do 75   
                $half_star=1;                                    // dodaj pol gwiazdki 
            } elseif($point>=75) {                               // jezeli liczba po kropce jest wieksza od 75
                $star=1;                                         // dodaj cala gwiazdke 
            }
            
            if ($before_point>5) $before_point=5;
            if ($before_point>0) {
                for ($i=0;$i<$before_point;$i++) {               // wyswietl tyle pelnych gwiazdek ile wskazuje before_point               
                    $o.="<img src=$img border=0>";
                }
                
                if ($half_star==1) {
                    $o.="<img src=$img_half border=0>";          // dodaje pol gwiazdki do zwracanego stringu $o 
                } elseif ($star==1) {
                    $o.="<img src=$img border=0>";               // dodaje cala gwiazdke do zwracanego stringu $o
                }
                
                return $o;                                       // zwracam caly string
            }
            
        } else {                                                 // wyswietl normalna ilosc gwiazdek w zaleznosci od user_score   
            if ($user_score>5) $user_score=5;
            if ($user_score>0) {
                for ($i=0;$i<$user_score;$i++) {
                    $o.="<img src=$img border=0>";
                }
                //print "kod=$o<BR>";
                return $o;
            }
        } 
        
        return(0);
    } // end user_score()
    
} // end class LocalTheme

$theme = new LocalTheme;
?>

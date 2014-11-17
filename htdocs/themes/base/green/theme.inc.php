<?php
/**
* @version    $Id: theme.inc.php,v 1.2 2004/12/20 18:02:45 maroslaw Exp $
* @package    themes
* @subpackage green
*/
$config->base_theme="base_theme";
/**
 * Rozszerzona klasa Theme (Green)
 *
 * @author rp@sote.pl
 */
class MyTheme Extends Theme {	
	/**
	* kolory naglowkow
	* @var strign
	*/
    var $bg_bar_color="#499e4a";
   	/**
   	* kolor komorki nieparzystej w liscie skroconej (domyslna dla tego tematu "#499e4a")
   	* @var string
   	*/
    var $record_odd_color="#ffffff";
   	/**
   	* kolor komorki parzystej w liscie skroconej (domyslna dla tego tematu "#ffffff")
   	* @var string
   	*/
   	var $record_even_color="#DCEFDC";
    /**
    * glowne przyciski, generowane automatycznie
    * @var array
    */
    var $red=array(        
		"buttons"=>array(
		    "main.gif"=>"/",
		    "promocje.gif"=>"/go/_promotion/?column=promotion",
		    "nowosci.gif"=>"/go/_promotion/?column=newcol",
		    "ofirmie.gif"=>"/go/_files/?file=about_company.html",
		    "regulamin.gif"=>"/go/_files/?file=terms.html"
	    ),	    
	);
                                  
    /**
    * Funkcja generujca otwarcie ciala okienka z lewej lub prawej strony sklepu
    *    
    * @param  int        $width szerokosc tabeli w px
    *
    * @private
    * @return none
    */
    function win_body_open($width=180){
    	// pomniejsz szerokosc kolumny o szerokosc ramki    	
    	$cell_width=$width-2;
    	// generuj poczatek tabeli    	
    	print "<table width=\"".$width."\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    	print "  <tr>\n";
    	print "    <td width=\"1\" bgcolor=\"#536083\"><img alt=\"\" src=\"";
    	$this->img("_img/_mask.gif");
    	print "\" width=\"1\" height=\"1\"></td>\n";
    	print "    <td width=\"".$cell_width."\" bgcolor=\"#FFFFFF\" style=\"padding: 4px;\" align=\"left\">";
    	return (0);
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
    	/**
    	* generuj koniec tabeli
    	*/
    	print "</td>\n";    	
    	print "    <td width=\"1\" bgcolor=\"#536083\"><img alt=\"\" src=\"";
    	$this->img("_img/_mask.gif");
    	print "\" width=\"1\" height=\"1\"></td>\n";
    	print "  </tr>";
    	print "  </table>";
    	return(0);    	
    } // end win_body_close()
    
    /**
    * Funkcja generujca otwarcie okienka z lewej lub prawej strony sklepu
    *
    * @param  int    $width     szerokosc tabeli w px
    * @param  string $data      tekst do wyswietlenia jako nazwa naglowka
    * @param  int    $width     szerokosc tabeli
    * @param  int    $bar       generowac naglowek czy okno 1 - naglowek / 0 - tabela
    * @param  int    $open_body generowac otwarcie okienka czy sam bar 1 - okno / 0 - bar
    * @access public
    * @return none
    */
    function win_top($data='',$width=180,$bar=0,$open_body=1){    	
    	if($bar==1){
    		$img_file="bar";    		
    	} else {
    		$img_file="win";    		
    	}
    	// pomniejsz szerokosc kolumny o szerokosc naroznikow tabeli o ile nie wpisano wartosci w %
    	if (preg_match ("/(\%)$/", $width)) {
    		$cell_width="";
    		$open_body=0; // dla wartosc procentowych szerokosci mozna generowac tylko bar'y z tekstem
    	} else {
    		$cell_width=$width-30;
    	}    	
    	// szablon tabeli html    	
    	print "<table width=\"$width\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    	print "  <tr>\n";
    	print "    <td width=\"15\" align=\"left\" background=\"";
    	$this->img("_img/_bmp/headers/top_".$img_file."_center.gif");    	
    	print "\"><img alt=\"\" src=\"";
    	// wyswietl obrazek naroznika tabeli    	
    	$this->img("_img/_bmp/headers/top_".$img_file."_left.gif");
    	// generuj dalsza czesc tabeli    	
    	print "\" width=\"15\" height=\"16\"></td>\n";
    	print "    <td width=\"$cell_width\" background=\"";
    	// wyswietl tlo srodkowej kolumny
    	$this->img("_img/_bmp/headers/top_".$img_file."_center.gif");
    	// generuj dalsza czesc tabeli    	
    	print "\" align=\"center\" style=\"color: ";
    	if ($bar==1){
    		print "#ffffff";
    	} else {
    		print "#000000";
    	}
    	print "; font-weight: bold;\">";
    	// zmnienna $data do wyswietlenia przy uzyciu print    	
    	print $data;
    	// generuj dalsza czesc tabeli    	
    	print "</td>\n";
    	print "    <td width=\"15\" align=\"right\" background=\"";
    	$this->img("_img/_bmp/headers/top_".$img_file."_center.gif");    	
    	print "\"><img alt=\"\" src=\"";
    	// wyswietl obrazek naroznika tabeli    	
    	$this->img("_img/_bmp/headers/top_".$img_file."_right.gif");    
    	// generuj dalsza czesc tabeli    	
    	print "\" width=\"15\" height=\"16\"></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";    	
    	// jesli jest to otwarcie okna bez bara to dodaj cialo tabelki    	
    	if ($open_body==1){
    		$this->win_body_open($width);
    	}
    	return(0);
    } // end win_top()

    /**
    * Funkcja generujca zamkniecie okienka z lewej lub prawej strony sklepu
    *
    * @param int $width szerokosc tabeli w px
    */
    function win_bottom($width=180){
    	// zamknij cialo tabelki    	
    	$this->win_body_close();    	
    	// pomniejsz szerokosc kolumny o szerokosc naroznikow tabeli    	
    	$cell_width=$width-30;
    	// szablon tabeli html    	
    	print "<table width=\"$width\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    	print "  <tr>\n";
    	print "    <td width=\"15\"><img alt=\"\" src=\"";
    	// wyswietl obrazek naroznika tabeli    	
    	$this->img("_img/_bmp/headers/bottom_win_left.gif");
    	// generuj dalsza czesc tabeli    	
    	print "\" width=\"15\" height=\"15\"></td>\n";
    	print "    <td width=\"$cell_width\" background=\"";
    	// wyswietl tlo srodkowej kolumny
    	$this->img("_img/_bmp/headers/bottom_win_center.gif");
    	// generuj dalsza czesc tabeli
    	print "\" align=\"center\" style=\"color: #FFFFFF; font-weight: bold;\">&nbsp;</td>\n";
    	print "    <td width=\"15\"><img alt=\"\" src=\"";
    	// wyswietl obrazek naroznika tabeli    	
    	$this->img("_img/_bmp/headers/bottom_win_right.gif");
    	// generuj dalsza czesc tabeli    	
    	print "\" width=\"15\" height=\"15\"></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";
    } // end win_bottom()    

}
$theme = new MyTheme;
?>

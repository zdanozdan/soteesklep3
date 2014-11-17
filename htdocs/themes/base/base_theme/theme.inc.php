<?php
/**
* nazwa tematu bazowego z ktorego pobierane beda pliki,
* ktorych nie bedzie w katalogu z aktualnym tematem
* @var string
* @version    $Id: theme.inc.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

$config->base_theme="base_theme";

/**
* Rozszerzona klasa Theme (Base_Theme)
*
* @author rp@sote.pl
*/
class MyTheme Extends Theme {
	
	/**
	* kolor naglowkow
	* @var string
	*/	
    var $bg_bar_color="#6699CC";
    /**
	* kolor komorki nieparzystej w liscie skroconej (domyslna "#ffffff")
	* @var string
	*/
    var $record_odd_color="#ffffff";
    /**
	* kolor komorki parzystej w liscie skroconej (domyslna "#E9F0F8")
	* @var string
	*/
    var $record_even_color="#E9F0F8";
        
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
    	print "<table width=\"$width\" border=\"0\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
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
    		print $config->theme_config['colors']['header_font'];
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

    	print "<table width=\"$width\" border=\"0\" cellspacing=\"0\" bgcolor=\"" . $config->theme_config['colors']['box_background'] . "\" cellpadding=\"0\" align=\"center\">\n";
    	print "  <tr>\n";
    	print "    <td ><img alt=\"\" src=\"";
    	$this->img($left);
    	print "\" ></td>\n";
    	print "    <td width=\"100%\" background=\"";
    	$this->img($center);
    	print "\" align=\"center\" style=\"color: '" . $config->theme_config['colors']['header_font'] . "'; font-weight: bold;\"></td>\n";
    	print "    <td ><img alt=\"\" src=\"";
    	$this->img($right);
    	print "\" ></td>\n";
    	print "  </tr>\n";
    	print "</table>\n";
    	
    	return;
    } // end win_bottom()    
}
$theme = new MyTheme;
?>

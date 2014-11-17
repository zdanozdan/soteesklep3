<?php
/**
 * Losowe wstawianie zdjec ze wskazanego katalogu.
* @version    $Id: random_images.inc.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
 */
class RandomImages {
    var $rand_dir='/themes/_pl/standard/_img_frx/rand_img';
    var $rand_regexp='.jpg$';         // wyrezenie regularne doposaowanie plikow
    var $images=array();              // lista zdjec
    
    /**
     * Odczytaj liste zdjec i zapamietaj je w tablicy $this->images
     */
    function read_dir(){
        global $DOCUMENT_ROOT;
	
        $d = dir($DOCUMENT_ROOT.$this->rand_dir);
	while (false !== ($entry = $d->read())) {
	   if (ereg($this->rand_regexp,$entry)) {
	       array_push($this->images,$entry);
	   }
	}
	$d->close();				
	return; 
    } // end read_dir()
    
    /**
     * Wylosuj zdjecie i wyswietl je.
     */
    function show() {
	$this->read_dir();    
	$max=sizeof($this->images);
	if ($max>0) {
	    $random=rand(0,$max-1);
	    $image=$this->images[$random];
	    print "<img src=$this->rand_dir/$image>";
	} 
	return;
    } // end show()
    
} // end class randomImages

$rand_img = new RandomImages;
?>

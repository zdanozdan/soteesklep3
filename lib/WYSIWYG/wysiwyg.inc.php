<?php
/**
* Edytor HTML w trybie WYSIWYG
*
* Edytor tekstu HTML - umo¿liwia edycjê tekstu HTML w trybie WYSIWYG - widaæ od razu wygl±d docelowego pliku HTML
*
* Przeznaczone dla nowszych przegl±darek Mozilla lub IE.
* @author  lech@sote.pl
* @version $Id: wysiwyg.inc.php,v 1.6 2004/10/02 17:21:15 maroslaw Exp $
* @package wysiwyg
*/


/**
* Sta³a oznaczaj±ca w³±czenie obs³ugi WYSIWYG
*/
define ("WYSIWYG_ENABLED", 1);
/**
* Sta³a oznaczaj±ca wy³±czenie obs³ugi WYSIWYG
*/
define ("WYSIWYG_DISABLED", 0);


$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Sciezka wzglednego dostepu do kodu HTML i JS edytora
*/
define ("WYSIWYG_INCLUDE","WYSIWYG/include/");

/**
* ¦cie¿ka URL do katalogu include WYSIWYG
*/
define ("WYSIWYG_INCLUDE_URL","/lib/WYSIWYG/include/");
/*
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
*/
/**
* Glowna klasa realizujaca edycje w trybie WYSIWYG
* @package wysiwyg
*/
class Wysiwyg {
	
	/**
	* Pole z nazwa jezyka
	*
	* Wszelkie komunikaty, nazwy i opisy pojawiaja sie w jezyku ustalonym w tym polu
	*/
	var $lang;
	
	/**
	* Tablica dozwolonych nazw jezykow
	*
	* Tablica zawiera nazwy wszystkich dozwolonych w edytorze jezykow
	*/
	var $languages=array("pl","en");
	
	var $words=array(
		"pl"=> array(
				"submit"=>"Zatwierd¼",
				"insert_html"=>"Wstaw HTML",
				"highlight_text"=>"Pod¶wietl tekst"
			),
		"en"=> array(
				"submit"=>"Submit",
				"insert_html"=>"insert html",
				"highlight_text"=>"highlight text"
			)
	);

	/**
	* Konstruktor
	*
	* Weryfikowana jest podana nazwa jezyka (domyslnie 'pl') i w razie dopasowania jej
	* do ktorejs pozycji z dopuszczalnych jezykow (zdefiniowanych w tablicy 'languages'),
	* inicjowany jest odpowiedni jezyk
	*
	* @param string $lang Wybor jezyka
	*/
	function Wysiwyg($lang = 'pl'){
		global $DOCUMENT_ROOT;
		$lang = strtolower($lang);
		if(!in_array($lang, $this->languages))
			$lang = 'pl';
		$this->lang = $lang;
		
	}
	
	function _prepareIncludePath($path){
		
	}
	
	/**
	* Funkcja wyslwietla strone z edytorem
	*
	* @param string $html Wejsciowa tresc HTML podlegajaca edycji
	* @param string $var_name Nazwa zmiennej, ktora po wyslaniu formularza zawierac bedzie nowa tresc pliku HTML
	* @param string $action Cel, do ktorego przeslany zostanie formularz po wykonaniu SUBMIT
	* @param string $dir_photo Sciezka do katalogu z fotografiami dostepnymi do tworzonego HTML-a
	*/
	function Editor($html, $var_name, $action, $dir_photo = '') {
		$html = $this->_prepareHTML($html);
		include(WYSIWYG_INCLUDE."body.html");
	} // end WysiwygEditor()

	
	/**
	* Funkcja przystosowuje wej¶ciowy html do edytora, tzn. 
	* zamienia "&" na "&amp;", "<" na "&lt;" i ">" na "&gt;" 
	*
	* @author lech@sote.pl
	* @access private
	* @param string $html Wej¶ciowy HTML
	* @return string
	*/
	function _prepareHTML($html) {
		$html = str_replace('&', '&amp;', $html);
		$html = str_replace('<', '&lt;', $html);
		$html = str_replace('>', '&gt;', $html);
		return $html;
	} // end _prepareHTML()
	
} // end class Wysiwyg

// UWAGA!  na koncu nie moze byc zadnych znakow po zamknieciu PHP
?>
<?php
//ini_set("include_path","/var/www/testy/lib/:.");

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

require_once ("../../../include/head.inc");
error_reporting(E_ALL);
require_once("File/Archive.php");
/**
 * Klasa obs³uguj±ca File/Archive i sprawiaj±ca ¿e tworzenie plików archiwum 
 * staje siê procesem jedoetapowym
 *
 * @author  £ukasz Andrzejak
 * @todo  dodac obsluge rozpakowywania
 * dodatkowe parametry kompresji
 */
class  packer {
	
	/**
	 * ¬ród³o
	 *
	 * @var mixed
	 */
	var $source;

	/**
	 * Domy¶lne rozszerzenie pliku archiwum
	 *
	 * @var string
	 */
	var $default_type = ".gz";
	
	
	/**
	 * Docelowa nazwa pliku
	 *
	 * @var string
	 */
	var $_dest;
	
	/**
	 * Zmienna zawieraj±ca readera
	 *
	 * @var File_Archive::reader
	 */
	var $reader;
	
	/**
	 * Konstruktor
	 *
	 * @param multi $pliki_do_spakowania
	 * @return packer
	 */
	function packer($source)
	{
		$this->source = $source;
	}
	
	function __check_for_errors() 
	{
		if (is_array($this->reader->stat)) {
			return false;
		} else {
			print "Error while creating file<br />\n";
			return true;
		}
	}
	
	/**
	 * Tworzymy zmienn± zawieraj±c± readera - czyli strukture danych odczytywanych i docelowo zapisywanych w archiwum
	 *
	 * @param string $dest
	 */
	function _create_reader($dest)
	{
		//fallback
		$this->_dest = $dest; 
		// je¿eli dostajemy tablice elementów to przetwarzamy na multi
		if (is_array($this->source)) { 
			foreach ($this->source as $item=>$val) {
				$this->reader[] = File_Archive::read($val,$item);
				if (!file_exists($item)) {
					die ('File does not exist!'.$item);
				}
			}
			// ustawiamy nazwe docelowego pliku archiwum
			if (empty($dest)) { 
				$dest = array_keys($this->source);
				$this->_dest = $dest[0].$this->default_type;
			}
		} else {
			$this->reader = File_Archive::read($this->source);
			if (!file_exists($this->source)) {
					die ('File does not exist!'.$this->source);
				}
			if (empty($dest)) {
				$this->_dest = $this->source.$this->default_type;
			}
		}
	}
	
	/**
	 * Pakujemy pliki do plików
	 *
	 * @param string $nazwa_docelowa
	 */
	function toFile ($dest = '')
	{
		$this->_create_reader($dest);
		File_Archive::extract(
			$this->reader,
			File_Archive::toArchive(
				$this->_dest,
				File_Archive::toFiles()
			)
		);
		$this->__check_for_errors();
	}
	
	/**
	 * Pakujemy pliki do zmiennej
	 *
	 * @param variable $zmienna
	 */
	function toVar (&$var,$dest = '')
	{
		$this->_create_reader($dest);
		File_Archive::extract(
			$this->reader,
			File_Archive::toArchive(
				$this->_dest,
				File_Archive::toVariable($var)
			)
		);
	}
	
	/**
	 * Pakujemy pliki do standardowego wyj¶cia przegl±darki (download)
	 *
	 * @param string $nazwa_docelowa
	 */
	function toOut ($dest = '')
	{
		$this->_create_reader($dest);
		File_Archive::extract(
			$this->reader,
			File_Archive::toArchive(
				$this->_dest,
				File_Archive::toOutput()
			)
		);
	}
			
}
print "Kompresuje...<br>";
$archive = new packer("index.php");
$archive->toVar($out);
print "Done<br>";
//print filesize('test.tar.gz')."/".filesize('packme.file')."<br>";
print "Przed/Po spakowaniu ".filesize('index.php')."/".strlen($out)."<br>";


include_once ("include/foot.inc");

?>
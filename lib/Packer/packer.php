<?php
/**
* Klasa obs?uguj?ca File/Archive i sprawiaj?ca ?e tworzenie plików archiwum
* staje si? procesem jedoetapowym
*
* @author  £ukasz Andrzejak
* @version $Id: packer.php,v 1.2 2005/12/21 11:44:41 lukasz Exp $
* @package lib
* @subpackage packer
*/

/**
* Obs³uga GZIP z PEAR
*/
require_once("File/Archive.php");
require_once("Packer/archive.php");
/**
* Klasa obs³uguj±ca File/Archive i sprawiaj±ca ¿e tworzenie plików archiwum
* staje siê procesem jedoetapowym
* dodatkowe parametry kompresji
* Dodatkowo mo¿liwo¶æ rozpakowywania plików tar.gz, tgz
* 
*/
class  Packer extends archive {

	/**
     * ?ród?o
     *
     * @var mixed
     */
	var $source;

	/**
     * Domy?lne rozszerzenie pliku archiwum
     *
     * @var string
     */
	var $default_type = ".gz";

	function packer($source)
	{
		$this->source = $source;
	}

	/**
     * Docelowa nazwa pliku
     *
     * @var string
     */
	var $_dest;

	/**
     * Zmienna zawieraj?ca readera
     *
     * @var File_Archive::reader
     */
	var $reader;

	/**
     * Array nazw plików które utworzono i tych ich odpowiedników przed rozpakowaniem.
     * Format danych to [nazwa_utworzonego_pliku]=>katalog/katalog/plik 
     *
     * @var array
     */
	var $filestruct;

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
     * Tworzymy zmienn? zawieraj?c? readera - czyli strukture danych odczytywanych i docelowo zapisywanych w archiwum
     *
     * @param unknown_type $dest
     */
	function _create_reader($dest)
	{

		$this->_dest = $dest; //fallback
		// je?eli dostajemy tablice elementów to przetwarzamy na multi

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
     * @param destination $filename
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
     * Pakujemy pliki do standardowego wyj?cia przegl?darki (download)
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

	/**
     * Rozpakuj plik z konstruktora do katalogu $dest, nadaj±c plikom przedrostek $prefix
     * Pliki s± rozpakowywane bez zachowania struktury katalogów, ta struktura jest zapisana w nazwie pliku
     * katalog1_katalog2_plik.txt
     * oraz w zmiennej obiektu zwracanej z metody.
     * Ta zmienna to $filestruct
     * Format danych to [nazwa_utworzonego_pliku]=>katalog/katalog/plik 
     *
     * @param string $dest
     * @param string $prefix
     * @return array $filestructure
     */
	function unpack($dest= '', $prefix='upgrade_') {
		global $DOCUMENT_ROOT;
		if (empty($dest)) {
			$dest= "$DOCUMENT_ROOT/tmp/";
		}
		$file=new gzip_file($this->source);
		$file->set_options(array('inmemory'=>0,'basedir'=>$dest));
		$file->extract_files(true,$prefix);
		$this->filestruct=$file->filestruct;
		return $this->filestruct;
	}

}

/*
* example
print "Kompresuje...<br>";
$archive = new packer("1.jpg");
$archive->toFile('plik1.jpg.gz');
print "Done<br>";

upacking:
print "Rozpakowuje: <br>";
$archive = new packer("plik.tgz");
$archive->unpack('','test_');
print_r ($archive->filestruct);

show_source('index.php');
safe_mode problems -> edit -> File/Archive/Writer/$type
$this->tmpName = tempname("$DOCUMENT_ROOT/tmp/","far");
*/
?> 
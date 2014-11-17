<?php
/**
* Klasa obs³uguj±ca modyfikacjê pliku
*
* @author  m@sote.pl
* @version $Id: ModFiles.php,v 1.2 2005/04/01 12:18:55 maroslaw Exp $
* @package tools
*/

/**
* Klasa obs³uguj±ca modyfikacjê pliku
* @package tools
*/
class ST_ModFiles {

    /**
    * @var string $file_source ¼ród³o pliku
    */
    var $source='';

    /**
    * @var array tablica ze ¼ród³ami pliku, ka¿da linia jako osobny wpis w tablicy
    */
    var $source_tab=array();

    /**
    * @var bool Czy jest komentarz nag³ówkowy w pliku
    */
    var $_headComment=false;

    /**
    * @var array tablica z liniami odpowiadaj±cymi nag³ówkowi (komantarzowi)
    */
    var $_headCommentTab=array();

    /**
    * @var int numer wiersza (licz±c od 0) w którym jest koniec komentarza nag³ówkowego
    */
    var $_headEndLine=0;

    /**
    * @var array talica z liniami nag³ówka
    */
    var $_codeHead=array();

    /**
    * @var array talica z liniami czê¶ci bazowej pliku (poza nag³ówkiem)
    */
    var $_codeBody=array();

    /**
    * @var array tablica z nowymi liniami , po zmianach
    */
    var $newSource_tab=array();

    /**
    * @var string zawarto¶æ pliku po zmianach
    */
    var $newSource='';

    /**
    * Konstruktor
    */
    function ST_ModFiles($file_source='') {
        $this->source=trim($file_source);
        $this->source_tab=split("\n",$this->source);
        $this->_headComment=$this->_checkHeadComment();
        return;
    } // end ST_ModFiles()

    /**
    * Zmieñ okre¶lone w parametrze warto¶ci, translacja postaci klucz=>warto¶æ
    */
    function replace($data) {
        if (! empty($this->newSource)) $source=$this->newSource;
        else $source=$this->source;
        reset($data);
        foreach ($data as $key=>$val) {
            $source=preg_replace("/$key/",$val,$source);
        }
        if (! empty($this->newSource)) $this->newSource=$source;
        return;
    } // end replace()

    /**
    * Sprawd¼ czy w pliku jest komentarz nag³ówkowy, zapamiêtaj nag³ówek
    *
    * @access private
    * @return bool
    */
    function _checkHeadComment() {
        if (ereg("\/\*\*",$this->source_tab[1])) {
            reset($this->source_tab);$i=0;
            foreach ($this->source_tab as $line) {
                if (! ereg("\*\/",$line)) {
                    $this->_headCommentTab[]=$line;
                } else {
                    $this->_headCommentTab[]="*/\n";
                    $this->_headEndLine=$i; // zapamiêtaj ostatnia liniê komentarza nag³ówkowego
                    return true;
                }
                $i++;
            }
        }
        return false;
    } // end _checkHeadComment

    /**
    * Dodaj wpisy do nag³ówka, nadpisz istniej±ce
    *
    * @param array $data "oznaczenie elementu phpdoc"=>"wartosc" np. array("@package"=>"basket")
    */
    function setHeadComment($data) {
        // print_r($this->_headCommentTab);
        // print_r($this->_headEndLine);
        // print "\n";

        // podziel nag³ówek i resztê kodu
        if ($this->_headEndLine==0) {
            $this->_codeHead=array();
            $this->_codeBody=$this->source_tab;
        } else {
            reset($this->source_tab);$i=0;
            foreach ($this->source_tab as $line) {
                if ($i<=$this->_headEndLine) {
                    // wytnij @package i @subpackage
                    if ((! ereg("@package",$line)) && (! ereg("@subpackage",$line))) {
                        $this->_codeHead[]=$line;
                        $last_head_line=$i;
                    }
                } else {
                    $this->_codeBody[]=$line;
                } // end if
                $i++;
                print "line=$line \n";
            } // end foreach
        } // end if

        //print_r($this->_codeHead);

        // dodaj nag³ówek
        if (empty($this->_codeHead)) {
            if (eregi("^\<\?php",$this->_codeBody[0])) {
                unset($this->_codeBody[0]);
                $this->_codeHead[]="<?php";
                $this->_codeHead[]="/**";
                $this->_codeHead[]="*/";
            } else {
                $this->_codeHead[]="<?php";
                $this->_codeHead[]="/**";
                $this->_codeHead[]="*/";
                $this->_codeHead[]="?>";
            }
        }

        //print_r($this->_codeHead);

        // przejrzyj nag³ówek i dodaj odpowiednie wpisy na koñcu komentarza
        reset($this->_codeHead);$newHead=array();
        foreach ($this->_codeHead as $line) {
            if (ereg("\*\/",$line)) {
                if (! ereg("\@version",$this->source)) $newHead[]="* @version    \$Id\$";
                if (! empty($data['package']))         $newHead[]="* @package    ".$data['package'];
                if (! empty($data['subpackage']))      $newHead[]="* @subpackage ".$data['subpackage'];
            }
            $newHead[]=$line;
        }
        $this->_codeHead=$newHead;

        // z³ó¿ ca³y plik
        $newFileSource=array();
        reset($this->_codeHead);
        foreach ($this->_codeHead as $line) {
            $newFileSource[]=$line;
        }
        reset($this->_codeBody);
        foreach ($this->_codeBody as $line) {
            $newFileSource[]=$line;
        }

        //print_r($newFileSource);
                
        $this->newSource='';
        reset($newFileSource);
        foreach ($newFileSource as $line) {
            $this->newSource.=$line."\n";
        }
        trim($this->newSource);
        return;
    } // end setHeadComment()

    /**
    * Poka¿ aktualny plik (po zmianach)
    */
    function show() {
        if (! empty($this->newSource)) print $this->newSource;
        else print $this->source;
        return;
    } // end show()

} // end ST_ModFiles
?>
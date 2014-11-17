<?php
/**
* Parser HTML, formatowanie kodu HTML
* 
* @author  m@sote.pl lech@sote.pl
* @version $Id: parserHTML.php,v 1.3 2004/06/04 12:27:26 lechu Exp $
* @package lib
* @subpackege ParserHTML
*/

/**
* Parser HTML
* @package lib
* @subpackage ParserHTML
*/
class ParserHTML {
    
    /*
    * Tabliza znaczników nie posiadaj±cych znaczników zamykaj±cych
    */
    var $noCloseTags = array('br', 'hr');
    
    /**
    * Stos znaczników HTML
    *
    * Stos gromadz±cy analizowane kolejno znaczniki HTML. Pojedynczym elementem stosu
    * jest tablica o dwóch elementach:
    * <ul>
    *   <li>name - nazwa znacznika,</li>
    *   <li>indent - wciêcie znacznika w tek¶cie HTML
    * </ul>
    *
    */
    var $tagStack = array();
    
    /**
    * Podzia³ tekstu na linie
    *
    * Funkcja dzieli wej¶ciowy ³añcuch na linie w taki sposób, ¿e pojedyncza linia jest
    * albo samodzielnym znacznikiem (otwieraj±cym lub zamykaj±cym) albo lini± tekstu
    * nie bêd±cego znacznikiem HTML
    *
    * @param string $line tekst HTML
    *
    * @access private
    * @return string podzielony na linie tekst HTML
    */
    function _splitToLines($html){
        $html = str_replace("\r\n", ' ', $html);
        $html = str_replace("\n", ' ', $html);
        $html = str_replace('>', ">\n", $html);
        $html = str_replace('<', "\n<", $html);
        $lines = explode("\n", $html);
        for($i = 0; $i < count($lines); $i++){
            $lines[$i] = trim($lines[$i]);
        }
        $html = implode("\n", $lines);
        $html = str_replace("\n\n", "\n", $html);
        return $html;
    } // end _splitToLines()
    
    /**
    * Analiza linii tekstu
    *
    * Funkcja sprawdza, czy dana linia tekstu jest znacznikiem, a je¶li tak,
    * to ustala jaki to znacznik i czy jest on otwieraj±cy, czy zamykaj±cy
    *
    * @param array $line wiersz tekstu 
    *
    * @access private
    * @return array Zwrócona tablica ma nastêpuj±ce pola:
    * <ul>
    *   <li>tag: warto¶æ 0 oznacza, ¿e wej¶ciowa linia tekstu nie jest znacznikiem,
    *   warto¶æ 1 oznacza, ¿e jest znacznikiem (wówczas obecne s± pozosta³e pola tablicy),</li>
    *   <li>close: warto¶æ 0 - znacznik jest otwieraj±cy, 1 - znacznik jest zamykaj±cy,</li>
    *   <li>name: nazwa znacznika</li>
    * </ul>
    */
    function _parseLine($line){
        $result = array();
        $line = trim($line);
        if(substr($line, 0, 1) != '<'){
            $result['tag'] = 0;
            return $result;
        }
        else{
            $result['tag'] = 1;
            $tag_name = substr($line, 1, -1);
            $tag_name = trim($tag_name);
            if(substr($tag_name, 0, 1) == '/'){
                $result['close'] = 1;
                $tag_name = substr($tag_name, 1);
            }
            else
                $result['close'] = 0;
            $ar = explode(' ', $tag_name);
            $tag_name = $ar[0];
            $ar = explode("\t", $tag_name);
            $tag_name = strtolower($ar[0]);
            $result['name'] = $tag_name;
            return $result;
        }
    } // end _parseLine()
    
    /**
    * Tworzenie wciêcia
    *
    * Funkcja tworzy wciêcie linii tekstu
    *
    * @param int $count g³êboko¶æ wciecia
    * @param string $tab ³añcuch znaków, który zostanie powielony razy g³êboko¶æ wciêcia
    *
    * @access private
    * @return string wciêcie
    */
    function _indents($count, $tab){
        $indent = '';
        for($i = 0; $i < $count; $i++){
            $indent = $indent . $tab;
        }
        return $indent;
    } // end _indents()
    
    /**
    * Zdjêcie elementów ze stosu
    *
    * Funkcja usuwa z wierzchu stosu elementy tak d³ugo, a¿ nie natrafi na element,
    * którego pole "name" równa siê wej¶ciowemu parametrowi $tagname. Je¿eli taki element nie
    * zostanie znaleziony, stos pozostaje bez zmian.
    *
    * @param string $tagname nazwa znacznika, który zostanie usuniêty ze stosu
    *
    * @access private
    * @return int g³êboko¶æ wciêcia usuniêtego ze stosu znacznika HTML
    */
    function _takeTagFromStack($tagname){
        $count = count($this->tagStack);
        $index = $count;
        $i = $count - 1;
        $indent = -1;
        while(($i >= 0) && ($indent == -1)){
            if($this->tagStack[$i]['name'] == $tagname){
                $indent = $this->tagStack[$i]['indent'];
                $index = $i;
            }
            $i--;
        }
        for ($i = $index; $i < $count; $i++){
            unset($this->tagStack[count($this->tagStack) - 1]);
        }
        return $indent;
    } // end _takeTagFromStack()

    /**
    * Wstawienie wciêæ w tekst HTML
    *
    * Funkcja analizuje kolejno linie tekstu. Po natrafieniu na znacznik otwieraj±cy
    * wstawia na stos tagStack element z nazw± tego znacznika i ustalonej dla niego g³êboko¶ci
    * wciêcia. Inkrementowany zostaje licznik tabulatorów i kolejna linia bêdzie mia³a
    * ju¿ g³êbsze wciêcie.
    * Po natrafieniu na znacznik zamykaj±cy, wywo³ywana jest funkcja _takeTagFromStack
    * z nazw± tego znacznika w parametrze wej¶ciowym. Dziêki temu, stos jest pomniejszany
    * a¿ do pozycji z elementem odpowiadaj±cym znacznikowi otwieraj±cemu o tej nazwie
    * i zwracana jest g³êboko¶æ wciêcia dla tego znacznika. Na tej podstawie ustalana jest
    * g³êboko¶æ wciêcia analizowanego znacznika zamykaj±cego, bez troski o zawarto¶æ tekstu
    * miêdzy nim, a odpowiadaj±cemu mu znacznikowi otwieraj±cemu.
    *
    * @param string $html tekst HTML bez wciêæ
    *
    * @access private
    * @return string tekst HTML z ostatecznie sformatowanymi wciêciami
    */
    function _indentHTML($html){
        $tab = '    ';
        $indent = 0;
        $lines = explode("\n", $html);
        for($i = 0; $i < count($lines); $i++){
            $line_desc = array();
            $line_desc = $this->_parseLine($lines[$i]);
            
            if(@$line_desc['close'] == 1){
                $tag_array[$line_desc['name']]['closed'] = 0;
                $indent_ = $this->_takeTagFromStack($line_desc['name']);
                if($indent_ >= 0)
                    $indent = $indent_;
            }
            $lines[$i] = $this->_indents($indent, $tab) . $lines[$i];
            if(($line_desc['tag'] == 1) && (@$line_desc['close'] == 0) && (!in_array(@$line_desc['name'], $this->noCloseTags))){
                $stackelement = array();
                $stackelement['name'] = $line_desc['name'];
                $stackelement['indent'] = $indent;
                $this->tagStack[count($this->tagStack)] = $stackelement;
                $indent++;
            }
        }
        $html = implode("\n", $lines);
        return $html;
    } // end _indentHTML()

    /**
    * Formatowanie tekstu THML
    *
    * @param string $html tekst HTML do sformatowania
    *
    * @return string sformatowany tekst HTML
    */
    function parse($html){
        $html = $this->_splitToLines($html);
        $html = $this->_indentHTML($html);
        return $html;
    } // end parse()
    
} // end class ParserHTML 
?>
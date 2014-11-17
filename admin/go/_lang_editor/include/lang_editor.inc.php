<?php
/**
* Edycja wersji jêzykowych
*
* Modu³ umo¿liwiaj±cy edycjê definicji zmiennych jêzykowych porozmieszczanych w plikach
* lang.inc.php w ró¿nych miejscach w hierarchii katalogów (w poddrzewie katalogu htdocs).
* Wymagania wstêpne:
* <ul>
*   <li>plik ze ¶cie¿kami do WSZYSTKICH plików z definicjami jêzykowymi - patrz opis
*   kostruktora klasy LangEditor</li>
*   <li>obecno¶æ tabeli "lang" w bazie danych - odpowiednie zapytanie mo¿na otrzymaæ
*   poprzez wylistowanie wyniku wywo³ania metody prepareInsertQuery() na rzecz stworzonego
*   obiektu klasy LangEditor</li>
* </ul>
* Cykl pracy modu³u jest nastêpuj±cy:
* <ol>
*   <li>wygenerowanie formularza do wyszukiwania zmiennych</li>
*   <li>odczytanie wprowadzonych przez u¿ytkownika kryteriów poszukiwanych zmiennych</li>
*   <li>odnalezienie w bazie danych wszystkich lokalizacji plików, które zawieraj±
*   po¿±dane zmienne i dla ka¿dej z tych lokalizacji:
*       <ul>
*           <li>sczytanie wszystkich zmiennych z plików wszystkich dostêpnych wersji
*           jêzykowych wskazywanych przez bie¿±c± lokalizacjê</li>
*           <li>selekcja tylko tych zmiennych, które spe³niaj± kryteria wyszukiwania</li>
*           <li>wydrukowanie formularza edycji zmiennej w jej wszystkich wersjach jêzykowych</li>
*       </ul>
*   </li>
*   <li>przyjêcie nowych warto¶ci zmiennej z formularza edycji</li>
*   <li>aktualizacja danych w bazie</li>
*   <li>aktualizacja danych w plikach</li>
* </ol>
* @author  lech@sote.pl
* @version $Id: lang_editor.inc.php,v 1.23 2005/11/07 09:47:42 lechu Exp $
* @package    lang_editor
* \@lang
* \@encoding
*/


/**
* @ignore
* @package lang_editor
*/
class LangTmp {};

/**
* Edycja wersji jêzykowych
*
* Klasa implementuje metody aktualizacji wersji jêzykowych we wszystkichplikach "lang"
* w katalogu htdocs i g³êbiej
* @package lang_editor
*/
class LangEditor{
    
    /**
    * Tablica plików z definicjami jêzyków
    *
    * Tablica zawiera listê elementów tablicowych: element posiada dwa pola:
    * <ul>
    *   <li>location - tablica, której klucze to skrótowe nazwy jêzyków,
    *       a warto¶ci - lokalizacje plików,</li>
    *   <li>group - nazwa modu³u (grupy), do którego nale¿± zmienne definiowane przez plik</li>
    * </ul>
    * Tablica inicjowana jest przez konstruktor.
    */
    var $fileArray;
    
    /**
    * Tablica dostêpnych jêzyków
    *
    * Ka¿dy element tablicy to skrótowa nazwa jêzyka, np. "en", "pl", "de" itp.
    * Inicjacja przez konstruktor (domy¶lne warto¶ci to: "pl", "en", "de").
    */
    var $languages;
    
    var $encoding;

    var $base_lang = "pl";
    
    /**
    * Tablica modu³ów (grup) systemu, w których mog± byæ pliki z definicjami jêzyków
    *
    * Modu³y s± tu rozumiane jako jednostki systemu porozmieszczane w katalogach
    * "go" lub "plugins" w podkatalogach, których nazwa zaczyna siê od znaku "_".
    * Nazw± modu³u jest nazwa takiego podkatalogu, ale bez znaku "_".
    * Jeden z modu³ów nazywa siê "main": gromadzi on zmienne jêzykowe znajduj±ce siê
    * w globalnych plikach jêzykowych (czyli htdocs/lang/).
    * Inicjacja przez konstruktor.
    */
    var $groups = array();
    
    /**
    * ¦cie¿ka do katalogu tymczasowego
    *
    * ¦cie¿ka do katalogu tymczasowego, do którego kopiowane s± tymczasowo pliki
    * z definicjami jêzykowymi.
    */
    var $temp_dir;
    
    /**
    * Tablica ze zmiennymi z aktualnie wczytanego pliku
    *
    * Tablica zawiera nazwy i warto¶ci zmiennych z aktualnie analizowanego pliku
    * z definicjami jêzykowymi. Klucz pojedynczego elementu to nazwa zdefiniowanej
    * zmiennej. Struktura pojedynczego elementu tablicy to tablica zawieraj±ca
    * nastêpuj±ce pola:
    * <ul>
    * <li>value - tablica, której klucze to skrótowe nazwy jêzyków,
    *     a warto¶ci - warto¶ci zmiennych</li>
    * <li>group - modu³ (grupa), do której nale¿y zmienna: w wiêkszo¶ci przypadków pole to
    * zdeterminowane jest przez plik, z którego pochodzi zmienna, jednak w przypadku
    * zmiennych z g³ównego pliku jêzykowego s± one b±d¼ przypisywane do grupy "main",
    * b±d¼ do innej grupy, je¶li nazwa tej grupy pokrywa siê z pocz±tkiem nazwy zmiennej</li>
    * <li>location  - tablica, której klucze to skrótowe nazwy jêzyków,
    *     a warto¶ci - lokalizacje plików, w których zdefiniowane s± zmienne</li>
    * </ul>
    * Inicjalizacja przez konstruktor.
    */
    var $currentVars = array();
    
    /**
    * @var string plik zawieraj±cy listê z lokalizacjami plików lang.inc.php (wzglêdem $DOCUMENT_ROOT)
    */
    var $lang_list_file="admin/go/_lang_editor/config/lang_files.txt";
    
    
    /**
    * @var string Okre¶lenie, czy edycja dotyczy plików lang po stronie panelu
    * admina, czy po stronie sklepu
    */
    var $part = 'htdocs';
    
    var $trash = array();
    
    /**
    * @var string Niepusta warto¶æ wskazuje nazwê jêzyka, dla którego ma byæ wygenerowany raport dla t³umacza
    */
    var $lang_to_report = '';
    
    /**
    * @var array Tablica z raportem o formacie $report['sciezka_do_pliku']['nazwa_zmiennej'] = 'wartosc'
    */
    var $report = array();
    
    var $md5_array = array();
    
    /**
    * Konstruktor klasy
    *
    * Konstruktor inicjuje pola klasy.
    *
    * @param string $langs Lista skrótowych nazw jêzyków podanych po przecinku.
    *                      Domy¶lna warto¶æ parametru: "pl, en, de" .
    * @param string $lang_list_file ¦cie¿ka do pliku zawieraj±cego ¶cie¿ki do
    *                               wszystkich plików z POLSKIMI definicjami jêzykowymi.
    *                               Nale¿y podaæ ¶cie¿kê wzglêdem DOCUMENT_ROOT.
    *                               Przyk³ad poprawnej
    *                               pojedynczej lini pliku: ./htdocs/go/_contact/lang/_pl/lang.inc.php (istotny
    *                               jest pocz±tek ¶cie¿ki "./htdocs/" jak i jej koniec "/_pl/lang.inc.php").
    *                               Ka¿dy wiersz pliku to pojedyncza ¶cie¿ka do pliku jêzykowego. Wszystkie ¶cie¿ki
    *                               maj± wskazywaæ do plików z tylko jednej wersji jêzykowej, np. "_pl".
    *                               Konstruktor automatycznie utworzy w strukturze $fieArray ¶cie¿ki do
    *                               plików z pozosta³ych wersji jêzykowych.
    * @author lech@sote.pl m@sote.pl
    * @return none
    */
    function LangEditor($langs = "pl, en, de", $part = 'htdocs', $lang_list_file='', $report_lang = ''){
        global $DOCUMENT_ROOT;
        global $shop, $config;
        
        if(($part == 'admin') || ($part == 'htdocs'))
            $this->part = $part;
            
        if(!empty($report_lang)) {
            $this->lang_to_report = $report_lang;
        }
        if (empty($lang_list_file)) {
            if($this->part == 'admin')
            $this->lang_list_file="admin/go/_lang_editor/config/lang_files_admin.txt";
        
            if ($shop->home!=1) {      
                $lang_list_file=$DOCUMENT_ROOT."/../".$this->lang_list_file;
            } else {
                $lang_list_file=preg_replace("/^admin/","",$this->lang_list_file);   
            }
            
        } else {
            $this->lang_list_file = $lang_list_file;
            if ($shop->home!=1) {      
                $lang_list_file = $DOCUMENT_ROOT."/../".$lang_list_file;
            } else {
                $lang_list_file=preg_replace("/^admin/","",$this->lang_list_file);   
            }
        }
                        
        $this->temp_dir = $DOCUMENT_ROOT . '/../admin/tmp';
        if($shop->home == 1)
            $this->temp_dir = $DOCUMENT_ROOT . "/tmp2";
        $this->languages[0] = $this->base_lang;
        $tmp_l = explode( ',', str_replace(' ', '', $langs));
        for ($i = 0; $i < count($tmp_l); $i++) {
            if($tmp_l[$i] != $this->base_lang)
                $this->languages[] = $tmp_l[$i];
        }
        
        for ($i = 0; $i < count($this->languages); $i++) {
            $tmp_l = $this->languages[$i];
            for($j = 0; $j < count($config->langs_symbols); $j++) {
                if($config->langs_symbols[$j] == $tmp_l) {
                    $this->encoding[$i] = $config->langs_encoding[$j];
                }
            }
        }
        
        if(is_file($lang_list_file)){
            $handle = fopen($lang_list_file,'r');
            $lines=fread($handle,filesize($lang_list_file));
            $buffer=split("\n",$lines);
            fclose($handle);
            for($i = 0; $i < count($buffer); $i++){
                $groupname = strstr($buffer[$i], '_');
                $groupname = substr($groupname, 1, strpos($groupname, '/') - 1);
                if(!in_array($groupname, $this->groups) && ($groupname != 'pl')){
                    $this->groups[] = $groupname;
                }
                if($groupname == 'pl')
                $groupname = 'main';
                $elem = array();
                for($j = 0; $j < count($this->languages); $j++){
                    if($shop->home == 1)
                        $elem['location'][$this->languages[$j]] = trim(str_replace('/@@/', '/', "$DOCUMENT_ROOT/" . str_replace('/_pl/', '/_' . $this->languages[$j] . '/', $buffer[$i])));
                    else
                        $elem['location'][$this->languages[$j]] = trim(str_replace('/@@/', '/', "$DOCUMENT_ROOT/../" . str_replace('/_pl/', '/_' . $this->languages[$j] . '/', $buffer[$i])));
//                    echo $elem['location'][$this->languages[$j]].'<br>';
                }
                $elem['group'] = $groupname;
                $this->fileArray[] = $elem;
            }
        }
        else
        echo "<br>Brak pliku z list± $lang_list_file!<br>";
        return;
    }  // end LangEditor()
    
    /**
    * Pobranie zmiennych do tablicy CurrentVars
    *
    * Funkcja pobiera zmienne z pliku z definicjami jêzykowymi i wpisuje je do tablicy
    * CurrentVars
    *
    * @param int $i Indeks tablicy FileArray, pod którym znajduje siê ¶cie¿ka do pliku
    * zawieraj±cego zmienne pobierane do CurrentVars.
    */
    function readLangFileToCurrentVars($i, $lang_name){
        $lang_file = trim($this->fileArray[$i]['location'][$lang_name]);
        if(is_file($lang_file)){
            global $lang;
            
            $this->_includeLangFile($i, $lang_name);
            
            $tablica = array($this->lang);
            $tablica = $tablica[0];
            $basic_location = trim(strstr($lang_file, '/./'));
            $basic_location = substr($basic_location, 0, -16);
//            echo "[$i: $lang_file]<br>";
            while(list($key, $val) = each($tablica)){
                if($this->fileArray[$i]['group'] != 'main')
                $this->currentVars[$key]['group'] = $this->fileArray[$i]['group'];
                else{
                    for($j = 0; $j < count($this->groups); $j++){
                        if(ereg("^" . $this->groups[$j], $key)){
                            $this->currentVars[$key]['group'] = $this->groups[$j];
                        }
                    }
                }
                if(@$this->currentVars[$key]['group'] == '')
                    $this->currentVars[$key]['group'] = 'main';
                $this->currentVars[$key]['value'][$lang_name] = $val;
                $this->currentVars[$key]['location'][$lang_name] = $lang_file;
                $this->currentVars[$key]['confirmed'][$lang_name] = 1;
//                echo "[" . $key . '|' . $basic_location . "]";
//                echo "$lang_name: [$key: $val]<br>";
                if(!empty($this->md5_array[$key . '|' . $basic_location])) {
                    $base_md5 = md5(serialize(@$this->currentVars[$key]['value'][$this->base_lang]));
                    if($this->md5_array[$key . '|' . $basic_location][$lang_name] != $base_md5) {
                        $this->currentVars[$key]['confirmed'][$lang_name] = 0;
                    }
                }
            }
        }
    }
    
    
    
    /**
    * Skopiowanie pliku do katalogu tymczasowego
    *
    * Plik zostaje skopiowany do katalogu tymczasowego w celu umo¿liwienia jego ponownego
    * "includowania", gdy zosta³ ju¿ uprzednio za³±czony poprzez "include_once" lub
    * "require_once"
    *
    * @param int $i Indeks tablicy FileArray, pod którym znajduje siê ¶cie¿ka do kopiowanego
    * pliku. Zmienna ta zostaje równie¿ dodana jako przedrostek do nazwy pliku w celu
    * unikniêcia niepo¿±danego nadpisania.
    */
    function _copyFileToTemp($i, $lang_name){
        $filename = basename($this->fileArray[$i]['location'][$lang_name]);

        if(!is_dir($this->temp_dir)){
            echo 'Brak katalogu ' . $this->temp_dir;
            return 0;
        }
        if(is_file(trim($this->fileArray[$i]['location'][$lang_name]))){
//            if(($i == 3) && ($lang_name == 'pl'))
//                echo "********" . $this->fileArray[$i]['location'][$lang_name] . "********";
            copy(trim($this->fileArray[$i]['location'][$lang_name]), $this->temp_dir . "/$i" . '_' . $lang_name . '_' . $filename);
            return 1;
        }
//        else echo '[*'.$this->fileArray[$i]['location'][$lang_name].'*]';
    }
    
    /**
    * Usuniêcie pliku z katalogu tymczasowego
    *
    * Plik zostaje usuniêty z katalogu tymczasowego.
    *
    * @param int $i Indeks tablicy FileArray, pod którym znajduje siê ¶cie¿ka do usuwanego
    * pliku.
    */
    function _deleteFileFromTemp($filename){
//        echo "deleting " .$filename. "<br>";
        
        if(is_file($filename))
            unlink($filename);
        
    }
    
    /**
    * Za³±czenie pliku
    *
    * Plik zostaje skopiowany do katalogu tymczasowego w celu umo¿liwienia jego ponownego
    * "includowania", gdy zosta³ ju¿ uprzednio za³±czony poprzez "include_once" lub
    * "require_once"
    *
    * @param int $i Indeks tablicy FileArray, pod którym znajduje siê ¶cie¿ka do za³±czanego
    * pliku.
    */
    function _includeLangFile($i, $lang_name){
        if($this->_copyFileToTemp($i, $lang_name)){
            $filename = basename($this->fileArray[$i]['location'][$lang_name]);

            if(is_file($this->temp_dir . "/$i" . '_' .$lang_name . '_' . $filename)){
                $file_include=$this->temp_dir . "/$i" . '_' . $lang_name . '_' . $filename;
                $lang =& new LangTmp;
                require($file_include);

                $this->lang=$lang;
            }

            
            
            
            $this->_moveToTrash($i, $lang_name);
            
            
            
        }
        else
        echo "B³±d";
    }
    

    function _moveToTrash($i, $lang_name) {
        $filename = basename($this->fileArray[$i]['location'][$lang_name]);
        $elem = $this->temp_dir . "/$i" . '_' . $lang_name . '_' . $filename;
        $this->trash[] = $elem;
    }
    
    function emptyTrash() {
        for($i = 0; $i < count($this->trash); $i++) {
            $this->_deleteFileFromTemp($this->trash[$i]);
        }
//        print_r($this->trash);
    }

    /**
    * Przygotowanie zapytania SQL tworz±cego tabelê "lang" wstawiaj±cego wszystkich pozycji
    *
    * Metoda, któr± mo¿na wywo³aæ w celu wygenerowania zapytania SQL tworz±cego tabelê "lang"
    * i wstawiaj±cego wszystkie krotki dotycz±ce pól obiektu $lang zdefiniowanych w plikach
    * lang.inc.php. Metoda mo¿e zostaæ wywo³ana choæby zaraz po zainicjowaniu obiektu klasy.
    *
    * @author lech@sote.pl m@sote.pl
    * @return array tablica z insertami do bazy
    */
    function prepareInsertQuery(){
        $part = $this->part;
        $this->query=array();
        $count = 0;
        for($i = 0; $i < count($this->fileArray); $i++){
            $this->currentVars = array();
            for($j = 0; $j < count($this->languages); $j++){
                $this->readLangFileToCurrentVars($i, $this->languages[$j]);
            }
            
            while(list($key, $val) = each($this->currentVars)){
                $uniloc = '';
                $q_lang = '';
                $q_lang_val = '';
                $md5_base = '';
                for($j = 0; $j < count($this->languages); $j++){
                    $md5_update = 'empty';
                    if($uniloc == '')
                        $uniloc = @$val['location'][$this->languages[$j]];
                    $q_lang .= "," . addslashes($this->languages[$j]) . ",md5_" . addslashes($this->languages[$j]);
                    $v = serialize(@$val['value'][$this->languages[$j]]);
                    if($this->base_lang == $this->languages[$j])
                        $md5_base = md5($v);
                    if(!empty($val['value'][$this->languages[$j]]))
                        $md5_update = $md5_base;
                    $q_lang_val .= ",'" . addslashes($v) . "','" . $md5_update . "' ";
                    
                }
                $uniloc = strstr(addslashes(substr($uniloc, 0, -16)), "/./$part/");
                $this->query[]= "insert into lang (name, group_name, path $q_lang) values('" . addslashes($key) . "', '" . addslashes($val['group']) . "', '$uniloc' $q_lang_val)";
                $count++;
            }
        }
        return $this->query;
    }
    
    /**
    * Wygenerowanie zapytania SQL znajduj±cego ¶cie¿ki do plików z poszukiwanymi zmiennymi
    *
    * Metoda generuje zapytanie zwracaj±cego ¶cie¿ki do plików, w których znajduj± siê
    * poszukiwane przez u¿ytkownika zmienne. Kryteria tych zmiennych dostarczone s± przez
    * u¿ytkownika poprzez przes³anie formularza wyszukuj±cego zmienne.
    *
    * @param array $request Tablica z kryteriami wys³anymi w formularzu (umieszczamy tu
    * tablicê $_REQUEST). Tablica ta ma nastêpuj±ce pola, przy czym wszystkie s± opcjonalne:
    * <ul>
    *   <li>group_name - nazwa grupy (modu³u), do której nale¿y zmienna,</li>
    *   <li>var_name - nazwa lub fragment nazwy zmiennej,</li>
    *   <li>var_value - warto¶æ lub fragment warto¶ci zmiennej,</li>
    *   <li>untranslated_lang - dwuliterowa nazwa jêzyka (np. "pl" lub "en"),
    *   dla którego zapytanie ma wyszukaæ warto¶ci nieprzet³umaczone (puste)</li>
    * </ul>
    * @return string Funkja zwraca zapytanie, o którym mowa w opisie.
    */
    function preparePathSearchQuery($request){
        $group_name = trim(addslashes(@$request['group_name']));
        $var_name = trim(addslashes(@$request['var_name']));
        $var_value = trim(addslashes(@$request['var_value']));
        $untranslated_lang = trim(addslashes(@$request['untranslated_lang']));
        $and = '';
        $where = '';
        if($group_name != ''){
            $where .= " group_name='$group_name'";
            $and = 'and';
        }
        if($var_name != ''){
            $where .= " $and name like '%$var_name%'";
            $and = 'and';
        }
        if($var_value != ''){
            $where .= " $and (";
            $or = '';
            for($l = 0; $l < count($this->languages); $l++){
                $where .= " $or " . $this->languages[$l] . " like '%$var_value%'";
                $or = 'or';
            }
            $where .= ')';
            $and = 'and';
        }
        
        if($untranslated_lang != ''){
            $where .= " $and ($untranslated_lang ='N;' OR $untranslated_lang ='' OR $untranslated_lang IS NULL)";
            $and = 'and';
        }
        
        $where .= " $and path like '/./" . $this->part . "/%'";
        $and = 'and';
        
        $where_word = '';
        if($where != '')
        $where_word = 'where';
        $cols = "name, path";
        for ($i = 0; $i < count($this->languages); $i++) {
            $cols .= ", md5_" . $this->languages[$i];
        }
        $query="select $cols from lang $where_word $where";
        return $query;
    }
    
    /**
    * Wygenerowanie tablicy ze ¶cie¿kami do plików z definicjami lang
    *
    * Metoda wykonuje zapytanie do bazy i na jego podstawie tworzy tablicê
    * zawieraj±c± ¶cie¿ki do plików lang
    *
    * @param string $query Zapytanie SQL, które determinuje jakie ¶cie¿ki zostan± wyszukane
    * @return array Tablica zawieraj±ca pobrane z bazy ¶cie¿ki do plików z definicjami lang.
    */
    function retreivePathsFromDB($query){
        global $db;
        $paths = array();
        $paths_check = array();
        // przygotowenie + wstêpne sprawdzenie poprwano¶ci SQL
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            // wykonanie zapytania
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // ilo¶æ odpowiedzi
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    // jest conajmniej 1 wynik
                    for ($i=0;$i<$num_rows;$i++) {
                        $p = $db->FetchResult($result,$i,"path");
                        if(!isset($paths_check[$p])) {
                            $paths[]=$p;
                            $paths_check[$p] = 1;
                        }
                        $name = $db->FetchResult($result,$i,"name");
                        for ($j = 0; $j < count($this->languages); $j++) {
                            $this->md5_array[$name . '|' . $p][$this->languages[$j]] = $db->FetchResult($result,$i,"md5_" . $this->languages[$j]);
                        }

                    }
                } else {
                    // nie ma wyników
                }
            } else die ($db->Error());
        } else die ($db->Error());
/*
        echo "<pre>";
        print_r($this->md5_array);
        echo "</pre>";
*/
        return $paths;
    }
    
    /**
    * Odfiltrowaie i sprawdzenie typu zmiennej
    *
    * Metoda sprawdza, czy zmienna $key spe³nia warunki wy¶wietlenia w li¶cie zmiennych do
    * edycji po przes³aniu formularza z kryteriami szukanych zmiennych.
    *
    * @param array $request Tablica z kryteriami wys³anymi w formularzu (umieszczamy tu
    * tablicê $_REQUEST). Tablica ta ma nastêpuj±ce pola, przy czym wszystkie s± opcjonalne:
    * <ul>
    *   <li>group_name - nazwa grupy (modu³u), do której nale¿y zmienna,</li>
    *   <li>var_name - nazwa lub fragment nazwy zmiennej,</li>
    *   <li>var_value - warto¶æ lub fragment warto¶ci zmiennej,</li>
    *   <li>untranslated_lang - dwuliterowa nazwa jêzyka (np. "pl" lub "en"),
    *   dla którego zapytanie ma wyszukaæ warto¶ci nieprzet³umaczone (puste)</li>
    * </ul>
    * @param string $key Nazwa weryfikowanej zmiennej
    * @return string Zwrócona warto¶æ mo¿e byæ nastêpuj±ca:
    * <ul>
    *   <li>"simple" - zmienna spe³nia kryteria i jest typu prostego,</li>
    *   <li>"array" - zmienna spe³nia kryteria i jest tablic±,</li>
    *   <li>"none" - zmienna nie spe³nia kryteriów.</li>
    * </ul>
    */
    function filterVariable($request, $key){
        global $config, $_REQUEST;
        $val = $this->currentVars[$key];
        $group_name = trim(addslashes(@$request['group_name']));
        $var_name = trim(addslashes(@$request['var_name']));
        $var_value = trim(addslashes(@$request['var_value']));
        $untranslated_lang = trim(addslashes(@$request['untranslated_lang']));
        if(($group_name == '') || ($val['group'] == $group_name)){
            if(($var_name == '') || (stristr($key, $var_name) !== false)){
                $pass = 0;
                if($var_value == '')
                $pass = 1;
                for($lll = 0; $lll < count($this->languages); $lll++){
                    if(@stristr(serialize(@$val['value'][$this->languages[$lll]]), $var_value) !== false)
                    $pass = 1;
                }
                if(($untranslated_lang != '') && (@$val['value'][$untranslated_lang] != ''))
                $pass = 0;
                if((@$_REQUEST['noempty'] == 'on') && ((!empty($val['value'][$config->base_lang])) && (@$val['value'][$config->base_lang] != 'N;')))
                $pass = 0;
                if((@$_REQUEST['noempty'] != 'on') && ((empty($val['value'][$config->base_lang])) || (@$val['value'][$config->base_lang] == 'N;')))
                $pass = 0;
                if($pass == 1){
                    $vtype = 'simple';
                    for($i0 = 0; $i0 < count($this->languages); $i0++){
                        if(is_array(@$val['value'][$this->languages[$i0]]))
                        $vtype = 'array';
                    }
                    return $vtype;
                }
            }
        }
        return 'none';
    }
    
    /**
    * Usuniêcie pustych elementów tablicy - rekurencyjnie
    *
    * @param array $array Tablica wej¶ciowa
    * @return array Tablica z usuniêtymi pustymi pozycjami
    */
    function removeEmptyEntries($array) {
        $res_array = array();
        while(list($key, $val) = each($array)) {
            if(!is_array($val)) {
                if(trim($val) != '')
                $res_array[$key] = $val;
            }
            else {
                $res_array[$key] = $this->removeEmptyEntries($val);
            }
        }
        return $res_array;
    }
    
    /**
    * Aktualizacja relacji "lang" i plików z definicjami jêzykowymi
    *
    * Metoda pobiera dane z przes³anego formularza edycji i dokonuje aktualizacji danych
    * w bazie oraz w odpowiednich plikach lang.inc.php. Je¿eli w danej wersji jêzykowej plik
    * nie istnieje, to jest on tworzony równolegle do pozosta³ych wersji jêzykowych
    * z definicj± zmiennej wewn±trz.
    *
    * @param array $request Tablica z danymi o zmiennych wys³anymi w formularzu (umieszczamy tu
    * tablicê $_REQUEST). Tablica ta ma nastêpuj±ce pola:
    * <ul>
    *   <li>var_location - ¶cie¿ka do pliku, w którym znajduje siê aktualizowana zmienna:
    *   ¶cie¿ka ta prowadzi do jednej z wersji jêzykowej pliku, np.
    *   "/./htdocs/lang/_en/lang.inc.php", a metoda sama podmienia podci±g "/_en/" na
    *   pozosta³e wersje jêzykowe tak, by zaktualizowaæ wszystkie dane i pliki; Uwaga:
    *   ¶cie¿ka musi zawieraæ podci±g "/./htdocs/"!</li>
    *   <li>var_name - nazwa zmiennej,</li>
    *   <li>var_value["xx"] - warto¶æ zmiennej dla danej wersji jêzykowej, gdzie "xx"
    *   oznacza skrótow± nazwê jêzyka, np. "pl" lub "en"</li>
    *   <li>untranslated_lang - dwuliterowa nazwa jêzyka (np. "pl" lub "en"),
    *   dla którego zapytanie ma wyszukaæ warto¶ci nieprzet³umaczone (puste)</li>
    * </ul>
    */
    function updateAll($request){
        global $generator, $mdbd, $NewEncoding;
        $md5_base = '';
        for($i = 0; $i < count($this->languages); $i++){// dla ka¿dego jêzyka
            $lang_name = $this->languages[$i];
            $update_arr = array();
            
            //ustal pe³n± ¶cie¿kê do pliku
            $path = substr(strstr($request['var_location'], '/./' . $this->part . '/'), 0, -16) . '_' . $this->languages[$i] . '/lang.inc.php';
            
            //stwórz tablicê z warto¶ci± (warto¶ciami) zmiennej
            $update_arr[$request['var_name']] = $NewEncoding->Convert(@$request['var_value'][$lang_name], "utf-8", $this->encoding[$i], 0);
            $update_arr = $this->removeEmptyEntries($update_arr);

            if($lang_name == $this->base_lang) {
                $md5_base = md5(serialize(@$update_arr[@$request['var_name']]));
            }
            
            $md5_update = 'empty';
            if(!empty($update_arr[@$request['var_name']])) {
                $md5_update = $md5_base;
            }
            //wygeneruj plik z now± zmienn±
            
            $generator->genPHPFileValues('lang', $path, $update_arr);
            
            //zapisz zmiany do bazy
            $path = addslashes(substr($path, 0, -16));
//            echo "[$path] [$lang_name]<br>";
            if(@$request['confirm'][$lang_name] == 1) {
                $mdbd->update("lang", $lang_name . "=?, md5_" . $lang_name . "=?", "name=? AND path like ?",
                    array(
                        serialize(@$update_arr[@$request['var_name']]) => "text",
                        $md5_update => "text",
                        $request['var_name'] => "text",
                        $path . "%" => "text"
                    )
                );
            }
            else {
                $mdbd->update("lang", $lang_name . "=?", "name=? AND path like ?",
                    array(
                        serialize(@$update_arr[@$request['var_name']]) => "text",
                        $request['var_name'] => "text",
                        $path . "%" => "text"
                    )
                );
            }
            
//            echo "Path: $path, Var_name: " . $request['var_name'], " Lang name: $lang_name<br>";
        
        }//for
        $this->currentVars = array();
    } // end updateAll()
    
} // end class LangEditor
?>

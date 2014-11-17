<?php
/**
* Klasa zawierajaca funkcje zwiazane z prezentacja listy rekordow z wybranej tabeli z bazy danych:
* lista rekordow, podzial na podstrony itp.
*
* @author  m@sote.pl
* @version $Id: DBEdit.inc,v 2.34 2005/12/06 11:15:48 lechu Exp $
* @package soteesklep
*
* @public recordList(), record_list()
* @public setRecord(),  set_record()
* @public pageURL(),    page_url()
*/

class DBEdit {

    var $classname="DBEdit";             // nazwa klasy
    var $dbtype="mysql";                 // typ bazy danych

    // nazwa pola z tabeli z bazy danych, ktore zawiera klucz glowny tabeli
    var $table_key="id";

    var $page_records=10;                // liczba prezentowanych produktow na stronie
    var $page_links=15;                  // liczba linkow do kolejnych podstron
    var $page=0;                         // aktualna strona (domylsnie 1)
    var $page_var="page";                // zmienna GET - przekazanie numeru strony
    var $first="First";                  // oznaczenie linku po pierwszej strony
    var $next="&raquo;";                 // oznaczenie linku do natêpnych produktów
    var $prev="&raquo;";                 // oznaczenie linku do poprzednich produktów
    var $font="<font>";                  // font, wg, którego bêd± przedstrawiane linki
    var $dbobj="db";                     // nazwa zmiennej - obiekt Metabase
    var $id_var="id";                    // zmienna GET okreslajaca id recordu
    var $sql;                            // zapytanie SQL
    var $sql_limit="true";               // true - wlaczenie dolaczania elementow LIMIT do SQL
    var $record_class="RecordRow";       // klasa zawierajaca funkcje prezenctacji produktu
    var $record_fun="record";            // funckja jw.
    var $open_page_links_top_fun="open_page_links_top";          // funkcja klasy $record_class generujaca element przed linkami do podstron
    var $close_page_links_top_fun="close_page_links_top";        // jw. po linkach do podstron (dotyczy linkow na gorze strony)
    var $open_page_links_bottom_fun="open_page_links_bottom";    // jw. do linkwo na dole strony
    var $close_page_links_bottom_fun="close_page_links_bottom";  // jw. do linkwo na dole strony
    var $start_list_element="<center>\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\" align=\"center\">\n";    // element na poczatku lity rekordow
    var $end_list_element="</table>\n</center>\n";    // jw. na koncu
    var $top_dbedit_show=true;           // czy pokazywac dodatkwe informacje nad lista, zmienna operacyjna
    var $top_links="true";               // pokaz linki do podstron na gorze listy
    var $bottom_links="true";            // pokaz linki do podtsron na dole listy
    var $session_var="sess_id";          // zmienna przekazujaca numer sesji

    // informacja ukazujaca sie, gdy nie ma zadnych rekordow
    var $empty_list_message="<center>No records</center>";
    var $empty_list_file="";             // plik wyswietleny, kiedy wynik zapyania jest pusty

    // zmienne przekazane do obiektu klasy $record_class "nazwa"=>"wartosc"
    var $record_vars=array();

    // lang
    var $lang_page="Page";
    var $lang_records="Records";

    // oznaczenie ostatniego rekordu na liscie, wykorzystywane do wstawienia dodatkowych elemento
    // w ostatnim wierszu prezentacji listy rekordow
    var $last_record_on_page=0;


    // sortowanie - parametr okreslajacy nzwe kolumny sortowania
    var $order_param="order";
    var $order_cols=array();  // tablica z kolumnami sortowania np. array(1=>"name","-1"=>name DESC")

    /**
    * Konstruktor obiektu DBEdit
    *
    * @author piotrek@sote.pl
    *
    * @access public
    * @return void
    */
    function DBEdit() {
        global $lang;

        $this->empty_list_message="<center>".$lang->empty_list_message."</center>";
        $this->lang_page=$lang->page;
        $this->lang_records=$lang->records;
        $this->first=$lang->first;

        return;
    } // end DBEdit()


    /**
    * Podstaw pod $this->db uchwyt bazy danych
    *
    * @global object $this->db
    *
    * @access private
    * @return void
    */
    function _init_db() {
        $this->db=$GLOBALS[$this->dbobj];
        if (empty($this->db)) {
            die ("Error: $this->classname Unknown database object \$this->db");
        }
        return;
    } // end _init_db()

    /**
    * Funkcja dodaje wartosci LIMIT zapytania SQL
    *
    * @param string $sql zapytanie SQL
    *
    * @access private
    * @return string SQL np. SELECT * FROM main LIMIT 5 OFFSET 3 (pgsql); LIMIT 5,3 (mysql)
    */
    function _sql_limit($sql) {
        /*
        $this->limit_num=$this->page_records*$this->page_links;
        $this->pages_links=intval(($this->page-1)/$this->page_links);
        $this->limit_from=($this->pages_links*$this->limit_num)+1;
        if ($this->page=="1") { $this->limit_from="0"; }
        if ($this->limit_from < 0) { $this->limit_from = 0; }
        if ( $this->limit_num < 1) {  $this->limit_num = 1; } else {$this->limit_num++;} // +1 aby sprawdzic, czy sa kolejne rekordy

        if ($this->dbtype=="mysql") {
        $sql="$sql LIMIT $this->limit_from,$this->limit_num";
        } else {
        $sql="$sql LIMIT $this->limit_num OFFSET $this->limit_from";
        }
        */

        $this->pages_links=intval(($this->page-1)/$this->page_links);
        $this->limit_from=($this->page-1)*$this->page_records;
        $this->limit_num=$this->page_records;

        if ($this->dbtype=="mysql") {
            $sql="$sql LIMIT $this->limit_from,$this->limit_num";
        } else {
            $sql="$sql LIMIT $this->limit_num OFFSET $this->limit_from";
        }

        return $sql;
    } // end _sql_limit()


    /**
    * Odczytaj nazwe tabeli z zapytania SQL
    *
    * @param string $sql zapytanie SQL
    * @global string $this->table nazwa tabeli
    *
    * @access public
    * @return string nazwa tabeli
    */
    function get_table_from_sql($sql){
        preg_match("/(FROM )([a-z0-9_]+)/i",$sql,$matches);
        $table=$matches[2];
        $this->table=$table;
        return $table;
    } // end get_table_from_sql()

    /**
    * Ustaw dane liczby podtsron, strone starowa itp.
    * Zmienne wykorzystywane przy generowaniu linkow do podstron
    *
    * @return
    * @global string $this->page_start poczatkowa postrona na liscie stron
    * @global string $this->page_end   koncowa podstrona
    * @global string $this->pages      liczba wszystkich stron
    *
    * @access private
    * @return void
    */
    function _set_pages() {
        $this->pages=intval($this->records/$this->page_records);
        if (($this->pages*$this->page_records)!=$this->records) $this->pages++;

        $this->page_start=intval(($this->page-1)/$this->page_links);
        $this->page_start=$this->page_start*$this->page_links+1; // zmiana kolejnych podstron o $this->page_links

        $this->page_end=$this->page_start+$this->page_links;
        if ($this->page_end>$this->pages) $this->page_end=$this->pages;
        return;
    } // end _set_pages()

    /**
    * Zdefiniuj funkcje generujaca prezentacje recordu w liscie
    *
    * @param  string $class klasa zaweirajaca funkcje prezenatcji rekordu na liscie
    * @param  string $fun   nazwa funkcji w/w klasy
    * @global string $this->record_class
    * @global string $this->record_fun
    *
    * @access public
    * @return void
    */
    function set_record($class,$fun) {
        $this->record_class=$class;
        $this->record_fun=$fun;
        return;
    } // end set_record()

    function setRecord($class,$fun) {
        return $this->setRecord($class,$fun);
    } // end setRecord()

    /**
    * Inicjacja obiektu preentacji wiersza rekordu + przekazanie paramertow z record_vars
    *
    * @global object $this->record_obj obiekt bazy danych
    *
    * @access private
    * @return void
    */
    function _init_record_row_obj() {
        $record = new $this->record_class;

        // przekaz parametry ustawione w $this->record_vars
        reset($this->record_vars);
        while (list($key,$val) = each($this->record_vars)) {
            $record->$key=$val;
        }

        // przekaz nazwe tabeli z zapytania SQL
        $record->table=$this->table;
        // przekaz nazwe zmiennej reprezentujacej id recordu w tabeli
        $record->id_var=$this->id_var;

        $this->record_obj=$record;

        return;
    } // end _init_record_row_obj()

    /**
    * Wywolanie prezentacji pojedynczego rekordu z bazy w liscie
    *
    * @param mixed   $result wynik zapytania SQL
    * @param int     $i      numer wiersza wyniku zapytania SQL liczac od 0
    *
    * @access private
    * @return void
    */
    function _record_row($result,$i) {
        $record=$this->record_obj;
        $record_fun=$this->record_fun;
        $record->$record_fun($result,$i);
        return;
    } // end _record_row()

    /**
    * Generuj linki po kolejnych podstron
    *
    * @access private
    * @return string linki do kolejnych podstron
    */
    function _page_links() {
        if (! $this->page_start) { $this->_sql_limit(); }  // ustal wartosc $this->page_start

        $o="";

        // podaj numer strony i rekordow
        $record_from=(($this->page-1)*$this->page_records);
        $record_to=$record_from+$this->page_records;
        if ($record_to>$this->records) $record_to=$this->records;
        $record_from++;

        $o.="$this->lang_page: $this->page $this->lang_records: $record_from - $record_to ($this->records)<BR>\n";

        // wstaw link do poprzednich stron
        if ($this->page>$this->page_links) {
            $o.="<a href=".$this->page_url(1,"").">";
            $o.=$this->first."</a>&nbsp;";

            $prevpage=$this->page-1;
            $o.="<a href=".$this->page_url($prevpage,"").">";
            $o.=$this->prev."</a>&nbsp;";
        }

        // wyswietl liste linkow do podstron
        $i=0;$npage=0;
        while (($i<$this->page_links) && ($i<$this->pages)) {
            $npage=$i+$this->page_start;    // kolejna strona z uwzglednienim strony startowej
            if ($this->page==$npage) {
                if ($this->page>=1) {
                    $o.="<b>$npage</b>&nbsp;";
                }
            } elseif ($npage<=$this->pages) {
                $o.="<a href=".$this->page_url($npage,"").">";
                $o.="$npage";
                $o.="</a> \n";
            }
            $i++;
        }

        // wstaw link do kolejnych podstron
        if ($this->page<$this->pages) {
            $nextpage=$this->page+1;
            $o.="&nbsp;<a href=".$this->page_url($nextpage,"").">";
            $o.=$this->next."</a>&nbsp;";
        }

        return $o;
    } // end _page_links()

    /**
    * Funkcja generuje link URL zawierajacy wszystkie elementy GET przekazane w wywolaniu
    * + link do podstrony
    *
    * @param  int    $page        numer strony
    * @param  array  $my_GET_VARS dodatkowe zmienne przekazywane w wywolaniu strony
    * @global string $HTTP_HOST
    * @global array  $REQUEST
    * @global string $SCRIPT_NAME
    *
    * @access public
    * @return adres URL + parametry GET
    */
    function page_url($page=1,$my_GET_VARS=array()) {
        global $_SERVER,$REQUEST,$SCRIPT_NAME;

        $HTTP_HOST=$_SERVER['HTTP_HOST'];
        $SCRIPT_NAME=$_SERVER['SCRIPT_NAME'];

        if (empty($my_GET_VARS)) { $my_GET_VARS=$_REQUEST; }
        else {
            reset($my_GET_VARS);
            $_COPY=$_REQUEST;
            foreach ($my_GET_VARS as $var=>$val) {
                $_COPY[$var]=$my_GET_VARS[$var];
            }
            $my_GET_VARS=$_COPY;
        }

        $url=$SCRIPT_NAME;

// prevent GA cookies
// tomasz
unset($my_GET_VARS['__utmz']);
unset($my_GET_VARS['__utma']);
unset($my_GET_VARS['__utmb']);
unset($my_GET_VARS['__utmc']);
unset($my_GET_VARS['__utmv']);
unset($my_GET_VARS['__utmx']);

        if (! empty($page)) { $my_GET_VARS["$this->page_var"]=$page; }

        // Values submitted via GET method:
        $i=0; reset($my_GET_VARS);

        while (list($key, $val) = each($my_GET_VARS)){

            // sprawdz czy element formularza jest tablica, jesli tak,
            // to dodaj elementy tablicy jako parametry do wywolania
            if (is_array($val)) {
                while (list($k,$v) = each($val)) {
                    $url=$this->_add_param($key.'['.$k.']',$v,$i,$url);
                    $i++;
                }
            } else {
                // przekaz paramter do wywolania skryptu
                if ($key!=$this->session_var) {
                    $url=$this->_add_param($key,$val,$i,$url);
                    $session_first=true;
                    $i++;
                }
            } // end if (is_array($val))
        }

	//check it this one should be rewritten
       //
       if(preg_match("/^\/go\/_category\/index.php\?(idc|cidc)=(id_[0-9]+|[0-9_]+)&page=([0-9]+)$/",$url,$match))
       {
	//$url = "/$match[1]/$match[2]/_category/page/$match[3]";

	if($match[3] > 1)
	{
	  $url = "/$match[1]/$match[2]/_category/page/$match[3]";
	}
	else
	{
	  $url = "/$match[1]/$match[2]/_category";
	}

        $expl = explode("_",$match[2]);
   
   	$results=count($expl);
   	if (strcmp($expl[0],"id") == 0)
   	{
      	  $results = $results - 1;
   	}

	preg_match("/([0-9]+)$/",$match[2],$cat_id);
	$cat_id = $cat_id[1];

	$q=$this->db->PrepareQuery("SELECT category$results FROM category$results WHERE id=?");
   	$this->db->QuerySetText($q,1,"$cat_id");
   	$retval=$this->db->ExecuteQuery($q);

    	if ($retval!=0) 
   	{
      	  $rows=$this->db->NumberOfRows($retval);
      	  if ($rows == 1) 
      	  {
           // produkt odczytany poprawnie
         	$cat_name=$this->db->fetchResult($retval,0,"category$results");
         	$enc = new EncodeUrl;
         	$cat_name = $enc->encode_url_category($cat_name);

		// nie wyswietlamy page/1 => zamiast tego idzie tylko nazwa kategorii
		// zeby nie dublowac stron
		if($match[3] > 1)
		{
	  	  $url = "/$match[1]/$match[2]/$cat_name/page/$match[3]";
		}
		else
		{
	  	  $url = "/$match[1]/$match[2]/$cat_name";
		}		      
      	  }
   	}
       }

        return $url;
    } // end page_url()

    function pageURL($page=1,$my_GET_VARS=array()) {
        return $this->page_url($page,$my_GET_VARS);
    } // end pageURL()

    /**
    * Dodaj parametr do wywolania skryptu
    *
    * @param string $key nazwa zmiennej
    * @param string $val wartosc zmiennej
    * @param int    $i   numer zmiennej w wywolaniu
    * @param string $url biezace parametry
    *
    * @access private
    * @return string parametry dodawane do adresu URL skryptu
    */
    function _add_param($key,$val,$i=0,$url='') {
        if(is_array($val)) {
            if($i == 0)
                return $url . '?1=1';
            else
                return $url . '';
        }
        $key=urlencode($key);
        $val=urlencode($val);
        if ($i==0) $url.="?$key=$val";
        else  $url.="&$key=$val";
        return $url;
    } // end _add_param()

    /**
    * Odczytaj i zapamietaj liczbe rekordow w zapytaniu SQL
    *
    * @global string $this->sql zapytanie SQL np.
    *         SELECT * FROM main WHERE id_category1=12 AND id_category2=3
    * @global int     $this->records liczba rekordow w zapytaniu SQL
    *
    * @access private
    * @return void
    */
    function _set_number_of_records() {
        // generuj zapytanie o liczbe rekordow, zastap np. SELECT (...) FROM -> SELECT count(id) FROM
        $sql=preg_replace("/^SELECT [a-zA-Z0-9_*,.]+ FROM/","SELECT count(id) FROM",$this->sql);
        // sprawdz czy jest grupowanie rekordow w zapytaniu, jesli tak,
        // to zmien obliczanie liczby rekordow
        // jako zliczanie ilosci rekordow ID zawroconych w zapytaniu,
        // gdyz count(id) zwraca liczbe rekordow
        // w poszczegolnych grupach (wg grupowania), a nie liczbe wszystkich rekordow z zapytania
        $group_by=false;
        if (eregi("group by",$sql)) {
            $group_by=true;
        }

        // obetnij sortowanie dla przyspieszenia wykonania zapytania
        if (eregi("order by",$sql)) {
            $t1=preg_split("/order by| ORDER BY/",$sql);
            $query=$t1[0];   // zapytanie SQL o ilosc rekordow wedlug klucza tylko z klauzula WHERE
        } else $query=$sql;

        $result=$this->db->Query($query);
        if ($result!=0) {
            $num_rows=$this->db->NumberOfRows($result);
            if ($num_rows>0) {
                if ($group_by==false) {
                    $this->records=$this->db->FetchResult($result,"0","count(id)");
                } else {
                    $this->records=$num_rows;
                }
            } else $this->records=0;
            return(0);
        } else die ($this->db->Error());

        return (0);
    } // end _set_number_of_records()

    /**
    * Ustaw odpowiednie sortowanie listy rekordow w SQL
    *
    * @global string $this->sql
    *
    * @access private
    * @return none
    */
    function _set_sql_order() {
        global $_REQUEST,$config;

        reset($config->langs_symbols);$lang_id_set=0;
        foreach ($config->langs_symbols as $lang_id=>$lang_name) {
            if ($lang_name==$config->lang) $lang_id_set=$lang_id;
        }

        if (! empty($_REQUEST[$this->order_param])) {
            if (! empty($this->order_cols[$_REQUEST[$this->order_param]])) {
                $order=$this->order_cols[$_REQUEST[$this->order_param]];
            } else $order='';
        } else $order='';

        // ustaw domy¶lne sortowanie dla tabeli "main"
        if ($this->table=="main") {
            
            if ($order=="name") $order="name_L$lang_id_set";
            if ($order=="name DESC") $order="name_L$lang_id_set DESC";

            $this->order_cols['default']=$config->main_order_default;
            if ($this->order_cols['default']=="price") $this->order_cols['default']="price_brutto";

            if ((empty($order)) && (! empty($this->order_cols['default']))) {
                $order=$this->order_cols['default'];
            }
        }
        
        if (eregi("ORDER BY",$this->sql)) {
            if (! empty($order)) {
                if (eregi(" DESC",$this->sql)) {
                    $this->sql=eregi_replace("DESC","",$this->sql);
                }
                $this->sql=preg_replace("/ORDER BY [A-Za-z_]+/","ORDER BY $order",$this->sql);
            }
        } else {            
            if (! empty($order)) {
                $this->sql.=" ORDER BY $order";
            }
        }

        // print $this->sql;

        return (0);
    } // end _set_sql_order()

    /**
    * Prezentacja listy produktów
    *
    * @param  string $sql
    * @param  array $order_array Opcjonalnie: tablica ze wskazaniem sortowania wyników. Klucz - user_id produktu; warto¶æ - im wiêksza, tym wy¿sza pozycja rekordu w sortowaniu
    * @global array  $REQUEST
    *
    * @access public
    * @return void
    */
    function record_list($sql, $order_array = array()) {
        global $_REQUEST;
        global $DOCUMENT_ROOT;

        $this->_init_db();
        $this->get_table_from_sql($sql);            // odczytaj nazwe tabeli z zapytania SQL

        if (! empty($_REQUEST[$this->page_var])) {
            $this->page=$_REQUEST[$this->page_var];  // odczytaj numer wyswietlanej strony
        } else {
            $this->page=1;
        }

        if (empty($this->page)) {$this->page=1;}

        if (! empty($sql)) { $this->sql=$sql; }

        // ustaw sortowanie listy
        $this->_set_sql_order();

        // wykonaj zapytanie o liczbe rekordow w zapytaniu SQL np." SELECT count(id) FROM main"
        $this->_set_number_of_records();

        if ($this->sql_limit=="true") { $this->sql=$this->_sql_limit($this->sql); }
        $this->_init_record_row_obj();
        // odczytaj adres obiektu
        $record=$this->record_obj;

        // print "sql=$this->sql <BR>";

        // przygotuj zapytanie $this->sql do wykonania
        $prepared_query=$this->db->PrepareQuery($this->sql);
        if ($prepared_query) {
            // wykonaj zapytanie do bazy
            $result=$this->db->ExecuteQuery($prepared_query);
            $this->num_rows=$this->db->NumberOfRows($result);

            // jesli nie ma rekorow to wyswietl info i zakoncz funkcje

            if ($this->num_rows<1) {
                print $this->empty_list_message;
                if (! empty($this->empty_list_file))
                @include_once ($this->empty_list_file);
                return(0);
            }


            // oblicz liczbe podstron itp.
            $this->_set_pages();

            if (($this->top_links=="true") && ($this->pages>1)) {
                $page_links=$this->_page_links();
                $open_fun=$this->open_page_links_top_fun;
                $close_fun=$this->close_page_links_top_fun;

                // jesli w obiekcie $reocrd sa dodatkowe funkcje zwiazane z wygladem
                // linkow, to wywolaj je; chodzi o pole przed linkami i po wyswietleniu linkow
                if (@function_exists(@$record->$open_fun)) $record->$open_fun();
                else print "<center>";
                print $page_links;
                if (@function_exists(@$record->$close_fun)) $record->$close_fun();
                else print "</center>";

            }

            // poczatek listy
            if ($this->num_rows>0) {
                print $this->start_list_element;
            }

            // lista rekordow
            if(!empty($order_array)) {
                $records_to_sort = array();
                $transform_array = array();
                for ($i = 0; $i < $this->num_rows; $i++) {
                    $records_to_sort[$i] = $this->db->FetchResult($result,$i,"user_id");
                    $transform_array[$i] = $order_array[$records_to_sort[$i]];
                }
                
                arsort($transform_array, SORT_NUMERIC);
                reset($transform_array);
                $row_num = 0;
                while (list($key, $val) = each($transform_array)) {
                    $transform_array[$key] = $row_num++;
                }
                $transform_array = array_flip($transform_array);
                
                for ($j=0; $j<$this->num_rows; $j++) {
                    $i = $transform_array[$j];
                    if ($i==($this->num_rows-1))
                        $this->last_record_on_page=1;
                    $this->_record_row($result,$i);
                }
            }
            else {
                for ($i=0; $i<$this->num_rows; $i++) {
                    if ($i==($this->num_rows-1)) $this->last_record_on_page=1;
                    $this->_record_row($result,$i);
                }
            }

            // koniec listy
            if ($this->num_rows>0) {
                print $this->end_list_element;
            }

            if (($this->bottom_links=="true") && ($this->pages>1)){
                if (! empty($page_links)) {
                    $open_fun=$this->open_page_links_bottom_fun;
                    $close_fun=$this->close_page_links_bottom_fun;

                    if (@function_exists(@$record->$open_fun)) $record->$open_fun();
                    else print "<center>";
                    print $page_links;
                    if (@function_exists(@$record->$close_fun)) $record->$close_fun();
                    else print "</center>";

                }
            } // wstaw linki do podstron

        } else {
            die ("Error: $this->classname SQL error");
        }

        return(0);
    } // end record_list()

    function recordList($sql) {
        return $this->record_list($sql);
    } // end recordList()

} // end class DBEdit


// Uwaga! na koncu nie moze byc zadnych znakow
?>

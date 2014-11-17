<?php
/**
* Generowanie kodu PHP tablicy kategorii na podstawie danych z bazy, zapisanie danych w pliku (przez ftp)
* config/tmp/category.php
*
* \@global object $stream obiekt klasy Stream -> obsluga status bar'a
*
* @author  m@sote.pl
* @version $Id: db2category.inc.php,v 2.14 2006/04/24 13:45:37 lechu Exp $
* @package    opt
*/

global $stream;

class DB2Category {
    // tablica drzewa z wszystkimi kategoriami z bazy
    // generowana na podstawie zapytania select category1,...,category5 from category
    // np.
    // var $axy=array(array("_Komputery"=>"1","__Laptopy"=>"1","___Toshiba"=>"1"),
    //                array("_Komputery"=>"1","__Laptopy"=>"1","___Compaq"=>"2"),
    //                array("_Komputery"=>"1","__Laptopy"=>"1","___IBM"=>"3"),
    //                array("_Drukarki"=>"2","__Atramentowe"=>"1","___HP"=>"5","____DeskJ1"=>"1","_____DJ5"=>"1"),
    //                array("_Drukarki"=>"2","__Atramentowe"=>"1","___HP"=>"5","____DeskJet2"=>"2","_____DJ5"=>"1"),
    //                array("_Komputery"=>"1","__PIII"=>"2","___Celeron"=>"4")
    //               );
    //     Znaki "_" w nazwach kategorii stosowane sa po to, zeby odroznic nazwy kategorii na kolejnych poziomach.
    //     Bez tego dodatkowego oznaczenia wystepowalby blad w przypadku kiedy mielibysmy np. takie dane:
    //     kategoria1=Skanery, kategoria2=Skanery, id kategorii1=12 id kaetgorii2=25
    //     W takim przypadku powstanie bledny wpis array("Skanery"=>"25"), gdyz kluczem w tablicy jest nazwa
    //     i pojawienie sie 2 raz tej smej nazwy nadpisuje poprzedni wpis.
    //     Przy odczytywaniu nazw kategorii znaki "_" na poczatku nazwy sa usuwane.
    
    var $axy=array();
    
    var $axy_sub;  // tymczasowa tablica z kategoriami, podtablica tablicy $this->axy
    var $n=5;      // liczba zagniezdzen
    
    var $php;      // kod PHP generowany podczas parsowania drzewa
    var $extra_code="\n\n\$__category=&\$category;\n"; // dodatkowy kod dolaczany do pliku z kategoriami
    var $search_form_code; // kod PHP do wyszukiwarki zaawansowanej
    var $category_only_call = true; // flaga informuj±ca, czy wywo³anie by³o dla kategorii tylko, czy dla kategorii i producentów
    
    /**
    * Konstruktor
    */
    function DB2Category() {
        $this->_cleanCategory();
        return;
    } // end DB2Category
    
    /**
    * Odczytaj kategorie z bazy i zapamietaj je w tablicy $this->axy
    *
    * @param string $WHERE ograniczenie wynikow np. filtr wg producenta
    */
    function db2array($WHERE=''){
        global $db, $config;
        
        if (empty($WHERE)) {
            $WHERE = "WHERE active=1 AND id_category1>0";$active='';
        }
        else {
            $active="AND m.active=1 AND m.id_category1>0";
            $this->category_only_call = false;
        }

        $depository_available = '';
        if ($config->depository['show_unavailable'] != 1) {
            $depository_available = " AND m.id_available <> " . $config->depository['available_type_to_hide'];
        }

        
        $query = "
        SELECT
            m.category1 AS category1, m.id_category1 AS id_category1,
            m.category2 AS category2, m.id_category2 AS id_category2,
            m.category3 AS category3, m.id_category3 AS id_category3,
            m.category4 AS category4, m.id_category4 AS id_category4,
            m.category5 AS category5, m.id_category5 AS id_category5
            
        FROM main m
            LEFT JOIN category1 ON m.id_category1 = category1.id
            LEFT JOIN category2 ON m.id_category2 = category2.id
            LEFT JOIN category3 ON m.id_category3 = category3.id
            LEFT JOIN category4 ON m.id_category4 = category4.id
            LEFT JOIN category5 ON m.id_category5 = category5.id
        $WHERE $active $depository_available
        GROUP BY
            m.category1, m.id_category1,
            m.category2, m.id_category2,
            m.category3, m.id_category3,
            m.category4, m.id_category4,
            m.category5, m.id_category5
            
        ORDER BY
            category1.ord_num, category1.category1,
            category2.ord_num, category2.category2,
            category3.ord_num, category3.category3,
            category4.ord_num, category4.category4,
            category5.ord_num, category5.category5
            ";

                
        $this->axy=array();
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==0) return false;
            $search_form_check = array();
            if ($this->category_only_call) {
                $this->search_form_code = "<?php\n" . 'global $search_form_tree;' . "\n\n";
            }
            for ($i=0;$i<$num_rows;$i++) {
                $tmp=array();
                $current_category_data = array();
                for ($c=1;$c<=5;$c++) {
                    $cat="category$c";
                    $val=$db->FetchResult($result,$i,"$cat");
                    $val=ereg_replace('"','\"',$val);
                    $id_val=$db->FetchResult($result,$i,"id_$cat");
                    if ($id_val > 0) {
                        $current_category_data[$c]['name'] = $val;
                        $current_category_data[$c]['id'] = $id_val;
                        if ($this->category_only_call) {
                            $brackets = "[" . $current_category_data[1]['id'] . "]";
                            $id_check_key = $current_category_data[1]['id'];
                            for($to_c = 2; $to_c <= $c; $to_c++) {
                                $brackets .= "[\"children\"][" . $current_category_data[$to_c]['id'] . "]";
                                $id_check_key .= '_' . $current_category_data[$to_c]['id'];
                            }
                            if(empty($search_form_check[$id_check_key])) {
                                $this->search_form_code .= '$search_form_tree' . $brackets . '["name"] = "' . $val . '";' . "\n";
                            }
                            $search_form_check[$id_check_key] = 1;
//                            
                        }
                    }
                    if ((! empty($val)) && (! empty($id_val))) {
                        $prefix=str_repeat("_",$c);
                        // zapisz kolejna kategorie w tablicy, ktora zostanie zapisana w $this->axy
                        $tmp[$prefix.$val]=$id_val;
                    } // end if
                } // end for
                if (! empty($tmp)) {
                    // dodaj kolejny wiersza kategorii do $this->axy
                    array_push($this->axy,$tmp);
                }
            } // end for
            if ($this->category_only_call) {
                $this->search_form_code .= "?>";
            }
        } else {
            die ($db->Error());
        }
        
        return true;
    } // end db2array()
    
    /**
    * Sprawdzenie czy element jest drzewem
    *
    * @param array $axy tablica drzewa
    * @param int $i numer elementu z tablicy $axy
    * @param int $k numer zagniezdzenia elementu
    * @return true - element jest drzewem, false jest lisciem
    */
    function gen_tree($axy,$i=0,$k=1) {
        global $stream,$lang;
        
        $stream->line_blue();
        flush();
        
        $lp=sizeof($axy);
        
        // generuj tablice bedaca rozpatrywanym elementem, kategorie danego rekordu array(a,a1,a12,...)
        $current=$this->gen_element($axy,$i,$k); 
        $this->show($current,"magenta","current<br>");
        
        // odczytaj dane ostatniego elementu $current
        $data=$this->last_data($current);
        $id=$data['id'];
        $name=$data['name'];
        
        // wyzeruj tablice
        $this->axy_tmp=array();
        
        $tree=false;     // jestem lisciem
        $num=$this->elements($axy,$current,$k);
        if ($num==1) {
            // jestem lisciem, generuj lisc
            $this->leaf($name,$id,$k);
            return;
        } elseif ($num>1) {
            // jesli to ostatni poziom kategorii, to oznacza to, ze blednie sa wprowadzone dane
            // gdyz na ostatnim poziomie nie moze byc 2 takich samych kategorii
            // (biorac takze pod uwage takze wszystkie poprzednie kategorie)
            if ($k>=$this->n) {
                // wywo³anie autonaprawy danych kategorii
                $this->_cleanCategory();
                die ($lang->error_category_tree);
            }
            
            // jestem drzewem, otworz drzewo
            $this->tree_start($name,$id,$k);
            
            // wez kolejno liscie drzewa i sprawdz czy nie sa czasem drzewami
            // odczytaj liscie drzewa
            $leafs=$this->leafs($axy,$current,$i,$k);
            
            foreach ($leafs as $x) {
                $this->show($x,"blue","leafs as x<br>");
                $ix=$this->get_i_axy($axy,$x,$k); // podaj numer pozycji $i elemntu posujacego do $x w $axy
                $current_i=$this->gen_element($axy,$ix,$k+1);
                
                $this->show($current_i,"#992277","current_i dla k=".($k+1)."<br>");
                
                $sub_axy=$this->gen_sub_axy($axy,$current_i,$k+1);
                $iy=$this->get_i_axy($sub_axy,$x,$k); // podaj numer pozycji $i elemntu posujacego do $x w $sub_axy
                
                $this->show($sub_axy,"brown","wygenerowane sub_axy: k=$k<BR>");
                
                $this->gen_tree($sub_axy,$iy,$k+1);
            }
            
            // zamknij drzewo
            $this->tree_end();
        }
        
        return $tree;
    } // end gen_tree()
    
    /**
    *  Podaj numer pozycji $i elemntu posujacego do $x w $axy
    *
    * @param array $axy
    * @param array $x rozpatrywany lisc
    * @param int $k
    * @return int pozycja 1 elementu $axy pasujacego do $x
    */
    function get_i_axy($axy,$x,$k) {
        $i=0;
        while (list(,$cat) = each($axy)) {
            $el_axy=$this->gen_element($axy,$i,$k+1);
            $this->show($el_axy,"red","el_axy $i=$i k=$k<BR>");
            $this->show($x,"brown","x $i=$i k=$k<BR>");
            if ($el_axy==$x) {
                return $i;
            }
            $i++;
        }
    } // end get_i_axy()
    
    /**
    * Generuj podtablice okreslajaca poddrzewo, skladajace sie z elementow rownych $current
    *
    * @param array $axy tablica drzewa
    * @param current biezacy element, wedlug  niego szukamy innych lelemntow z tej samej kategorii
    * @k int numer zagniezdzenia elementu
    * @return array podtablica reprezentujaca poddrzewo
    */
    function gen_sub_axy($axy,$current,$k) {
        $this->show($current,"#aabbcc","element current <BR>");
        $sub_axy=array();
        $lp=sizeof($axy);$i2=0;
        while (list($in,$tab) = each ($axy)) {
            $el_axy=$this->gen_element($axy,$in,$k);
            if ($el_axy==$current) {
                $sub_axy[$i2]=$axy[$in];
                $this->show($el_axy,"#ee33cc","element porownywany z current $in<BR>");
                $this->show($sub_axy,"cyan","sub_axy w trakcie tworzenia <BR>");
                $i2++;
            }
        }
        return $sub_axy;
    } // end gen_sub_axy()
    
    
    /**
    * Generuj element, kategorie danego rekordu
    */
    function gen_element($axy,$i,$k) {
        $tab_axy=$axy[$i];
        $tab=array();
        $i=0;
        while ((list($name,$id) = each($tab_axy)) && ($i<$k)) {
            $data=array();
            // nazwa kategorii zaczyna sie od bnazku _ na 1 poziomie lub __ na 2 poziomie
            // znaki te nalezy usunac aby uzyskac prawdziwa nazwe kategorii
            $data['name']=preg_replace("/^[_]+/","",$name);$data['id']=$id;
            array_push($tab,$data);
            $i++;
        }
        
        return $tab;
    } // end gen_element()
    
    /**
    * Znajdz elementy z tej samej kategorii
    *
    * @param array $current biezacy element, wedlug  niego szukamy innych lelemntow z tej samej kategorii
    * @param iny $k numer zagniezdzenia elementu
    * @return ilosc elementow z tej samej kategorii
    */
    function elements($axy,$current,$k) {
        reset($axy);$num=0;
        
        // $i - numer porzadkowy wiersza kategorii; $tab tablica z nazwami kategorii i id np. array("Drukarki"=>"12',"Laserowe"=>"2")
        while (list($i,$tab) = each ($axy)) {
            // generuj element nr $i z $axy uwzgledniajac $k kategorii
            $el=$this->gen_element($axy,$i,$k);
            if ($el==$current) $num++;
            
        }
        return $num;
    } // end elements()
    
    /**
    * Odczytaj wszystkie liscie drzewa (rozne liscie)
    *
    * @param array $axy tablica drzewa
    * @param int $i numer elementu z tablicy $axy
    * @param int $k numer zagniezdzenia elementu
    * @return array tablica zawierajaca liscie array($lisc1,$lisc2,...$liscn); gdzie $liscx=array()
    */
    function leafs($axy,$current,$i,$k) {
        $k2=$k+1;
        $leafs=array();
        $lp=sizeof($axy);
        while (list($i,$tab) = each ($axy)) {
            $el_axy=$this->gen_element($axy,$i,$k2);
            $el_cmp=$this->gen_element($axy,$i,$k);
            if (! $this->in_array($el_axy,$leafs)) {
                if ($el_cmp==$current) {
                    // zapamietaj liscia, (takze po to, zeby pozniej nie pokazywac tych samych lisci)
                    array_push($leafs,$el_axy);
                }
            }
        }
        
        return $leafs;
    } // end leafs()
    
    /**
    * Sprawdz czy podany element jest elementem tablicy
    *
    * @param array $el element tablicy
    * @param array $tab tablica
    * @return true - element $el jest elementem tablice $tab, false - nie jest
    */
    function in_array($el,$tab) {
        foreach ($tab as $x) {
            if ($x==$el)  return true;
        }
        return false;
    } // end in_array()
    
    /**
    * Odczytaj nazwe i id z ostniego elementu tablicy generowanej przez $this->gen_element
    *
    * @param array $tab tablica z elementami jw.
    * @retuen array nazwa i id ostatniego elementu tablicy $tab
    */
    function last_data($tab) {
        $data2=array();
        $data2['id']="";
        foreach ($tab as $data) {
            $data2['name']=preg_replace("/^[_]+/","",$data['name']);
            $data2['id'].=$data['id']."_";
        }
        // obetnij ostatni znak "_"
        $data2['id']=substr($data2['id'],0,strlen($data2['id'])-1);
        return $data2;
    } // end last_data()
    
    /**
    * Generuj kod PHP dla liscia
    */
    function leaf($name,$id,$k) {
        if ($k>1) {
            $tabk = str_repeat("    ",$k);
            $this->php.="\"$name\"=>\"$id\",";
        } else {
            $this->php.="(array(\"name\"=>\"$name\");\n ";
        }
        return "leaf";
    } // end leaf()
    
    /**
    * Generuj kod PHP dla drzewa
    */
    function tree_start($name,$id,$k) {
        $tabk = str_repeat("    ",$k);
        if ($k==1) {
            $this->php.="array(\"name\"=>\"$name\",\"elements\"=>array(";
        } else {
            $this->php.="array(\"$id\"=>array(\"name\"=>\"$name\",\"elements\"=>\narray(";
        }
        return "tree";
    }
    function tree_end(){
        // obetnij przecinek po osttnim lisciu
        $this->php=substr($this->php,0,strlen($this->php)-1);
        $this->php.="))),";
        return;
    } // end tree_end()
    
    /**
    * Generowanie tablicy podkategorii. Wynik jest zapamietywany w zmiennej $this->php
    *
    * @param string $WHERE ograniczenie wynikow np. filtr wg producenta
    * @return kod PHP z definicja tablicy kategorii np.:
    * <?php
    * $category['id_0']=array("name"=>"Komputery","elements"=>array(
    *                                                               array("2"=>array("name"=>"Mac","elements"=>
    *                                                                          array("G3"=>"3","G4"=>"2"))),
    *                                                               "PC"=>"1")
    *                         );
    * ?>
    */
    function gen_category_tab($WHERE='') {
        global $stream;
        
        $db2array=$this->db2array($WHERE);
        if ($db2array==false) {
            return false;
        }
        
        $category=array();
        
        $this->php="<?php \n\n";
        $this->php.="\$category=array();\n\n";
        
        $i=0;
        while (list(,$cat) = each($this->axy)) {
            
            // wyswietl info w postaci paska statusu
            $stream->line_blue();
            flush();
            
            $key_first_element=key($cat);
            $id=$cat[$key_first_element]; // id glownej kategorii produktu
            
            $el=$this->gen_element($this->axy,$i,1);
            if (! $this->in_array($el,$category)) {
                // otworz glowna tablice kategorii
                $this->php.="\$category['id_$id']=";
                
                $this->gen_tree($this->axy,$i,1);
                array_push($category,$el);
                
                // obetniej ))), po osttnim zamknieciu drzewa
                $this->php=substr($this->php,0,strlen($this->php)-4);
                // zamknij glowna tablice kategorii
                $this->php.="));\n";
                
            }
            $i++;
        }
        
        $this->php.="$this->extra_code\n\n?>\n";
        return $this->php;
    } // end gen_category_tab()
    
    /**
    * Zapisz wygenerowane kategorie w pliku
    *
    * @param string $body     tresc zapisywanego pliku
    * @param string $dir      katalog ftp w ktorym zostanie umieszczony plik za danymi $file
    * @param string $file     plik ftp w ktorym zostana zapisane dane wzgledem $DOCUMENT_ROOT/
    * @param string $file_tmp tymczasowy plik
    */
    function save($body,$dir="config/tmp",$file="category.php",$file_tmp="tmp/category.php") {
        global $DOCUMENT_ROOT;
        global $config,$ftp;
        
        // zapisz kod w tymczasowym pliku
        if ($fd=@fopen("$DOCUMENT_ROOT/$file_tmp","w+")) {
            fwrite($fd,$body,strlen($body));
            fclose($fd);
        } else {
            global $theme;
            $theme->head_window();
            die ("Forbidden $file_tmp");
        }
        
        // wstaw dane w odpowiednie miejsce (przez ftp)
        $ftp->put("$DOCUMENT_ROOT/$file_tmp",$config->ftp_dir."/$dir",$file);
        
        return;
    } // end save()
    
    /**
    * Generuj kategorie i zapisz dane w pliku
    *
    * @param string $dir      katalog ftp w ktorym zostanie umieszczony plik za danymi $file
    * @param string $file     plik ftp w ktorym zostana zapisane dane wzgledem $DOCUMENT_ROOT/
    * @param string $file_tmp tymczasowy plik
    * @param string $WHERE    ograniczenie wynikow np. filtr wg producenta (patrz funkcja $this->db2array() )
    *
    * @public
    */
    function update_category_file($dir="config/tmp",$file="category.php",$file_tmp="tmp/category.php",$WHERE='') {
        global $lang;
        if (! $this->gen_category_tab($WHERE)) {
            $this->php="<?php ".$this->extra_code."\$category['id_0']=array(\"name\"=>\"$lang->empty_main\",\"elements\"=>array(\"$lang->empty_main\"=>\"0\")); ?>";
        }
        
        // zapisz dane w pliku i wrzuc plik przez FTP do odpowiedniego katalogu
        $this->save($this->php,$dir,$file,$file_tmp);
        
        return(0);
    } // end update_category_file()
    
    
    
    /**
    * Autonaprawa danych kategorii (próba usuniêcia komunikatru o b³êdnych danych kategorii)
    *
    * @return none
    */
    function _cleanCategory() {
        global $db;
        $query[]="UPDATE main SET id_category2=0,category2='' WHERE id_category2 is NULL OR category2=''";
        $query[]="UPDATE main SET id_category3=0,category3='' WHERE id_category3 is NULL OR category3=''";
        $query[]="UPDATE main SET id_category4=0,category4='' WHERE id_category4 is NULL OR category4=''";
        $query[]="UPDATE main SET id_category5=0,category5='' WHERE id_category5 is NULL OR category5=''";
        reset($query);
        foreach ($query as $sql) {
            $result=$db->Query($sql);
            if ($result!=0) {} else die ($db->Error());
        }
        return;
    } // end _cleanCategory()
    
    /**
    * Debug
    */
    function show($tab,$color="brown",$name="") {
        return;
        print "<font color=$color>$name";
        foreach ($tab as $x) {
            print_r($x);
            print "<br>";
        }
        print "</font>";
    } // end show()
    
    
} // end class DB2Catgory

?>

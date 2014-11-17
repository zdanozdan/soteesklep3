<?php
/**
* Stworz liste produkcentow dla kazdej kategorii
*
* @global  array $__category lista kategorii z config/tmp/category.php
* @global object $stream obiekt klasy Stream -> obsluga status bar'a
*
* @author  m@sote.pl
* @version $Id: producer.inc.php,v 2.22 2006/03/20 10:47:05 lukasz Exp $
* @package soteesklep
*/

if (@$__secure_test!=true) die ("Bledne wywolanie");

require_once ("include/ftp.inc.php");
require_once ("config/tmp/category.php");

global $stream;

class ProducerCategory {
    var $cidcs=array();             // lista id kategorii; dostepnwe wartosci parametrow idc i cidc
    // przekazywanych do /htdocs/go/_category/index.php
    var $producers=array();         // lista producentow dla poszczegolnych ID
    // np. array("id_1"=>array(array("HP"=>"1"),array("Canon"=>"2")),"1_2"=>array(aray("HP"=>"3")),...)
    
    /**
    * Wyszukaj id kategorii/podkategorii z tablicy danych
    *
    * @param  array $data_tab tablica danych kategorii/podkategorii
    * @global array $this->cidcs array("1","1_2","1_3","3","3_4","3_4_6","3_4_7") itp.
    */
    function parse($data_tab=array()) {
        reset($data_tab);
        //        foreach ($data_tab as $data) {
        while (list($key,$data) = each($data_tab)) {
            if ((ereg("^[0-9_]+",$key)) || (ereg("^id_[0-9]+",$key))) {
                if (! empty($key)) array_push($this->cidcs,$key);
            }
            if (is_array($data)) {
                $this->parse($data);
            } else {
                if ((ereg("^[0-9_]+",$data)) || (ereg("^id_[0-9]+",$data))) {
                    array_push($this->cidcs,$data);
                }
            }
        } // end foreach
    } // end parse
    
    /**
    * Generuj dane $category_tab do fukcji $this->query()
    */
    function gen_category_tabs() {
        global $stream;
        
        reset($this->cidcs);
        foreach ($this->cidcs as $idc) {
            
            // wyswietl pasek status bar
            $stream->line_green();
            flush();
            
            $category_tab=array();
            if (ereg("^id_",$idc)) {
                $id=ereg_replace("id_","",$idc);   // dla np. $idc=id_15
                // jest 1 kategoria
                if (ereg("^[0-9]+$",$id)) {
                    $category_tab[0]=$id;
                }
            } else {
                if  (ereg("_",$idc)) {
                    // jest wiecej niz 1 kategoria
                    $category_tab=split("_",$idc,20);
                } else {
                    // jest 1 kategoria
                    if (ereg("^[0-9]+$",$idc)) {
                        $category_tab[0]=$idc;
                    }
                }
            } // end if
            
            // generuj SQL - zapytaj sie o liste producentow w danej kategorii
            if (sizeof($category_tab)>0) {
                
                $query=$this->query($category_tab);
                
                // generuj liste producentow
                $category_producers=$this->producer_list($query);
//                echo "<pre>";
//                print_r($query);
//                echo "</pre>";
                // zapamietaj liste producentow dla danej kategorii (dla danej wartosci $idc)
                $this->producers[$idc]=$category_producers;
            }
        } // end foreach
    } // end gen_category_tabs()
    
    /**
    * Generuj zapytanie SQL o producentow w danej kategorii
    *
    * @param array $category_tab array("1","3","5") oznacza category1=1 category2=3 category3=5
    * @return string SQL
    */
    function query($category_tab) {
        global $theme;
        
        $sql="SELECT producer,id_producer FROM main WHERE active=1 AND ";
        
        $size=sizeof($category_tab);
        reset($category_tab);
        for ($i=0;$i<$size;$i++) {
            if (! ereg("^[0-9]+$",$category_tab[$i])) {
                die  ("<center>Bledne wywolanie</center>");
            }
            $k=$i+1; // 0->1, 1->2 itd.
            $sql.="id_category$k = '$category_tab[$i]' AND ";
        }
        //        $sql=substr($sql,0,strlen($sql)-4);
        $sql.="producer!='' AND id_producer>0 GROUP BY producer,id_producer ORDER BY producer";
        
        // print $sql."<BR>";
        
        return $sql;
    } // end query()
    
    /**
    * Generuj liste proucentow dla okreslonych kategorii
    *
    * @param string $query zapytanie sql o producentow w danej kategorii
    * @return array tablica z producentami i id producentow
    *               np. array(array("HP"=>"1"),array("Canon"=>"2"))
    */
    function producer_list($query) {
        global $db;
        
        $tab=array();
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->Query($query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $producer=$db->FetchResult($result,$i,"producer");
                        $id_producer=$db->FetchResult($result,$i,"id_producer");
                        $producer=addslashes($producer);
                        $tab2=array();
                        $tab2[$producer]=$id_producer;
                        array_push($tab,$tab2);
                    } // end for
                } // end if
            } else die ($db->Error());
        } else die ($db->Error());
        
        return $tab;
    } // end producer_list()
    
    /**
    * Genruj kod PHP z listami producentow
    */
    function gen_php() {
        reset($this->producers);
        if ((empty($this->producers)) || (key($this->producers)=="id_0"))  {
            $php="<?php\n\n";
            $php.="global \$__producers;\n\n";
            $php.="\$__producers=array();\n?>";
            return $php;
        }
        $php="<?php\n\n";
        $php.="global \$__producers;\n\n";
        $producers_serialized = serialize($this->producers);
        $php .= "\$__producers=unserialize('$producers_serialized');";
        /*
        $php.="\$__producers=array(";
        reset($this->producers);
        
        while (list($id,$data) = each ($this->producers)) {
            if (sizeof($data)>0) {
                $php.="\"$id\"=>array(";
                while (list($idc,$cat_tab) = each($data)) {
                    $producer_name=key($cat_tab);
                    $producer_id=$cat_tab[$producer_name];
                    $php.="array(\"$producer_name\"=>\"$producer_id\"),";
                } // end while
                $php=substr($php,0,strlen($php)-1);
                $php.="),\n\t           ";
            }
        }  // end while
        $php=substr($php,0,strlen($php)-(3+11));
        
        $php.=");\n";
        */
        $php.="\n";
        $php.="?>\n";
        /*
        echo "<pre>";
        print_r($this->producers);
        echo "</pre>";
        */
        return $php;
    } // end gen_php()
    
    
    /**
    * Zapisz wygenerowane listy producentow w pliku
    *
    * @param  string $body tresc zapisywanego pliku
    */
    function save($body) {
        global $DOCUMENT_ROOT;
        global $config,$ftp;
        
        // jezeli nie ma zadnych producentow - nic nie rob
        if (empty($body)) return;
        // zapisz kod w tymczasowym pliku
        if  ($fd=@fopen("$DOCUMENT_ROOT/tmp/producer.php","w+")) {
            fwrite($fd,$body,strlen($body));
            fclose($fd);
        } else {
            global $theme;
            $theme->head_window();
            die ("Forbidden tmp/producer.php");
        }
        
        // wstaw dane w odpowiednie miejsce (przez ftp)
        $ftp->put("$DOCUMENT_ROOT/tmp/producer.php",$config->ftp_dir."/config/tmp","producer.php");
        
        return;
    } // end save()
    
} // end class ProducerCategory

$pcat = new ProducerCategory;
$pcat->parse($__category);
$pcat->gen_category_tabs();

// start sprawdz czy jest jakis producent: w bazie, jesli jest top generuj kod PHP, jesli nie ma to nic nie generuj
$is_producer=false;
$query="SELECT id_producer,producer FROM main WHERE producer!='' AND id_producer>0 AND active=1 LIMIT 1";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) $is_producer=true;
} else die ($db->Error());

if ($is_producer==true) {
    $body=$pcat->gen_php();
}
// end sprawdz czy jest jakis producent

// generuj liste wszystkich producentow
$all_p=$pcat->producer_list("SELECT id_producer,producer FROM main WHERE producer!='' AND id_producer>0 AND active=1 GROUP BY id_producer,producer ORDER BY producer");
if (! empty($all_p)) {
    $body.="\n\n<?php\n\n";
    $body.="\$__all_producers=array(\n";
    foreach ($all_p as $p) {
        $producer=key($p);
        $id_producer=$p[$producer];
        $producer=addslashes($producer);
        $body.="\t\t      \"$producer\"=>\"$id_producer\",\n";
    }
    $body=substr($body,0,strlen($body)-2);
    $body.="\n\t\t      );\n?>";
}
$pcat->save(@$body);
?>

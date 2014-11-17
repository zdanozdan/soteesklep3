<?php
/**
* Google - klasy i funkcje
*
* @author  m@sote.pl
* @version $Id: google.inc.php,v 1.12 2005/09/13 10:18:57 lukasz Exp $
* @package google
*/

/**
* Google main
*/
require_once ("include/google_main.inc");

/**
* Google Sitemap
*/
require_once ("./include/google_sitemap.inc.php");

/**
* Klasa Google.
* @package google
*/
class Google extends GoogleMain {

    var $action="stat_pages_products.php";
    var $max_file_size="47104";      // 46k
    var $max_tmpl_file_size="4096";  // 4k

    /**
    * @var array Pliki statyczne, ktore bêd± generowane jako strony HTML
    */
    var $_statFiles=array(
    "terms.html"=>"1",
    "about_company.html"=>"1",
    "contact.html"=>"1",
    "about_shop.html"=>"1",
    "help.html"=>"1"
    );
	
    /**
    * @var wersja sklepu dla której generowane s± pliki - 1 oznacza wersje 3.1 lub wy¿sz±?
    */
    var $shop_version;
    
    /**
    * @var object obiekt GoogleSitemap - dotyczy mapy stron statycznych
    */
    var $sitemap;

    /*
    * @var object obiekt GoogleSitemap - dotyczy mapy dynamicznych stron
    */
    var $sitemap2;

    /**
    * @var array Okre¶lenie priorytetow ró¿nych rodzajów stron
    */
    var $_priority=array("html"=>'0.5',"cat"=>"0.9","product"=>"0.8","main_html"=>'0.9');

    /**
    * @var array okre¶lenie czêstotliwo¶ci aktualizacji ró¿nych typów stron
    */
    var $_freq=array("html"=>"monthly","cat"=>"weekly","product"=>"monthly","main_html"=>"weekly");

    /**
    * Konstruktor.
    */
    function Google() {
        global $DOCUMENT_ROOT,$config;

        $this->sitemap  =& new GoogleSitemap();  // mapa statyczna  (stron statycznych)
        $this->sitemap2 =& new GoogleSitemap();  // mapa dynamiczna (stron dynamicznych)

        // odczytaj date modyfikacji pliki html/index.html -> to jest data generowania stron statycznych html
        $filename=$DOCUMENT_ROOT."/../htdocs/html/index.html";
        if (file_exists($filename)) {
            $this->_lastmod=date("Y-m-d", filectime($filename));
        } else {
            $this->_lastmod=date("Y-m-d");
        }

        
		ereg("3\.([0-9])",$config->version,$matches);
		if (isset($matches[1])) {
			$this->shop_version=1;
		} else {
			$this->shop_version=0;
		}
        $this->sitemap->add("http://".$config->www."/google.php",$this->_lastmod,$this->_priority['main_html'],$this->_freq['main_html']);
        $this->sitemap2->add("http://".$config->www."/",date("Y-m-d"),1,"daily");

        return;
    } // end Google()


    /**
    * Formularz wywo³ania startu generowania stron statycznych dla produktow
    */
    function formStatProductPages() {
        global $lang;
        print "<p />\n";
        print "<form action=\"$this->action\" method=POST target=\"import\">\n";
        print "<input type=\"submit\" value=\"$lang->google_submit\" onclick=\"window.open('', 'import', 'width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0')\">\n";
        print "</form>\n";
    } // end formStatProductPages()

    /**
    * Generuj strony statyczne dla Google
    */ 
    function genStatProductPages() {
        global $db,$stream;
        global $ftp,$config;

        $ftp->connect();
        $this->_readProductTemplate();
        $query="SELECT * FROM main ORDER BY id";
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($num_rows>0) {
                $_prev=array();

                for ($i=0;$i<$num_rows+1;$i++) {
                    $user_id=$db->fetchResult($result,$i,"user_id");
                    $user_id = urlencode($user_id);
                    $name=$db->fetchResult($result,$i,"name_L0");
                    $name.=$db->fetchResult($result,$i,"name");                                        
                    $page=$this->_genStatPage($result,$i);
                    $filename=$this->_filenameProduct($result,$i);                    
                    $description=$db->fetchResult($result,$i,"xml_description_L0");
                    $description.=$db->fetchResult($result,$i,"xml_description");
                    $date_update=$db->fetchResult($result,$i,"date_update");
                    if ((! empty($date_update)) && (ereg("^[0-9]{14}$",$date_update))){
                        $date_update=substr($date_update,0,4)."-".substr($date_update,4,2)."-".substr($date_update,6,2); // YYYY-MM-DD
                    } elseif (ereg("^[0-9]{4}\-[0-9]{2}\-[0-9]{2}",$date_update)) {
                        // 2004-05-10 12:34
                        $date_update=substr($date_update,0,10);
                    } else {
                        // w date_update nie rozpoznano formatu timestamp np.: 20050530161521                        
                        $date_update='';
                    } 
    				if ($i>1) {
                        $next="/html/$filename";
                        if (! empty($_prev_2['filename'])) {
                            $prev="/html/".$_prev_2['filename'];
                        } else $prev="#";                        
                        if ($i==$num_rows) $next="#";
                                  
                        $this->_installPage("html/".$_prev['filename'],$_prev['page'],array("prev"=>$prev,"next"=>$next,"map"=>""),$_prev['date_update']);
                        $this->_add2Sitemap2("product",$_prev['user_id'],$_prev['date_update']);


                    }
                    if ($i==1) {
                            // index.html - zawarto¶æ taka jak pierwszego produktu
                            $next=$this->_filenameProduct($result,$i-1);
                    		$map=$this->genProductMap(); // mapa - lista produktów
                            $this->_installPage("html/index.html",$_prev['page'],array("prev"=>'/../google.php',"next"=>$next,"map"=>$map),
                            $date_update);
                            $stream->line_blue();
                        }
                    if ($i==0) {
                    	// pierwszy produkt
                    	$next=$this->_filenameProduct($result,$i+1);
                        $this->_installPage("html/$filename",$page,array("prev"=>"index.html","next"=>$next,"map"=>""),
                        $date_update);
                        $stream->line_blue();
                    }
                    // zapamiêtaj stronê, która bêdzie instalowana w kolejnym przej¶ciu pêtli
                    $_prev_2=$_prev;                   // zapamiêtanie 2 kroków wstecz
                    $_prev['filename']=$filename;
                    $_prev['user_id']=$user_id;
                    $_prev['date_update']=$date_update;
                    $_prev['page']=$page;

                    $stream->line_blue();
                }
            }
        } else die ($db->error());

        return;
    } // end genStatProductsPages()

    /**
    * Generuj nazwe pliku dla storny statycznej produktu
    *
    * @param mixed &$result wynik zapytania z bazy danych
    * @param int   $i      wiersz wyniku zapytania SQL
    */
    function _filenameProduct(&$result,$i) {
        global $db;

        $id=$db->fetchResult($result,$i,"id");
        $filename=$id.".html";

        return $filename;
    } // end _filenameProduct()

    /**
    * Odczytaj szablon produktu i zapamiêtaj
    *
    * @access private
    * @return void
    */
    function _readProductTemplate() {
        $file="./html/template_product.html.php";
        $fd=fopen($file,"r");
        $this->_templateProduct=fread($fd,filesize($file));
        fclose($fd);
        return;
    } // end _readProductTemplate()

    /**
    * Generuj stronê statyczn± dla 1 produktu.
    *
    * @param mixed &$result wynik zapytania z bazy danych
    * @param int   $i      wiersz wyniku zapytania SQL
    *
    * @access private
    * @return string zawarto¶æ strony
    */
    function _genStatPage(&$result,$i) {
        global $db;

        $d=array();
        $d['title']=$db->fetchResult($result,$i,"name_L0");
        $d['title'].=$db->fetchResult($result,$i,"name");
        $d['producer']=$db->fetchResult($result,$i,"producer");
        $d['short_description']=$db->fetchResult($result,$i,"xml_short_description_L0");
        $d['short_description'].=$db->fetchResult($result,$i,"xml_short_description");
        $d['description']=$db->fetchResult($result,$i,"xml_description_L0");
        $d['description'].=$db->fetchResult($result,$i,"xml_description");
        $d['user_id']=$db->fetchResult($result,$i,"user_id");

        $google_title=$db->fetchResult($result,$i,"google_title");
        $google_keywords=$db->fetchResult($result,$i,"google_keywords");
        $google_description=$db->fetchResult($result,$i,"google_description");

        if (! empty($google_title)) {
            $d['title']=$google_title;
        }

        if (empty($google_keywords)) {
            $d['keywords']=$this->keywords().", ".$d['title'].", ".$d['producer'];
        } else {
            $d['keywords']=$google_keywords;
        }
		
        
        if (empty($google_description)) {
            $description=$d['description'];
            // ogranicz tekst do 128 znaków, obetnij HTMLe
            require_once ("SDConvertText/class.SDConvertText.php");
            $sdc =& new SDConvertText();
            $description=$sdc->dropHTML($description,'');
            $description=$sdc->shortText($description,128);
            $description=preg_replace("/[\s]+/"," ",$description);
            $d['meta_description']=$description;
        } else {
            $d['meta_description']=$google_description;
        }

        $o=$this->_templateProduct;

        reset($d);
        foreach ($d as $key=>$d1) {
            $o=ereg_replace("\{$key\}",$d[$key],$o);
        }

        return $o;
    } // end _genStatPage()

    /**
    * Generuj mapê listy produktów
    *
    * @param int $limit ilo¶c produktów losowych wygenerowanych w mapie
    * @return string lista w formacie HTML
    */
    function genProductMap($limit=1000) {
        global $db,$stream;

		// s/id/user_id/
        $o='';$d=array();
        // uzale¿nij sk³adnie zapytania 
        if ($this->shop_version) { 
        	$query="SELECT id,user_id,name_L0,producer FROM main ORDER BY rand() LIMIT $limit";
        } else {
	        $query="SELECT id,user_id,name,producer FROM main ORDER BY rand() LIMIT $limit";
        }
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($num_rows>0) {
                $o="<ul>\n";
                for ($i=0;$i<$num_rows;$i++) {
                    $d['id']=$db->fetchResult($result,$i,"id");
                    $d['user_id']=$db->fetchResult($result,$i,"user_id");
                    $d['name']=$db->fetchResult($result,$i,"name");
                    $d['name'].=$db->fetchResult($result,$i,"name_L0");
                    $d['producer']=$db->fetchResult($result,$i,"producer");
                    $o.="<li><a href=\"/html/".$d['id'].".html\">".$d['name']." ".$d['producer']."</a></li>";
                    $stream->line_green();
                }
                $o.="</ul>\n";
            }
        } else die ($db->error());

        return $o;
    } // end genProductMap()

    /**
    * Instaluj strone HTML w katalogu
    *
    * @param string $path        ¶cie¿ka wzglêdem htdocs + nazwa pliku
    * @param string $source      zawarto¶æ strony
    * @param array  $data        tablica z podstawieniami do szablonów np. array("next"=>"test.html"), odpowiada szablonowi {next}
    * @param string $date_update data aktualizacji strony YYYY-MM-DD
    *
    * @access private
    * @return bool
    */
    function _installPage($path,$source,$data=array(),$date_update='') {
        global $ftp,$DOCUMENT_ROOT,$config,$google_config,$lang;

        $filename=basename($path);
        $dir=dirname($path);
        $tmp_file=$DOCUMENT_ROOT."/tmp/$filename";

        // podstaw dane pod {logo} {ww} {style}
        if (empty($data['css'])) {
            $css_file="/themes/base/google/_style/".$google_config->keyword_plain.".css";
            $data['css']=$css_file;
        }
        if (empty($data['www'])) {
            $data['www']="<a href=\"/\">$lang->google_www_text $config->www</a>";
        }
        if (empty($data['logo'])) {
            $data['logo']="<a href=\"http://$config->www\"><img src=\"/themes/base/google/_img/$google_config->logo\" title=\"".$google_config->keywords[0]."\" alt=\"".$google_config->keywords[0]."\" border=\"0\"></a>\n";
        }
		if (empty($data['prev'])) {
			$data['prev']="/html/index.html";
		}
        // wstaw odpowiednie warto¶ci do szablonów; podstawienia pod {next} itp.
        reset($data);
        foreach ($data as $key=>$val) {
            $source=ereg_replace("\{$key\}",$val,$source);
        }

        // print "<pre>";print_r($source);print "</pre>";

        if ($fd=fopen($tmp_file,"w+")) {
            fwrite($fd,$source,strlen($source));
            fclose($fd);

            $ftp->put($tmp_file,$config->ftp['ftp_dir']."/htdocs/".$dir,$filename);

            // dodaj adres do sitemap
            $this->_add2Sitemap($path,$date_update);

            return true;
        } else {
            return false;
        }
    } // end _installPage()

    /**
    * Dodaj adres do sitemap
    *
    * @param string $path        adres wzglêdem /
    * @param string $date_update data aktualizacji strony
    *
    * @access private
    * @return void
    */
    function _add2Sitemap($path,$date_update) {
        global $config;
        if (ereg("^\.",$path)) $path=substr($path,1,strlen($path));
        if (ereg("html_",$path)) {
            $priority=$this->_priority['html'];
            $freq=$this->_freq['html'];
        } elseif (ereg("cat_",$path)) {
            $priority=$this->_priority['cat'];
            $freq=$this->_freq['cat'];
        } else {
            $priority=$this->_priority['product'];
            $freq=$this->_freq['product'];
        }

        if (! ereg("^\/",$path)) $path="/$path";
        $this->sitemap->add("http://".$config->www.$path,$date_update,$priority,$freq);
        return;
    } // end _add2Sitemap()

    /**
    * Dodaj stronê do sitemap2
    *
    * @param string $type typ strony
    * @param string $data parametr np. id produktu, nazwa pliku, id produktu
    * @param string $date_update data aktualizacji
    *
    * @access private
    * @return void
    */
    function _add2Sitemap2($type,$data,$date_update='') {
        global $config;
        
        if (! empty($data)) {
            switch ($type) {
                case "html":                
                $this->sitemap2->add("http://".$config->www."/go/_files/?file=$data",$date_update,$this->_priority['html'],$this->_freq['html']);
                break;
                case "product":
                $this->sitemap2->add("http://".$config->www."/go/_info/?user_id=$data",$date_update,$this->_priority['product'],$this->_freq['product']);
                break;
                case "cat":
                $this->sitemap2->add("http://".$config->www."/go/_category/?idc=$data",$date_update,$this->_priority['cat'],$this->_freq['cat']);
                break;
            }
        }
        return;
    } // end _add2Sitemap()

    /**
    * Generuj stronê tekstow± w w wersji HTML
    *
    * @return void
    */
    function genHTMLPages() {
        global $lang,$config,$DOCUMENT_ROOT,$stream,$ftp;

        $ftp->connect();

        require_once ("go/_wysiwyg/config/config.inc.php");

        // nadpisz listeplikow z configa lista plikow lokalnie zdefiniowanych
        $config->wysiwyg_files[$config->htdocs_lang]=$this->_statFiles;

        /*
        * Generuj strone i-1 z linkiem do strony i. W ostatnim kroku generuj strony i-1 i i.
        */
        reset($config->wysiwyg_files[$config->htdocs_lang]); $file_data=array(); $i=0; $n=sizeof($config->wysiwyg_files[$config->htdocs_lang]);
        foreach ($config->wysiwyg_files[$config->htdocs_lang] as $filename=>$data) {

            // generuj naglowek strony html
            $file="./html/head.html";
            $fd=fopen($file,"r");
            $head=fread($fd,filesize($file));
            fclose($fd);

            // generuj stopke strony html
            $file="./html/foot.html";
            $fd=fopen($file,"r");
            $foot=fread($fd,filesize($file));
            fclose($fd);

            $file_html="$DOCUMENT_ROOT/../htdocs/themes/_$config->htdocs_lang/_html_files/$filename";
            $fd=fopen($file_html,"r");
            $page=$head.fread($fd,filesize($file_html)).$foot;
            fclose($fd);

            // zapamiêtaj dane pliku: nazwe, zawarto¶æ
            $file_data[$i]=array("filename"=>$filename,"page"=>$page);

            // pomiñ 1 przej¶cie, po to, ¿eby poznaæ link do kolejnej strony i pó¼niej wstawiæ go do 1 strony
            if ($i>0) {
                $data=array();
                $data['next']="/html/html_".$file_data[$i]['filename'];
                if (empty($file_data[$i-2]['filename'])) {
                    $data['prev']="/";
                } else {
                    $data['prev']="/html/html_".$file_data[$i-2]['filename'];
                }

                $data['title']=$this->title();
                $data['keywords']=$this->keywords();
                $data['description']=$this->description();

                $filename=$file_data[$i-1]['filename'];
                $page=$file_data[$i-1]['page'];
                
                $date_update=$this->_filectime($filename);
                $this->_installPage("html/html_$filename",$page,$data,$date_update);
                $this->_add2Sitemap2("html",$filename,$date_update);
                
                $stream->line_blue();

                // poniewa¿ na pocz±tku pominêli¶my 1 przej¶cie, to w ostatnim kroku musimy wygenerowaæ dodatkwo
                // stronê dla ostatniego elementu - ostatniej strony HTML
                if ($i==$n-1) {
                    $data=array();
                    $data['next']="/html/index.html"; // przej¶cie do listy produktów
                    $data['prev']="/html/html_".$file_data[$i-1]['filename'];
                    $data['title']=$this->title();
                    $data['keywords']=$this->keywords();
                    $data['description']=$this->description();

                    $filename=$file_data[$i]['filename'];
                    $page=$file_data[$i]['page'];
                    
                    $date_update=$this->_filectime($filename);
                    $this->_installPage("html/html_$filename",$page,$data,$date_update);                    
                    $this->_add2Sitemap2("html",$filename,$date_update);
                    
                    $stream->line_blue();
                }
            }

            $i++;
        }
        // end

        return;
    } // end genHTMLPages()

    /**
    * Generuj strony kategorii    
    */
    function genCat() {
        global $__category;
        require_once ("config/tmp/category.php");

        $this->_idc=array();
        foreach ($__category as $id=>$tab) {
            $this->_idc[]=substr($id,3,strlen($id)-3);
            $this->_parseCat($tab);
        }

        $this->_genPagesIDC();

        return;
    } // end genCat()

    /**
    * Odczytaj date aktualizacji pliku HTML
    *
    * @param string $filename nazwa pliku html z _html_files
    *
    * @access private
    * @return string data aktualizacji pliku YYY-MM-DD
    */
    function _filectime($filename) {
        global $DOCUMENT_ROOT,$config;
        // odczytaj date modyfikacji pliku; date("F d Y H:i:s.", filectime($filename)
        $file=$DOCUMENT_ROOT."/../htdocs/themes/_$config->htdocs_lang/_html_files/$filename";
        if (file_exists($file)) {
            return date("Y-m-d",filectime($file));
        } else return "0000-00-00";
    } // end _filectime()

    /**
    * Odczytaj i zapamiêtaj warto¶æi IDC z listy katregorii
    * 
    * @param array $tab tablica kategorii
    *
    * @access private
    * @return void
    */
    function _parseCat($tab) {
        foreach ($tab as $key=>$val) {
            if (is_array($val)) {
                $this->_parseCat($val);
            } else {
                if (ereg("^[0-9_]+$",$val)) {
                    $this->_idc[]=$val;
                    // sprawdz czy wyzsze poziomy danej kategorii sa zapisane
                    // np. jesli mamy 44_213_41 to sprawdzamy czy sa zapisane 44_213
                    $tab2=split("_",$val,5); $idct2=$tab2[0]."_";
                    for ($i=1;$i<sizeof($tab2);$i++) {
                        $idct2.=$tab2[$i];
                        if (! in_array($idct2,$this->_idc)) {
                            $this->_idc[]=$idct2;
                        }
                        $idct2.="_";
                    } // end for
                }
            }
        }
        return;
    } // end _parseCat()

    /**
    * Generuj strony dla kategorii, analiza listy $this->idc
    */
    function _genPagesIDC() {
        global $db,$db2;

        reset($this->_idc);$db2=$db;$k=0;
        foreach ($this->_idc as $id=>$idc) {

            $this->_add2Sitemap2("cat",$idc,date("Y-m-d")); // dodaj adres do mapy

            $db=$db2;
            $tab=split("_",$idc);
            $l=sizeof($tab);
            $where='';
            for ($i=1;$i<=$l;$i++) {
                $where.="id_category$i='".$tab[$i-1]."' AND ";
            }
            $where=substr($where,0,strlen($where)-5);
            $query="SELECT * FROM main WHERE $where ORDER BY rand() LIMIT 10";
            //  "query=$query ";
            $result=$db->query($query);
            if ($result!=0) {
                // generuj strone dla kategorii
                if ($k==0) $prev_k=0; else $prev_k=$k-1;
                if ($k==sizeof($this->_idc)-1) $next_k=$k; else $next_k=$k+1;
                $this->_genOnePageIDC($result,$idc,$this->_idc[$prev_k],$this->_idc[$next_k]);
            } else die ($db->error());
            $k++;
        }
        return;
    } // end _genPagesIDC()

    /**
    * Generuj 1 stronê HTML dla wskazanej kategorii
    *
    * @param mixed  $result   wynik zapytania z bazy danych
    * @param string $idc      IDC kategorii
    * @param string $idc_prev poprzedniej kategorii
    * @param string $idc_next nastêpnej kategorii
    *
    * @access private
    * @return void
    */
    function _genOnePageIDC(&$result,$idc,$prev_idc,$next_idc) {
        global $db;
        global $stream;
        global $lang;

        // print "IDC: &lt; $prev_idc |<b>$idc</b>| $next_idc &gt;<br />\n";

        // head
        $file="./html/head.html";
        $fd=fopen($file,"r");
        $head=fread($fd,filesize($file));
        fclose($fd);

        // foot
        $file="./html/foot.html";
        $fd=fopen($file,"r");
        $foot=fread($fd,filesize($file));
        fclose($fd);

        $num_rows=$db->numberOfRows($result);$body='';
        for ($i=0;$i<$num_rows;$i++) {
            $d=array();
            $d['id']=$db->fetchResult($result,$i,"id");
            $d['name']=$db->fetchResult($result,$i,"name_L0");
            $d['name'].=$db->fetchResult($result,$i,"name");
            $d['category1']=$db->fetchResult($result,$i,"category1");
            $d['category2']=$db->fetchResult($result,$i,"category2");
            $d['category3']=$db->fetchResult($result,$i,"category3");
            $d['category4']=$db->fetchResult($result,$i,"category4");
            $d['category5']=$db->fetchResult($result,$i,"category5");
            $d['producer']=$db->fetchResult($result,$i,"producer");
            $d['description']=$db->fetchResult($result,$i,"xml_description_L0");
            $d['description'].=$db->fetchResult($result,$i,"xml_description");

            $body.="
            <table width=\"50%\"><tr><td>
            <a href=\"/html/".$d['id'].".html\">".$d['name']."</a><p />
            ".$d['producer']."
            <p />\n<b>".$lang->google_categories."</b><h3>".$d['category1']."</h3> ".$d['category2']." ".$d['category3']." ".$d['category4']." ".$d['category5']."<p />
            ".$d['description']."
            </table> <hr />";

        } // end for

        $page=$head.$body.$foot;

        if (ereg("^[0-9]+$",$idc)) $idc="id_$idc";
        if (ereg("^[0-9]+$",$prev_idc)) $prev_idc="id_$prev_idc";
        if (ereg("^[0-9]+$",$next_idc)) $next_idc="id_$next_idc";

        $prev="/html/cat_$prev_idc".".html";
        $next="/html/cat_$next_idc".".html";

        $this->_installPage("./html/cat_$idc".".html",$page,
        array("prev"=>$prev,"next"=>$next,"keywords"=>$this->keywords(),"description"=>$this->description(),
        "title"=>$this->title()),date("Y-m-d"));
        $stream->line_green();

        return;
    } // end _genOnePageIDC()

    /**
    * Destruktor
    */
    function close() {
        global $ftp;
        $ftp->close();
        return true;
    } // end close()

} // end class Google()

?>
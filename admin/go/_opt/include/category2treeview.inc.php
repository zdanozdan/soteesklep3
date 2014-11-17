<?php
/**
* Klasa obslugujaca generowanie danych dla menu Treeview
*
* \@depend config/tmp/category.tmp
*
* @author  m@sote.pl
* @version $Id: category2treeview.inc.php,v 2.13 2005/12/27 12:13:41 lukasz Exp $
* @package    opt
*/

if (@$__secure_test!=true) die ("Forbidden");
require_once ("config/tmp/category.php");

// dodaj klase obslugi funkcji jezykowych
require_once("include/lang_functions.inc");

global $__category;

class Treeview {
    var $usetextlinks=1;
    var $startallopen=0;
    var $useframes=0;
    var $useicons=1;
    var $wraptext=1;
    var $perservestate=1;
    var $iconpath="/lib/Treeview/";
    
    var $js='';                         // generowany kod JavaScript
    var $url="/go/_category";           // url linku kategorii
    var $dir="lib/Treeview/data/";      // katalog gdzie sa przechowywane dane kategprii
    var $file="treeview.js";            // nazwa pliku, docelowo ma ona przedrostek okreslajacy "lang" np. pl_treeview.js
    
    /**
    * Konstruktor obiektu
    */
    function treeview() {
        global $config;
        
        if (@$config->category['openall']>0) $this->startallopen=1;
        if (@$config->category['icons']==0) $this->useicons=0;
        
        return(0);
    } // end treeview()
    
    /**
    * Generuj naglowek js z parametrami menu
    */
    function gen_params() {
        $this->js="";
        $this->js.="USETEXTLINKS=$this->usetextlinks\n";
        $this->js.="STARTALLOPEN=$this->startallopen\n";
        $this->js.="USEFRAMES=$this->useframes\n";
        $this->js.="USEICONS=$this->useicons\n";
        $this->js.="WRAPTEXT=$this->wraptext\n";
        $this->js.="PERSERVESTATE=$this->perservestate\n";
        $this->js.="ICONPATH=\"$this->iconpath\"\n";
        $this->js.="\n";
        
        return(0);
    } // end gen_params
    
    /**
    * Inicjuj menu
    */
    function init_menu() {        
        global $config,$lang;
        $choose_category=LangF::f_translate2($config->base_lang,$this->_lang,$lang->choose_category);        
        $this->js.="foldersTree = gFld(\"$choose_category\",\"\")\n";
        return(0);
    } // end init_menu
    
    /**
    * Generuj kod z danymi do Treeview
    *
    * @param string $dir    katalog w ktorym znajduje sie plik z danymi kategorii
    * @param string $prefix prefix nazwy pliku z danymi kategorii np. dla $prefix=1 plik ma postac np. 1_treeview.js
    * @file  config/tmp/category.tmp
    */
    function gen_treeview($dir='',$prefix='') {
        global $config;
        
        if (! empty($dir)) {
            include ("config/tmp/$dir/$prefix"."category.php");
        } else {
            global $__category;
        }
        
        if (is_array(@$__category)) {
            reset($__category);
            foreach ($__category as $id=>$n_category){
//            while ($id = key($__category)) {
                $n_category=$__category[$id];
                
                $name=$n_category['name'];
                $elements=@$n_category['elements'];
                
                $name=LangF::f_translate2($config->base_lang,$this->_lang,$name);
                $name=addslashes($name);
                
                // utworz nowy glowny element menu
                $url_id=urlencode($id);
                $this->js.="aux1 = insFld(foldersTree, gFld(\"$name\",\"$this->url/?idc=%22$url_id%22\"))\n";
                if (is_array(@$elements)) {
                    $this->gen_submenu($elements,1);
                }
                
//                next($__category);
            }
            
            
        } // end if (is_array($__category))
        
        
        return(0);
    } // end gen_treeview()
    
    /**
    * Generuj submenu dla danej kategorii
    *
    * @param array $elements tablica z danymi kategorii
    * @param int   $level    poziom zagniezdzenia kategorii
    */
    function gen_submenu($elements=array(),$level) {
        global $config;
        
        while (list($key,$item) = each($elements)) {
            
            if (is_array($item)) {
                // dany element jest drzewem
                $id=key($item);
                $name=$item[$id]['name'];
                $new_elements=$item[$id]['elements'];
                $level++;
                
                $name=LangF::f_translate2($config->base_lang,$this->_lang,$name);
                $name=addslashes($name);
                
                $this->js.="aux$level = insFld(aux".($level-1).", gFld(\"$name\",\"$this->url/?idc=%22$id%22\"))\n";
                $this->gen_submenu($new_elements,$level);
                $level--;
            } else {
                // dany element jest lisciem - koncowym linkiem kategorii/podkategorii
                $name=$key;                
                $name=LangF::f_translate2($config->base_lang,$this->_lang,$name);
                $name=addslashes($name);
                
                $id=$item;
                $this->js.="insDoc(aux$level, gLnk(\"S\",\"$name\",\"$this->url/?idc=%22$id%22\"))\n";
            }
        } // end while
        
        
        return(0);
    } // end gen_submenu()
    
    /**
    * Zapisz plik z danymi kategorii na dysku i wrzuc go przez FTP w odpowiednie miejsce
    *
    * @param string $my_lang jezyk w ktorym wygenerowane sa kategorie, dot. nazwy generowanego pliku
    * @param string $dir     podkatalog w ktorym bedzie zapisywany plik z danymi
    * @param string $prefix  prefix nazwy pliku z danymi np. jesli $prefix="1_"; to nazwa bedzie maila postac np. pl_1_treeview.js
    */
    function save_ftp($my_lang="pl",$dir='',$prefix='') {
        global $DOCUMENT_ROOT;
        global $config;
        global $ftp;
        
        $file="$DOCUMENT_ROOT/tmp/$my_lang"."_".$this->file;
        if ($fd=fopen($file,"w+")) {
            fwrite($fd,$this->js,strlen($this->js));
            fclose($fd);
        } else {
            global $theme;
            $theme->head_window();
            die ("Forbidden: tmp/$my_lang"."_".$this->file);
        }
        
        if (! empty($dir)) {
            $install_dir=$this->dir."$dir/";
        } else $install_dir=$this->dir;
        
        // wrzuc dane przez ftp
        $ftp->put($file,$config->ftp['ftp_dir']."/$install_dir",$my_lang."_".$prefix.$this->file);
        
        return(0);
    } // end ftp()
    
    /**
    * Aktualizuj dane kategorii dla wszsytkich dostepnych jezykow
    *
    * @param string $dir    podkatalog w ktorym bedzie zapisywany plik z danymi
    * @param string $prefix prefix nazwy pliku z danymi np. jesli $prefix="1"; to nazwa bedzie maila postac np. pl_1_treeview.js
    *
    * @public
    */
    function update_category_files($dir='',$prefix='') {
        global $config;
        
        if (! empty($prefix)) {
            $prefix=$prefix."_";
        }        
        
        reset($config->langs_symbols);
        while (list($key, $language) = each($config->langs_symbols)) {
            // $language="pl";
            $this->_lang=$language;
            $this->js='';
            $this->gen_params();
            $this->init_menu();
            $this->gen_treeview($dir,$prefix);
            $this->save_ftp($language,$dir,$prefix);
        }
        
        return(0);
    } // end update_category_files()
    
} // end Treeview

?>

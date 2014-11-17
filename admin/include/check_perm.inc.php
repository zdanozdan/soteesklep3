<?php
/**
* Obsluga uprawnien.
* Sprawdz uprawnienia uzytkownika do danego katalogu. Sprawdz czy we wskazanym katalogu istnieje
* plik .perm.php i odczytaj czy prawa uzytkownika odpowiadaja prawom wymaganym do odwolania sie
* do wskazanego katalogu. Format danych w pliku .perm.php np.:
* <?php $__perm_require=array("newsedit","modules");?>
* W zaleznosci od praw wyswietl np. tekst itp.
*
* @author  m@sote.pl
* @version $Id: check_perm.inc.php,v 2.16 2004/12/20 17:59:20 maroslaw Exp $
* @package    admin_include
*/

/**
* @package perm
*/
class PermFunctions {

    /**
    * Konstruktor
    */
    function PermFunctions() {
        $this->_getPerm();
        return;
    } // end PermFunctions()       
    
    /**
    * Odczytaj uprawnienia u¿ytkwonika
    *
    * @access private
    * @return bool true  - uprawnienia zosta³yu odczytane, false - w p.w.
    */
    function _getPerm() {   
        global $_SESSION,$__perm;
        if (! empty($_SESSION['__perm'])) {
            $this->_perm=$_SESSION['__perm'];
            return true;
        } elseif (! empty($__perm)) {
            $this->_perm=$__perm;   
        }
        
        return false;
    } // end _getPerm()
    
    /**
    * @param  string $file_dir  sciezka wzgledem soteesklep2/admin okreslajaca katalogu (lub pliku), ktory sprawdzamy
    * @param  array  $__perm    prawa zalogowanego uzytkownika (odpowiadajace prawom z tabel admin_users i admin_users_type)
    * @return bool   true       uzytkownik ma prawa do do katalogu, false w p.w.
    */
    function check_link($file_dir) {
        global $DOCUMENT_ROOT;              // DOCUMENT_ROOT wskazuje na katlog soteesklep2/admin
        global $config;
        global $_SESSION;
        
        if (ereg("^javascript",$file_dir)) return true;               
        if (! $this->_getPerm()) return false;
        $__perm=$this->_perm;
        
        // wez pierwszy element linku do spacji
        if (ereg(" ",$file_dir)) {
            $file_dir_tab=preg_split("/[\s]+/",$file_dir,2);
            $file_dir=$file_dir_tab[0];
        }
        
        preg_match("/([a-zA-Z0-9_.\/]+)/",$file_dir,$matches);
        if (! empty($matches[0])) {
            $file_dir=$matches[0];
        }
        
        if (ereg(".php$",$file_dir)) {
            $dir=preg_replace("/[0-9a-z_-]+.php$/","",$file_dir); // obetnij nazwe pliku ze sciezki
        } else $dir=$file_dir;
        
        
        $file=$DOCUMENT_ROOT.@$config->admin_dir.$dir.".perm.php";
        $inode=@fileinode($file);
        if ($inode>0) {
            @include($file);
            if (! empty($__perm_require)) {
                $allow=true;
                foreach ($__perm_require as $perm) {
                    if (! in_array($perm,$__perm)) {
                        $allow=false;
                    }
                }
                
                // sprawdz czy uzytkownik ma wszystkie uprawnienia p_all z wylaczeniem uprawnien do nccp
                if ((in_array("all",$__perm)) && (! in_array("0x1388",$__perm_require))) {
                    $allow=true;
                } elseif ((in_array("all",$__perm)) && (in_array("0x1388",$__perm_require)) && ($config->nccp=="0x1388")) {
                    $allow=true;
                }
                
                if ($allow==false)  return false;
            } else return true;
        }
        
        return true;
    } // end check_link()
        
    /**
    * Sprawdzenie, czy u¿ytkwonik aktualnie zalogowany ma uprawnienia do podanego modu³u uprawnieñ
    *
    * @param mixed  string lub array uprawnienie(a) - nazwa modu³u uprawnieñ np. newsedit, product, all itp.
    *               (patrz tabela amdin)users_type w bazie danych)
    *               lub array("product,name,all,...)
    * @return bool true - u¿ytkwonik ma odpowiednie uprawnienia, false w p.w.
    */
    function check($perm_name) {
        if (! $this->_getPerm()) return false;
        if (is_array($perm_name)) {
            reset($perm_name);
            foreach ($perm_name as $perm) {
                if (! $this->_check($perm)) return false;                
            }
            return true;
        } else {
            return $this->_check($perm_name);
        }
    } // end check()
    
    /**
    * Sprawdz uprawnienia dot. pojedynczego modu³u
    * 
    * @access private
    * @return true - u¿ytkwonik ma uprawnienia, false w p.w.
    */
    function _check($perm_name) {
        if ((in_array($perm_name,$this->_perm)) || (in_array("all",$this->_perm))) return true;   
        return false;
    } // end _check()
    
    /**
    * Wyswietl tekst + link o ile uzytkwonik ma prawa do linku na ktory wskazuej katalog <A HREF ...>
    *
    * @param string $text    tekst
    * @param string $url     link
    * @param string $options dodatkowe opcje do komendy HTML
    */
    function a($text,$url,$options="") {
        global $config;
        if ($this->check_link($url)) {
            print "<a href=$config->url_prefix"."$url $options>$text</a>";
        } else return;
    } // end text()
    
} // end class Permission

global $permf;
$permf = new PermFunctions;
?>

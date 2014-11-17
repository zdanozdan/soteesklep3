<?php
/**
* Wyswietlanie zdjec do produktu
*
* @author  m@sote.pl rp@sote.pl
* @version $Id: image.inc,v 2.41 2006/02/10 12:06:32 krzys Exp $
*
* @package    include
*/

// okreslenie czy dane zdjêcie mo¿e byæ powiêkszane (po klikniêciu)
define ("IMAGE_ZOOM_UP_TRUE",true);
define ("IMAGE_ZOOM_UP_FALSE",false);

class Image {
    
    var $photo_dir;                            // katalog zawierajacy zdjecia produktow wzgledem $DOCUMENT_ROOT
    var $support_ext="jpg|gif|png";            // obslugiwane typy plikow
    var $max_size=250;                         // maksymalna szerokosc lub wysokosc zdjecia
    var $max_images=10;                        // maksymalna liczba zdjec
    var $default_bmp_name="/themes/base/base_theme/_img/_mask.gif"; // nazwa zalczanego pliku w przypadku nie odnalezienia zadanego pliku
    
    /**
    * @var string prefix wywo³ania zdjêcia (np. http://www.sklep.pl, wykorzystywane w adminie, do odwolania sie do /photo/)
    */
    var $http_prefix='';
    
    /**
    * Konstruktor
    *
    * @access public
    * @return none
    */
    function Image() {
        global $DOCUMENT_ROOT,$_SERVER;
        global $config,$shop;
        
        if ($shop->admin) {
            $this->photo_dir=$config->admin_dir."/photo/";
            $this->http_prefix="http://".$_SERVER['HTTP_HOST'];
        } else {
            $this->photo_dir=$config->htdocs_dir."/photo/";
        }
        
        return(0);
    } // end image()
    
    /**
    * Wyswietl wszystkie zdjecia do produktu; obsluga wyswietlania kilku zdjec do produktu
    *
    * @param string $photo    nazwa zdejcia z bazy danych (pole 'photo' z tabeli 'main')
    * @param string $align    wyrownanie zdjecia, do prawej, lewej
    * @param string $prefix   prefix do nazwy zdjecia $photo
    * @param int    $max_size maksymalna szeroko¶æ luib wysoko¶c zdjêcia
    * @param bool   $zoom_up  true - zdjêcie mo¿e byæ powiêkszane po klikniêciu, false - w p.w.
    *
    * @access public
    * @return none
    */
    function show($photo,$align="right",$prefix="",$max_size=0,$zoom_up=true) {
        global $DOCUMENT_ROOT,$config,$shop;
        $dynamic_scale = 0;
        if ((empty($prefix)) && (empty($max_size))) {
            $max_size=$config->image['max_size'];
            $dynamic_scale = 1;
            
        } elseif ($prefix=="m_") {
            $max_size=$config->image['min_size'];
        }
        
        
        // 1. wywolaj wyswietlenie zdjecia np. nazwa.jpg (dla $photo="nazwa.jpg")
        // 2. sprawdz czy istnieje plik nazwa-1.jpg
        // 3. a) jesli jest to wyswietl je i zwieksz numer o 1 i idz do 2.
        //    b) jesli nie to zakoncz wyswietlanie || sprawdz kolejny numer az do $this->max_images
        
        // odczytaj nazwe i rozszezenie pliku zdjecia
        $tab=$this->get_name_ext($photo);
        $filename=$tab[0];$ext=$tab[1];
        
        // 1.
        $this->_showPhoto($photo,$align,$prefix,$max_size,$zoom_up,$dynamic_scale);
        
        // kilka zdjec wyswietlaj tylko w info (tj jesli zdjecie jest wywolywane bez prefixu)
        if (empty($prefix)) {
            // 2.
            for ($i=1;$i<$this->max_images;$i++) {
                if ($shop->home!=1) {
                    $file=$DOCUMENT_ROOT."/../htdocs/photo/$filename-$i.$ext";
                }
                else {
                    $file=$DOCUMENT_ROOT."/photo/$filename-$i.$ext";
                }
                if (@fileinode($file)>0) {
                    // 3. a)
                    $photo="$filename-$i.$ext";
                    $this->_showPhoto($photo,$align,$prefix,$max_size,$zoom_up);
                } else {
                    // 3. b)
                    //return;
                }
            } // end for
        } // end empty($prefix)
        
        return(0);
    } // end show()
    
    /**
    * Rozdziej rozszezenie o nazwy pliku
    *
    * @param string $filename  nazwa pliku
    *
    * @static
    * @access public
    * @return array array($name,$ext) (nazwa, rozszezenie pliku)
    */
    function get_name_ext($filename) {
        $name=preg_match("/^(.+).(.{3})$/",$filename,$matches);
        
        $name=&$matches[1];
        $ext=&$matches[2];
        // print "<font color=red>$name</font>.<font color=green>$ext</font <BR>";
        
        return array($name,$ext);
    } // end get_name_ext()
    
    /**
    * Funkcja odpowiadajaca za weryfikacje obslugiwanych formatow bitmap
    *
    * @param  string $filename      nazwa pliku do weryfikacji
    * @param  array  $support_ext   obslugiwane typy plikow
    *
    * @access public
    * @static
    * @return int  status weryfikacji pliku (1 - rozpoznano rozszezenie i typ pliku, 0 - nie rozpoznano rozszezenia)
    *
    */
    function verifyInputData($file){
        $verify_status=0;
        if (preg_match("/$this->support_ext/i",$file)){
            $verify_status=1;
        }
        return $verify_status;
    } // end verifyInputData()
    
    /**
    * Wyswietl zdjecie produktu, jesli istnieje.
    *
    * @param string $photo    nazwa zdjecia pobrana z bazy
    * @param string $align    [left|right] parametr align przy zdjeciu
    * @param string $prefix   string poprzedzajacy nazwe zdjecia (nazwa pobrana z bazy)
    * @param int    $max_size maksymalna szeroko¶æ lub wysoko¶æ zdjêcia
    * @param bool   $zoom_up  true - zdjêcie mo¿e byæ powiêkszane po klikniêciu, false - w p.w.
    *
    * @access private
    * @return none
    */
    function _showPhoto($photo,$align="right",$prefix="",$max_size=0,$zoom_up=true,$dynamic_scale=0) {
        global $DOCUMENT_ROOT;
        global $theme;
        global $my_xml_options;
        global $shop;
        
        if (empty($photo)) return;
        
        $_allow_scale=true;
        /*
        if ((! empty($my_xml_options)) && (method_exists($my_xml_options,'checkChangeImage'))) {
            // sprawdz czy zdjecie nie jest zmieniane online, jesli tak, to nie zezwalaj na skaluowanie zdjecia
            if (! $my_xml_options->checkChangeImage()) {
                if (empty($prefix)) $_allow_scale=false;
            }
        }
        */
        if ($max_size==0) $max_size=$this->max_size;
        
        if ($shop->home!=1) {
            $file=$DOCUMENT_ROOT."/../htdocs/photo/".$prefix.$photo;
        } else {
            $file="/photo/".$prefix.$photo;
        }
        
        if (file_exists($file)) {
            // odczytaj parametry wysokosci i szerokosci zdjecia
            $isize=GetImageSize($file);
            $width=$isize[0];  $width_orig=$width;
            $height=$isize[1]; $height_orig=$height;
            
            // przeskaluj zdjecie, jesli jest zbyt duze
            $p=0;
            if ($width>$max_size) {
                $p=($max_size/$width);
            } elseif ($height>$max_size) {
                $p=($max_size/$height);
            }
            
            if ($p>0) {
                $width=intval($p*$width);
                $height=intval($p*$height);
                // wstaw link do oryginalnego rozmiaru zdjecia, otworz nowe dopasowane
                // do wielkosci zdjecia okno
                if (($_allow_scale==true) && ($zoom_up==true)) {
                    print "<a id=\"photolink\" href=\"".$this->http_prefix.$this->photo_dir.$prefix.$photo."\" ";
                    $this->onclick($width_orig+25,$height_orig+25,"photo");
                    print " target=\"photo\" alt=\"\">";
                }
            }
            
            if (! empty($align)) {
                $html_align=" align=$align ";
            } else $html_align='';
            if ($dynamic_scale == 1) {
                $scale_str = "onload='imageScale(this, $max_size)'";
            }
            else {
                $scale_str = "width='$width'";
            }
            $id="";
            if (empty($prefix) && $zoom_up) {
            	$id='photo';
            }
            if (empty($prefix) && $zoom_up) {
            	$id='photo';
            }
            print "<img $scale_str id=\"$id\" name=".$prefix."photo src=\"".$this->http_prefix.$this->photo_dir.$prefix.$photo."\" $html_align".
            "border=\"$theme->img_border\"";
            print ">\n";
            
            
            
            if ($p>0) {
                if (($_allow_scale==true) && ($zoom_up==true)) {
                    print "</a>";
                }
            }
            
         
        } // end file_exists($file)
        
        return;
    } // end _showPhoto()
       
    
    /**
    * Wyswietl zdjecie produktu duze (max_photo) jesli istnieje.
    *
    * @param string $photo    nazwa zdjecia pobrana z bazy
	* @author krzys@sote.pl
    * @access private
    * @return none
    **/
    
    function _show_max_Photo($photo,$desc_max_photo) {
        global $DOCUMENT_ROOT;
        
       $max_file=$DOCUMENT_ROOT."/../htdocs/photo/"."max_".$photo;
            if (file_exists($max_file)){
	            $big_size=GetImageSize($max_file);
	            $max_width=$big_size[0];
	            $max_height=$big_size[1];
	            print "<a id=\"photolink\" href=\"".$this->http_prefix.$this->photo_dir."max_".$photo."\" ";
	            $this->onclick($max_width+25,$max_height+25,"photo");
	            print " target=\"photo\" alt=\"\">";
	            print "<img src='/themes/base/base_theme/_img/view_big.png' style=\"border-style:none\">&nbsp;";
	            print $desc_max_photo;
	            print "</a>";
            }
            return;
    }
             
    
    
    /**
    * Wyswietl jako atrybut onClick wywolanie otworzenie nowego okna przegladarki
    *
    * @param int   $x    szerokosc okna
    * @param int   $y    wysokosc okna
    * @param stirn $name nazwa okna
    *
    * @access public
    * @return none
    */
    function onClick($x,$y,$name) {
        print "onclick=\"window.open('','$name','width=$x,height=$y,scrollbars=0,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
    } // end onClick()
    
} // end class Image

$image =& new Image;

?>

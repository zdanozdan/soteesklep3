<?php
/**
 * Generuj sciezke kategorii na podstawie parametru $idc lub $cidc
 *
 * \@global string $__category_path ($global_category_path)  sciezka wybranych kategorii
 * @author m@sote.pl
 * @version $Id: category_path.inc.php,v 2.4 2005/06/02 07:08:49 lechu Exp $
* @package    category
 */
require_once ("config/tmp/category.php");

// funkcje jezykowe - tlumaczenie nazw kategorii
require_once("include/lang_functions.inc");

class CategoryPath {
    var $category=array();   // tablica kategorii
    var $tabc_name=array();
    var $depth=0;            // biezace zagniezdzenie, glebokosc kategorii
    var $idc;                // aktualne wywolanie id kategorii $idc=1, $idc=1_2, $idc_1_2_9 itp.

    /**
     * Utworz tablice z nazwami wybranych kategorii
     * 
     * @param array $param tablica z danymi katgorii
     * @return array nazwy wybranych kategorii array("kategoria1","kategoria2",...)
     */
    function gen_parse_cat($param) {
        if (empty($param)) return;
        if (! is_array($param)) return;

        $this->category_tab=$param;      // zapamietaj w klasie tablice id kategorii array(1=>1,2=>34,3=>5)
        $this->max_depth=sizeof($param); // ilosc zagniezdzen

        $k1=key($param);
        $p1=$param[$k1];
        while (list($key,$val) = each($this->category)) {
            if ($key=="id_$p1") {               
                // rozpocznij parsowanie wartosci menu glownej kateporii
                $this->parse_subcat($val);                
                return;
            }
        } // end while
        return;
    } // end show_category_path()

    /**
     * Generuj biezaca wartosc $this->idc
     * Jesli $idc=1_3_4_6 to dla $this->depth=2 bedzie to: 1_3, dla 3: 1_3_4 itp.
     *
     * @return string $this->idc
     */
    function idc_depth($depth) {
        $this->idc="";
        $i=0;
        reset($this->category_tab);
        while (list($nr,$id) = each ($this->category_tab)) {
            if ($i==$depth) {                                              
                $this->idc.=$id."_"; 
                $this->idc=substr($this->idc,0,strlen($this->idc)-1); // obetnij ostatni znak "_"
                return $this->idc;
            } else {
                $this->idc.=$id."_";            
            }
            $i++;
        }
        $this->idc=substr($this->idc,0,strlen($this->idc)-1); // obetnij ostatni znak "_"
        return $this->idc;
    } // end idc_depth()
    

    /**
     * Przejrzyj wartosci podkategorii elementu $category['id_x']
     *
     * @param array $tab array("2_9"=>array("name"=>"nazwa kategorii","elements"=>...)     
     * @author m@sote.pl lech@sote.pl
     */
    function parse_subcat($tab) {       
        $name=$tab['name'];         // nazwa kategorii
        if (! empty($tab['elements'])) {
            $elements=@$tab['elements']; // elementy kategorii, kolejne podkategorie
        } else $elements=array();
        $this->tabc_name[$this->depth]=$name;

        $this->depth++;
        if (! empty($elements)) {
            while (list($key,$val) = each ($elements)) {
                if (is_array($val)) {                
                    // element jest pokategoria (galezia)
                    $key_menu=key($val);
                    $idc_depth=$this->idc_depth($this->depth);
                    if ($key_menu==$idc_depth) {
                        $new_tab=$val[$key_menu];
                        $this->parse_subcat($new_tab);
                    }
                } else {
                    // element jest lisciem
                    if ($val==$this->idc_depth($this->depth)) {
                        if ($this->depth>0) {
                            $this->tabc_name[$this->depth]=$key;                 
                        }
                    }
                }
            } //end while
        } // end (! empty($elements))

        return $this->tabc_name;
    } // end gen_subcat()

    /**
     * Wyswietl nzwy wybranych kategorii, podkategorii
     *
     * @return string kategoria1>kategoria2>...
     * @author m@sote.pl lech@sote.pl
     */
    function show_path() {
        $o="";
        reset($this->tabc_name);
        foreach ($this->tabc_name as $cat) {
            $cat=LangFunctions::f_translate($cat);  //przetlumacz slowo nazwe kategorii
            $o.="$cat > ";
        }
        $o=substr($o,0,strlen($o)-2); // obetnij ostatnie dwa znaki "> ";
        return $o;
    } // end show_path();

} // end class CategoryPath
 
$cpath = new CategoryPath;
$cpath->category=&$category;
$cpath->gen_parse_cat($category_tab);

$global_category_path=$cpath->show_path(); 
$__category_path=&$global_category_path;

?>

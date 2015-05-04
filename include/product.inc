<?php
/**
* W³a¶ciwo¶ci produktu z bazy. Odczytanie ceny,rabatu, zmiana waluty tp. po pobraniu danych z bazy dla danego rekordu.
* Klasa wykorzystywana przez funkcje prezentuj±ce produkty np. na listach, w info w promocji itp. Zosta³a ona stworzona
* po to, ¿eby nie powtarzaæ odczytywania danych i obliczania parametrów dot. produktu. We wcze¶niejszych wersjach dane by³y
* odczytywane w kilku miejscach np. include/record_row.inc.php htdocs/go/_info/query_rec.inc.php itp. i ³atwo mo¿na by³o
* pomyliæ siê przy wprowadzaniu nowych opcji. Obecnie od wersji 3.0 wszystko jest definiowane w jednym miejscu.
*
* @author  m@sote.pl
* @version $Id: product.inc,v 1.2 2007/03/28 22:58:22 tomasz Exp $
* @package    include
* \@lang
*/

/**
* Klasa obs³ugi i obliczania ceny produktu.
*/
require_once ("include/price.inc");

/**
* Dodaj klasê obs³ugi s³ownika.
*/
require_once ("include/lang_functions.inc");

define ("PRODUCT_ALL",1);           // odczytaj wszytskie dane produktu
define ("PRODUCT_ROW",2);           // odczytaj dane do prezentacji na li¶cie itp.
define ("PRODUCT_ROW_DESC",2);      // odczytaj dane do prezentacji na li¶cie itp. + opis
define ("PRODUCT_ROW_SCORE",3);     // odctaj dane do prezentacji na li¶cie + SCORE (dopasowanie do zapytania wyszukiwania wg s³owa)
define ("PRODUCT_INFO",4);          // odczytaj dane wymagane do prezentacji pe³nej infomacji o produkcie

/**
* Klasa opisuj±ca produkt z tabeli main.
* @package products
* @subpackage rec
*/
class Product {
    
    /**
    * Konstruktor
    *
    * @param mixed  $this->result wynik zapytania z bzay danych
    * @param int    $this->i      numer wiersza wyniku zapytania z bazy danych
    * @param object &$rec   reprezentant klasy Rec; tablica $this->rec->data dane produktu
    * @return none
    */
    function Product(&$result,$i,&$rec) {
        global $config;
        $this->rec=&$rec;
        $this->result=&$result;
        $this->i=$i;
        $this->prefix_lang='';
        if ($config->lang!=$config->base_lang) $this->prefix_lang=$config->lang."_";
        return;
    } // end Product()
    
    /**
    * Odczytaj podstawowe dane produktu, nazwê, kategorie, cene itp.
    * Odczytane dane mog± pos³u¿yæ do wy¶wietlenie informacji o prododukcie i cenie
    * np. na listach produktów w promocji itp.
    * Funkcja modyfikuje zawarto¶æ zmiennej przekazanej jako parametr (wska¼nik).
    *
    * @param int $mode rodzaj zwracanych danych (pe³ne dane, skrócone,...)
    * @return none
    */
    function getRec($mode=PRODUCT_ALL) {
        global $theme;
        global $shop;
        
        global $db,$result,$i;
        
        $this->rec->data['date_update']=$db->FetchResult($this->result,$this->i,"date_update");

        $this->_getBase();
        
        
        if (($mode==PRODUCT_ALL) || ($mode==PRODUCT_INFO) || ($mode==PRODUCT_ROW_DESC) || ($mode==PRODUCT_ROW_SCORE)) {
            $this->_getDescriptions();
        }
        
        if (($mode==PRODUCT_INFO) || ($mode==PRODUCT_ALL)) {
            $this->_getXMLOptions();
            $this->_getExtInfo();
        }
        
        if ($mode==PRODUCT_ROW_SCORE) {
            $this->_getScore();
        }
        
        // start modules:
        // main_keys
        $this->_getMainKeys();
        // end modules:
        
        // odczytaj dodatkowe pola specyficzne dla skelpu
        $this->_getAdd();
        // print "<pre>";print_r($this->rec);print "</pre>";
        
        return;
    }  // end getRec()
    
    /**
    * Odczytaj pola dodatkowe.
    * @return none
    */
    function _getAdd() {
        global $config;
        global $db;
        if(is_array(@$config->fields)) {
            foreach($config->fields as $key=>$value) {
                $this->rec->data[$value]=$db->FetchResult($this->result,$this->i,$value);
            }
        }
        return true;
    } // end _getAdd
    
    /**
    * Odczytaj podstawowe dane wymagane do prezentacji danego produktu.
    * @return none
    */
    function _getBase() {
        global $db,$config;
        
        $this->rec->data['id']=$db->FetchResult($this->result,$this->i,"id");
        $this->rec->data['user_id']=$db->FetchResult($this->result,$this->i,"user_id");
        $this->rec->data['name']=$db->FetchResult($this->result,$this->i,"name_L" . $config->lang_id);
        if (empty($this->rec->data['name'])) {
            $this->rec->data['name']=$db->FetchResult($this->result,$this->i,"name_L0");
        }
        $this->rec->data['id_producer']=$db->FetchResult($this->result,$this->i,"id_producer");
        $this->rec->data['producer']=$db->FetchResult($this->result,$this->i,"producer");
        
        for ($c=1;$c<=5;$c++ ) {
            $this->rec->data['id_category'.$c]=$db->FetchResult($this->result,$this->i,"id_category".$c);
            $this->rec->data['category'.$c]=$db->FetchResult($this->result,$this->i,"category".$c);
            if ($config->lang!=$config->base_lang) {
                LangF::translate($this->rec->data['category'.$c]);
            }
        } // end for
        
        $this->rec->data['photo']=$db->Fetchresult($this->result,$this->i,"photo");
        $this->rec->data['user_score']=$db->Fetchresult($this->result,$this->i,"user_score");
        $this->rec->data['id_available']=$db->FetchResult($this->result,$this->i,"id_available");
        $this->rec->data['ranking']=$db->FetchResult($this->result,$this->i,"ranking");
        $this->rec->data['points']=$db->FetchResult($this->result,$this->i,"points");
        $this->rec->data['points_value']=$db->FetchResult($this->result,$this->i,"points_value");

	//sms field not used, use for saleoff mode
        $this->rec->data['sms']=$db->FetchResult($this->result,$this->i,"sms");
        
        $this->_getPrice();
        
        return;
    } // end _getBase()
    
    /**
    * Odczytaj dane zwi±zane z cen± produktu.
    *
    * @access private
    * @return none
    */
    function _getPrice() {
        global $db,$DOCUMENT_ROOT,$theme,$shop;
        
        $my_price =& new MyPrice;
        
        if ($shop->admin) {
            // wyswietl cene bez rabatow itp. w adminie
            $this->rec->data['price_brutto']=$db->FetchResult($this->result,$this->i,"price_brutto");
        } else {
            // oblicz cene sprzedazy dla sklepu
            $this->rec->data['price_brutto']=$my_price->price($this->result,$this->i);
        }
        
        $this->rec->data['base_discount']=$my_price->discount;
        
        $this->rec->data['id_currency']=$db->FetchResult($this->result,$this->i,"id_currency");
        $this->rec->data['price_currency']=$db->FetchResult($this->result,$this->i,"price_currency");
        $this->rec->data['currency']=@$config->currency_name[$this->rec->data['id_currency']];
        
        // oblicze cene netto
        $vat=$data['vat']=$db->Fetchresult($this->result,$this->i,"vat");
        $price_netto=($this->rec->data['price_brutto']/(100+$vat))*100;
        $this->rec->data['price_netto']=$theme->price($price_netto);
        
        // oblicz cene netto w walucie
        $price_currency_netto=($this->rec->data['price_currency']/(100+$vat))*100;
        $this->rec->data['price_currency_netto']=$theme->price($price_currency_netto);
        
        $price_brutto_detal=$db->FetchResult($this->result,$this->i,"price_brutto_detal");
        if ($price_brutto_detal>0) {
            $this->rec->data['price_brutto_detal']=$db->FetchResult($this->result,$this->i,"price_brutto_detal");
        } else {
            $this->rec->data['price_brutto_detal']='';
        }
        
        // jesli cena=0 to wymus: zapytaj o cene
        if (! ($this->rec->data['price_brutto']>0) && ($this->rec->data['points']!=1)) {
            $this->rec->data['hidden_price']=1;
        } else {
            $this->rec->data['hidden_price']=$db->FetchResult($this->result,$this->i,"hidden_price");
        }
        
        // zapytaj o cenê
        $this->rec->data['ask4price']=$db->FetchResult($this->result,$this->i,"ask4price");
        
        if ($this->rec->data['base_discount']==0) {
            $this->rec->data["base_discount"]=$db->FetchResult($this->result,$this->i,"discount");
        }
        $shop->currency();
        // zmien walute, jesli jest jakas waluta zadeklarowana globalnie        
        $this->rec->data['price_brutto']=$shop->currency->price($this->rec->data['price_brutto']);        
        $this->rec->data['price_netto']=$shop->currency->price($this->rec->data['price_netto']);        
        $this->rec->data['price_brutto_detal']=$shop->currency->price($this->rec->data['price_brutto_detal']);
        
        
        $this->rec->data["max_discount"]=$db->FetchResult($this->result,$this->i,"max_discount");        
        $this->rec->data["points_value"]=$db->FetchResult($this->result,$this->i,"points_value");        
        $this->rec->data["points"]=$db->FetchResult($this->result,$this->i,"points");        
        
        return;
    } // end _egtPrice()
    
    
    /**
    * Odczytaj opisy produktu, generuj skrócony opis produktu, je¶li jest tylko opis pe³ny.
    *
    * @return none
    */
    function _getDescriptions() {
        global $db, $config;
        
        // opisy
        $this->rec->data['xml_description']=$db->FetchResult($this->result,$this->i,"xml_description_L" . $config->lang_id);
        if (empty($this->rec->data['xml_description'])) {
            $this->rec->data['xml_description']=$db->FetchResult($this->result,$this->i,"xml_description_L0");
	}
        $this->rec->data['xml_short_description']=$db->FetchResult($this->result,$this->i,"xml_short_description_L" . $config->lang_id);
	if (empty($this->rec->data['xml_short_description'])) {
            $this->rec->data['xml_short_description']=$db->FetchResult($this->result,$this->i,"xml_short_description_L0");
	}
        
        return;
    } // end _getDescription()
    
    /**
    * Odczytaj dopasowanie do wzroca zapytania. Odczytana warto¶æ pozawala na % okre¶lenie dopasowania.
    *
    * @access private
    * @return none
    */
    function _getScore() {
        global $db;
        
        // zmienne globalne zwi±zane sortowaniem wg dopasowania
        global $__order_main;
        global $__order_main_score;
        
        
        // odczytaj dopasowanie do wyszukiwania
        if (@$__order_main=="SCORE") {
            $score=$db->FetchResult($this->result,$this->i,"SCORE");
            
            // jesli w wyszukiwaniu jest inne sortowanie niz wg SCORE, to nie pokazuj dopasowania
            // 1,2,3 sortowanie wg nazwy, ceny,producenta, 4 - sortowanie wg dopasowania SCORE
            if ((! empty($_REQUEST['order'])) && (my(@$_REQUEST['order'])!=4)) {
                $this->rec->data['SCORE']='';
            } else {
                // zapamietaj maksymalna liczbe SCORE dla 1 wywolania
                global $__max_score;
                if (empty($__max_score)) {
                    $__max_score=$score;
                    $this->rec->data['SCORE']=100;
                } else {
                    $new_score=($score/$__max_score)*100;
                    $new_score=number_format($new_score,2,".","");
                    $this->rec->data['SCORE']=$new_score;
                }
            } // end if ($_REQUEST['order']<4
            
        } // end if (@$__order_main=="SCORE")
        
        return;
    } // end _getScore()
    
    /**
    * Odczytaj dane zwi±zami z opcjami/atrybutami (xml_options)
    * @return none
    */
    function _getXMLOptions() {
        global $db;
        $this->rec->data['xml_options']=$db->FetchResult($this->result,$this->i,"xml_options");
        return;
    } // end _getXMLOptions()
    
    /**
    * Odczytaj dane zwi±zane z modu³em "main_keys".
    * @return none
    */
    function _getMainKeys() {
        global $db;
        // main_keys_online sprzedaz online
        $this->rec->data['main_keys_online']=$db->FetchResult($this->result,$this->i,"main_keys_online");
        return;
    } // end _getMainKeys()
    
    /**
    * Odczytaj dodatkowe pola zwi±zane z pe³n± prezentacj± produktu w info.
    * @return none
    */
    function _getExtInfo() {
        global $db;
        global $lang;
        $this->rec->data['flash']=$db->FetchResult($this->result,$this->i,"flash");
        $this->rec->data['flash_html']=$db->FetchResult($this->result,$this->i,"flash_html");
        $this->rec->data['pdf']=$db->FetchResult($this->result,$this->i,"pdf");
        $this->rec->data['doc']=$db->FetchResult($this->result,$this->i,"doc");
        $this->rec->data['accessories']=$db->FetchResult($this->result,$this->i,"accessories");
        $this->rec->data['link_url']=$db->FetchResult($this->result,$this->i,"link_url");
        $this->rec->data['link_name']=$db->FetchResult($this->result,$this->i,"link_name");
        
        // start google:
        // zapamietaj dane dotyczece meta/google
        global $config;
        
        require_once ("include/description.inc");
        $description =& new Description;
        
        $this->rec->data['google_title']=$db->FetchResult($this->result,$this->i,"google_title");
        if (! empty($this->rec->data['google_title'])) {
            $config->google['title']=addslashes($db->FetchResult($this->result,$this->i,"google_title"));
            $config->google['keywords']=addslashes($db->FetchResult($this->result,$this->i,"google_keywords"));
            $config->google['description']=$description->convertHTML2TXT($db->FetchResult($this->result,$this->i,"google_description"));
        } else {
            $config->google['title']=addslashes($this->rec->data['name']);
            $config->google['keywords']=addslashes($this->rec->data['name']." ".$this->rec->data['producer']." ".$this->rec->data['category1']);
            if (! empty($this->rec->data['xml_short_description'])) {
                $config->google['description']=$description->convertHTML2TXT($this->rec->data['xml_short_description']);
            } else {
                $config->google['description']=$description->convertHTML2TXT($this->rec->data['xml_description']);
            }
        }
        $config->google['title'] = str_replace("\"", '', $config->google['title']);
        $config->google['title'] = "mikran.pl - sklep - " . $config->google['title'];
        $config->google['keywords'] = str_replace("\"", '', $config->google['keywords']);
        $config->google['description'] = str_replace("\"", '', $config->google['description']);
        // end google:
        
        return;
    } // end _getExtInfo()
    
} // end class Product
?>

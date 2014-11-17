<?php
/**
* Klasa obs³uguj±ca import danych do sklepu z aplikacji easyshop
*
* @author  lukasz@sote.pl
* @version $Id: easyshop.inc.php,v 1.1 2005/12/20 08:16:35 lukasz Exp $
* @package importshop
*/

/**
* Klasa z funkcjami globalnymi dot. importu danych. Funkcje niezale¿ne od rodzaju programu, z którego s± importowane dane.
*/
require_once ("./include/importshop_main.inc.php");
/**
* Obs³uga danych zaszyfrowanych
*/
require_once ("include/my_crypt.inc");

$__import_class="EasyShop";
/**
* Import danych z EasyShop
* @package importshop
*/
class EasyShop extends ImportShopMain {

    var $name="easyshop";
    /**
    * Konstruktor    
    */
    function EasyShop() {
    	global $config;
        require_once ("./config/$this->name"."-config.inc.php");
        require_once("include/my_crypt.inc");
        $this->salt=$config->salt;
		$this->crypt =& new MyCrypt;
		$this->pub_key=md5($config->salt);
        return true;
    } // end EasyShop()

    /**
     * Zwraca zaszyfrowane dane
     *
     * @param string $string
     * @return string
     */
    function encrypt($string) {
    	$crypt_string=$this->crypt->endecrypt($this->pub_key,$string,"");
    	return $crypt_string;
    }
    
    /**
     * Zaszyfrowana nazwa firmy
     *
     * @return string
     */
    function get_crypt_firm() {
    	$query="SELECT company FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$firm=$this->db2->FetchResult($result,0,'company');
    		$crypt_firm=$this->encrypt($firm);
    		return $crypt_firm;
    	} else return 0;
    }
    
    /**
     * Zaszyfrowane imie
     *
     * @return string - or 0
     */
    function get_crypt_name() {
    	$query="SELECT name FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$name=$this->db2->FetchResult($result,0,'name');
    		$crypt_name=$this->encrypt($name);
    		
    		print "<br>$name | $crypt_name<br>";
    		return $crypt_name;
    	} else return 0;
    }
    
    /**
     * Zaszyfrowane nazwisko
     *
     * @return unknown
     */
    function get_crypt_surname() {
    	$query="SELECT surname FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$surname=$this->db2->FetchResult($result,0,'surname');
    		$crypt_surname=$this->encrypt($surname);
    		return $crypt_surname;
    	} else return 0;
    }
        
    /**
     * Zaszyfrowana ulica (w easyshop odrazu wraz z numerem domu i lokalu)
     *
     * @return string
     */
    function get_crypt_street() {
    	$query="SELECT street FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$street=$this->db2->FetchResult($result,0,'street');
    		$crypt_street=$this->encrypt($street);
    		return $crypt_street;
    	} else return 0;
    }
    
    /**
     * Zwraca zaszyfrowany '-' - pusta warto¶æ dla niektórych wymaganych pól
     *
     * @return string
     */
    function nothing() {
    	$nothing=$this->encrypt("-");
    	return $nothing;
    }
    
    /**
     * Zwraca zaszyfrowany login
     *
     * @param string $login
     * @return string
     */
    function crypt_login($login) {
    	$crypt_login=$this->encrypt($login);
    	return $crypt_login;
    }
    
    /**
     * Zwraca zaszyfrowany obecny timestamp
     * Przydatne gdy potrzebny jest unikatowe wymagane pole
     *
     * @return string
     */
    function crypt_time() {
    	$ret=$this->encrypt(time());
    	return $ret;
    }
    
    /**
     * Zwraca zaszyfrowany email
     *
     * @return string
     */
    function crypt_email() {
    	$query="SELECT email FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$email=$this->db2->FetchResult($result,0,'email');
    		$crypt_email=$this->encrypt($email);
    		return $crypt_email;
    	} else return 0;
    }
    
    /**
     * Zwraca zaszyfrowany kraj
     * Jako ¿e easyshop jest aplikacj± "jednonarodow±" zwasze zwróæ polske
     *
     * @return string
     */
    function crypt_country() {
    		$crypt_country=$this->encrypt("PL");
    		return $crypt_country;
    }
    
    /**
     * Zaszyfrowany kod pocztowy
     *
     * @return string
     */
    function crypt_postcode() {
    	$query="SELECT zip FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$postcode=$this->db2->FetchResult($result,0,'zip');
    		$crypt_postcode=$this->encrypt($postcode);
    		return $crypt_postcode;
    	} else return 0;    	
    }

    /**
     * Zaszyfrowane miasto
     *
     * @return string
     */
    function crypt_city () {
    	$query="SELECT city FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'city');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    /**
     * Zaszyfrowany telefon
     *
     * @return string
     */
    function crypt_phone () {
    	$query="SELECT phone_1 FROM customer_addr_bill WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'phone_1');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }

    /**
     * Zaszyfrowana firma korespondencyjna
     *
     * @return string
     */
    function crypt_cor_firm() {
    	$query="SELECT company FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'company');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    /**
     * Zaszyfrowane imie korespondencyjne
     *
     * @return string
     */
    function crypt_cor_name() {
    	$query="SELECT name FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'name');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    /**
     * Zaszyfrowane nazwisko korespondencyjne
     *
     * @return string
     */
    function crypt_cor_surname() {
    	$query="SELECT surname FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'surmane');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    
    /**
     * Zaszyfrowany adres (ulica) do korespondencji
     *
     * @return string
     */
    function crypt_cor_street() {
    	$query="SELECT street FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'street');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    
    /**
     * Zaszyfrowany kod pocztowy
     *
     * @return string
     */
    function crypt_cor_postcode() {
    	$query="SELECT zip FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'zip');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    
    /**
     * Zaszyfrowany telefon korespondencyjny
     *
     * @return string
     */
    function crypt_cor_phone() {
    	$query="SELECT phone_1 FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'phone_1');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return 0;    	
    }
    
    /**
     * Zaszyfrowany email do korespondencji
     *
     * @return string
     */
    function crypt_cor_email() {
    	$query="SELECT email FROM customer_addr_send WHERE customer_no=".$this->values['customer_no'];
    	$result=$this->db2->Query($query);
    	
    	if ($result!=0) {
    		$_res=$this->db2->FetchResult($result,0,'email');
    		$res=$this->encrypt($_res);
    		return $res;
    	} else return ;    	
    }
    
    // tutaj zaczynamy odtwarzaæ strukture drzewa kategorii
    
    /**
     * Pobierz rodzica pi±tej kategorii
     * Szukamy tak d³ugo a¿ nie dojdziemy do czwartej kategorii
     *
     * @param int $parent id rodzica tej kategorii
     * @return $id - 
     */
    function get_category5_parent($parent) {
    	if (array_key_exists($parent,$this->category4)) {
    		return $parent;
    	}
    	$query="SELECT parent FROM dict_category WHERE id=$parent";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$id=$this->db2->FetchResult($result,0,'parent');
    		$ret=$this->get_category5_parent($id);
    		return $ret;
    	} else return "";
    }
    
    /**
     * Przetwa¿amy kategoriie z p³askiej struktury easyshopa na nasze drzewko
     * Funkcja jest wywo³ywana tylko wiele razy ale malko jeden przebieg ¿eby nie pa¶æ podczas przetwarzania danych
     *
     *\@var $this->category_there
     * @return bool
     */
    function build_category() {
    	if (@$this->category_there==1) {
    		return false;
    	}
    	$this->category_there=true;
    	// wybieramy pierwsz± kategorie
    	$query="SELECT id,name,parent FROM dict_category WHERE parent=0";
    	$result=$this->db2->Query($query);
    	$parent0 = "parent=-10 ";
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$id=$this->db2->FetchResult($result,$i,'id');
    			$name=$this->db2->FetchResult($result,$i,'name');
    			$parent=$this->db2->FetchResult($result,$i,'parent');
    			$this->category1[$id]=array("name"=>$name,"parent"=>$parent);
    			$parent0.="OR parent=$id ";
    		}
    	}
    	// druga kategoria
    	$query="SELECT id,name,parent FROM dict_category WHERE parent!=0 AND $parent0";
    	$result=$this->db2->Query($query);
    	$parent1="parent=-10 ";
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$id=$this->db2->FetchResult($result,$i,'id');
    			$name=$this->db2->FetchResult($result,$i,'name');
    			$parent=$this->db2->FetchResult($result,$i,'parent');
    			$this->category2[$id]=array("name"=>$name,"parent"=>$parent);
    			$parent1.="OR parent=$id ";
    		}
    	}
    	// trzecia kategoria
    	$query="SELECT id,name,parent FROM dict_category WHERE parent!=0 AND $parent1";
    	$result=$this->db2->Query($query);
    	$parent2="parent=-10 ";
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$id=$this->db2->FetchResult($result,$i,'id');
    			$name=$this->db2->FetchResult($result,$i,'name');
    			$parent=$this->db2->FetchResult($result,$i,'parent');
    			$this->category3[$id]=array("name"=>$name,"parent"=>$parent);
    			$parent2.="OR parent=$id ";
    		}
    	}
    	// czwarta kategoria
    	$query="SELECT id,name,parent FROM dict_category WHERE parent!=0 AND $parent2";
    	$result=$this->db2->Query($query);
    	$parent3="parent=-10 ";
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$id=$this->db2->FetchResult($result,$i,'id');
    			$name=$this->db2->FetchResult($result,$i,'name');
    			$parent=$this->db2->FetchResult($result,$i,'parent');
    			$this->category4[$id]=array("name"=>$name,"parent"=>$parent);
    			$parent3.="OR parent=$id ";
    		}
    	}
    	// pi±ta kategoria
    	$parent0=preg_replace("/=/","!=",$parent0);
    	$parent0=preg_replace("/OR/","AND",$parent0);
    	
    	$parent1=preg_replace("/=/","!=",$parent1);
    	$parent1=preg_replace("/OR/","AND",$parent1);
    	
    	$parent2=preg_replace("/=/","!=",$parent2);
    	$parent2=preg_replace("/OR/","AND",$parent2);
    	
    	$parent3=$parent0."AND ".$parent1."AND ".$parent2;
    	$query="SELECT id,name,parent FROM dict_category WHERE parent!=0 AND $parent3";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$id=$this->db2->FetchResult($result,$i,'id');
    			$name=$this->db2->FetchResult($result,$i,'name');
    			$parent=$this->db2->FetchResult($result,$i,'parent');
    			$parent=$this->get_category5_parent($parent);
    			$this->category5[$id]=array("name"=>$name,"parent"=>$parent);
    		}
    	}
    	return false;
    }


    /**
     * Wszystkie nazwy pierwszych kategorii
     *
     * @return string
     */
    function category1_next_name() {
    	$category=current($this->category1);
    	return $category['name'];
    }
    

    /**
     * Wszystkie nazwy drugich kategorii
     *
     * @return string
     */
    function category2_next_name() {
    	$category=current($this->category2);
    	return $category['name'];
    }
    
    /**
     * Wszystkie nazwy trzecich kategorii
     *
     * @return string
     */
    function category3_next_name() {
    	$category=current($this->category3);
    	return $category['name'];
    }
    
    /**
     * Wszystkie nazwy czwartych kategori
     *
     * @return string
     */
    function category4_next_name() {
    	$category=current($this->category4);
    	return $category['name'];
    }
    
    /**
     * Wszystkie nazwy pi±tych kategorii
     *
     * @return string
     */
    function category5_next_name() {
    	$category=current($this->category5);
    	return $category['name'];
    }
        
    /**
     * Generuj nazwe pliku (na podstawie identyfikatora produktu w starym sklepie)
     *
     * @return string
     */
    function photo() {
    	$photo=$this->values['product_no'].".jpg";
    	return $photo;
    }
    
    /**
     * Sprawd¼ czy produkt nale¿y umie¶ciæ na li¶cie promocji
     * Zwracamy stringa a nie boola ¿eby móc go odrazu wrzuciæ do bazy danych
     *
     * @return string
     */
    function check_promotion() {
    	if (empty($this->_promotion_id)) {
	    	$query="SELECT id FROM dict_product_attrib WHERE name='PROMOCJE'";
	    	$result=$this->db2->Query($query);
	    	if ($result!=0) {
	    		$id=$this->db2->FetchResult($result,0,'id');
	    	}
	    	$this->_promotion_id=$id;
    	} else $id=$this->_promotion_id;
    	$product_no=$this->values['product_no'];
    	$query="SELECT id FROM product_attrib_int WHERE product_no=$product_no AND attrib=$id AND value=1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		if ($num_rows!=0) return "1";
    		else return "0";
    	}
    	return "0";
    }

    /**
     * Sprawd¼ czy produkt nale¿y umie¶ciæ na li¶cie nowo¶ci
     * Zwracamy stringa a nie boola ¿eby móc go odrazu wrzuciæ do bazy danych
     *
     * @return string
     */
    function check_newcol() {
    	if (empty($this->_newcol)) {
	    	$query="SELECT id FROM dict_product_attrib WHERE name='NOWOSCI'";
	    	$result=$this->db2->Query($query);
	    	if ($result!=0) {
	    		$id=$this->db2->FetchResult($result,0,'id');
	    	}
	    	$this->_newcol=$id;
    	} else $id=$this->_newcol;
    	$product_no=$this->values['product_no'];
    	$query="SELECT id FROM product_attrib_int WHERE product_no=$product_no AND attrib=$id AND value=1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		if ($num_rows!=0) return "1";
    		else return "0";
    	}
    	return "0";
    }    

    /**
     * Sprawd¼ czy produkt nale¿y umie¶ciæ na li¶cie bestsellerów
     * Zwracamy stringa a nie boola ¿eby móc go odrazu wrzuciæ do bazy danych
     *
     * @return string
     */
    function check_bestseller() {
    	if (empty($this->_bestseller)) {
	    	$query="SELECT id FROM dict_product_attrib WHERE name='POLECAMY'";
	    	$result=$this->db2->Query($query);
	    	if ($result!=0) {
	    		$id=$this->db2->FetchResult($result,0,'id');
	    	}
	    	$this->_bestseller=$id;
    	} else $id=$this->_bestseller;
    	$product_no=$this->values['product_no'];
    	$query="SELECT id FROM product_attrib_int WHERE product_no=$product_no AND attrib=$id AND value=1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		if ($num_rows!=0) return "1";
    		else return "0";
    	}
    	return "0";
    }    

    /**
     * Sprawd¼ czy produkt nale¿y umie¶ciæ na stronie g³ównej
     * Zwracamy stringa a nie boola ¿eby móc go odrazu wrzuciæ do bazy danych
     *
     * @return  string
     */
    function check_main_page() {
    	if (empty($this->_main_page)) {
	    	$query="SELECT id FROM dict_product_attrib WHERE name='WYPRZEDAZ'";
	    	$result=$this->db2->Query($query);
	    	if ($result!=0) {
	    		$id=$this->db2->FetchResult($result,0,'id');
	    	}
	    	$this->_main_page=$id;
    	} else $id=$this->_main_page;
    	$product_no=$this->values['product_no'];
    	$query="SELECT id FROM product_attrib_int WHERE product_no=$product_no AND attrib=$id AND value=1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$num_rows=$this->db2->NumberOfRows($result);
    		if ($num_rows!=0) return "1";
    		else return "0";
    	}
    	return "0";
    }
    
    /**
     * Nazwa producenta
     * Na podstawie identyfikatora podajemy nazwe producenta
     *
     * @param int $id
     * @return string
     */
    function get_producer_name($id) {
    	global $db;
    	$query="SELECT producer FROM producer WHERE id=$id";
    	$result=$db->Query($query);
    	$name="";
    	if ($result!=0) {
    		$name=$db->FetchResult($result,0,'producer');
    	}
    	return $name;
    }
    
    /**
     * Generujemy drzewo kategorii - jak jest ¶cie¿ka kategorii powy¿ej kategorii o danym ID
     *
     * @param int $id
     */
    function get_category_tree($id) {
    	reset ($this->category1);
    	@reset ($this->category2);
    	@reset ($this->category3);
    	@reset ($this->category4);
    	@reset ($this->category5);
    	if (@array_key_exists($id,$this->category5)) {
    		$this->category['category5']=array("id"=>$id,
    										   "name"=>$this->category5[$id]['name']);
    		$id=$this->category5[$id]['parent'];
    	} else {
    		$this->category['category5']=array("id"=>'',
    										   "name"=>'');
    	}
    	if (@array_key_exists($id,$this->category4)) {
    		$this->category['category4']=array("id"=>$id,
    										   "name"=>$this->category4[$id]['name']);
    		$id=$this->category4[$id]['parent'];
    	} else {
    		$this->category['category4']=array("id"=>'',
    										   "name"=>'');
    	}
    	if (@array_key_exists($id,$this->category3)) {
    		$this->category['category3']=array("id"=>$id,
    										   "name"=>$this->category3[$id]['name']);
    		$id=$this->category3[$id]['parent'];
    	} else {
    		$this->category['category3']=array("id"=>'',
    										   "name"=>'');
    	}
    	if (@array_key_exists($id,$this->category2)) {
    		$this->category['category2']=array("id"=>$id,
    										   "name"=>$this->category2[$id]['name']);
    		$id=$this->category2[$id]['parent'];
    	} else {
    		$this->category['category2']=array("id"=>'',
    										   "name"=>'');
    	}
    	if (@array_key_exists($id,$this->category1)) {
    		$this->category['category1']=array("id"=>$id,
    										   "name"=>$this->category1[$id]['name']);
    		
    	} else {
    		$this->category['category1']=array("id"=>'',
    										   "name"=>'');
    	}
    	return 0;
    }
    
    /**
     * Zwróæ ¶cie¿ke identyfikatorów drugiej kategorii
     * Tutaj generujemy dane pierwszej dodatkowej kategorii
     *
     * @return string
     */
    function get_extra_cat1_path() {
    	$id=$this->values['product_no'];
    	$query="SELECT category FROM category WHERE product_no=$id ORDER BY id LIMIT 1,1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$id_category=$this->db2->FetchResult($result,0,'category');
    		$this->get_category_tree($id_category);
			$this->extra_cat1_path=$this->category['category1']['id'];
			if (!empty($this->category['category2']['id'])) {
				$this->extra_cat1_path.="_".$this->category['category2']['id'];
			}
			if (!empty($this->category['category3']['id'])) {
				$this->extra_cat1_path.="_".$this->category['category3']['id'];
			}
			if (!empty($this->category['category4']['id'])) {
				$this->extra_cat1_path.="_".$this->category['category4']['id'];
			}
			if (!empty($this->category['category5']['id'])) {
				$this->extra_cat1_path.="_".$this->category['category5']['id'];
			}
    	}
    	return $this->extra_cat1_path;
    }

    /**
     * Zwróæ ¶cie¿ke pierwszej dodatkowej kategorii produktu
     *
     * @return string
     */
    function get_extra_cat1_name() {
    		$this->extra_cat1_name=$this->category['category1']['name'];
			if (!empty($this->category['category2']['name'])) {
				$this->extra_cat1_name.="/".$this->category['category2']['name'];
			}
			if (!empty($this->category['category3']['name'])) {
				$this->extra_cat1_name.="/".$this->category['category3']['name'];
			}
			if (!empty($this->category['category4']['name'])) {
				$this->extra_cat1_name.="/".$this->category['category4']['name'];
			}
			if (!empty($this->category['category5']['name'])) {
				$this->extra_cat1_name.="/".$this->category['category5']['name'];
			}
			return $this->extra_cat1_name;
    }

    
    /**
     * Zwróæ ¶cie¿ke identyfikatorów drugiej kategorii
     * Tutaj egenrujemy dane drugiej kategorii na podstawie identyfiaktora produktu i bazy danych
     *
     * @return string
     */
    function get_extra_cat2_path() {
    	$id=$this->values['product_no'];
    	$query="SELECT category FROM category WHERE product_no=$id ORDER BY id LIMIT 2,1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$id_category=$this->db2->FetchResult($result,0,'category');
    		$this->get_category_tree($id_category);
			$this->extra_cat2_path=$this->category['category1']['id'];
			if (!empty($this->category['category2']['id'])) {
				$this->extra_cat2_path.="_".$this->category['category2']['id'];
			}
			if (!empty($this->category['category3']['id'])) {
				$this->extra_cat2_path.="_".$this->category['category3']['id'];
			}
			if (!empty($this->category['category4']['id'])) {
				$this->extra_cat2_path.="_".$this->category['category4']['id'];
			}
			if (!empty($this->category['category5']['id'])) {
				$this->extra_cat2_path.="_".$this->category['category5']['id'];
			}
    	}
    	return $this->extra_cat2_path;
    }

    /**
     * Zwróæ ¶cie¿ke drugiej dodatkowej kategorii produktu
     * Easyshop tak naprawde pozwala na wiêcej dodatkowych kategorii, ale my obs³ugujemy tylko pierwsze dwie
     *
     * @return string
     */
    function get_extra_cat2_name() {
    		$this->extra_cat2_name=$this->category['category1']['name'];
			if (!empty($this->category['category2']['name'])) {
				$this->extra_cat2_name.="/".$this->category['category2']['name'];
			}
			if (!empty($this->category['category3']['name'])) {
				$this->extra_cat2_name.="/".$this->category['category3']['name'];
			}
			if (!empty($this->category['category4']['name'])) {
				$this->extra_cat2_name.="/".$this->category['category4']['name'];
			}
			if (!empty($this->category['category5']['name'])) {
				$this->extra_cat2_name.="/".$this->category['category5']['name'];
			}
			return $this->extra_cat2_name;
    }
        
    
    /**
     * Zwróæ nazwe 1-ej kategorii produktu
     * Jako ¿e w easyshopie jest zupe³nie inna struktura kategorii produtków 
     * konieczne jest jej przerobienie na nasz format
     * tutaj jest tworzona tablica z nazwami i identyfikatorami kolejnych kategorii danego produktu
     *
     * @return string
     */
    function get_category1_name() {
    	$id=$this->values['product_no'];
    	$query="SELECT category FROM category WHERE product_no=$id ORDER BY id LIMIT 1";
    	$result=$this->db2->Query($query);
    	if ($result!=0) {
    		$id_category=$this->db2->FetchResult($result,0,'category');
    		$this->get_category_tree($id_category);
    	}
    	return $this->category['category1']['name'];
    }
    
    /**
     * Zwróæ identyfikator 1-ej kategorii produktu
     *
     * @return int
     */
    function get_id_category1() {
    	return $this->category['category1']['id'];
    }
    
    /**
     * Zwróæ nazwe 2-ej kategorii produktu
     *
     * @return string
     */
    function get_category2_name() {
    	return $this->category['category2']['name'];
    }
    
    /**
     * Zwróæ identyfikator 2-ej kategorii produktu
     *
     * @return int
     */
    function get_id_category2() {
    	return $this->category['category2']['id'];
    }
    
    /**
     * Zwróæ nazwe 3-ej kategorii produktu
     *
     * @return string
     */
    function get_category3_name() {
    	return $this->category['category3']['name'];
    }
    
    /**
     * Zwróæ identyfikator 3-ej kategorii produktu
     *
     * @return int
     */
    function get_id_category3() {
    	return $this->category['category3']['id'];
    }
    
    /**
     * Zwróæ nazwe 4-tej kategorii produktu
     *
     * @return string
     */
    function get_category4_name() {
    	return $this->category['category4']['name'];
    }
    
    /**
     * Zwróæ identyfikator 4-tej kategorii produktu
     *
     * @return int
     */
    function get_id_category4() {
    	return $this->category['category4']['id'];
    }
    
    
    /**
     * Zwróæ nazwe 5-tej kategorii produktu
     *
     * @return string
     */
    function get_category5_name() {
    	return $this->category['category5']['name'];
    }
    
    /**
     * Zwróæ identyfikator 5-tej kategorii produktu
     *
     * @return int
     */
    function get_id_category5() {
    	return $this->category['category5']['id'];
    }
    
    /**
     * Zwróæ identyfikator producenta
     *
     * @return int
     */
    function get_producer_id() {
    	return $this->values['manufacturer'];
    }
    
    /**
     * Zwracamy wersje danych
     * Pole jest wymagane aby wy¶wietlaæ produkty w sklepie i jako ¿e pracujemy na wersji 3.1 (wcze¶niejsze nie mia³y importshop) warto¶æ jest sztywna
     *
     * @return 30
     */
    function record_version() {
    	return 30;
    }
    
    /**
     * Zwracamy VAT
     * Jako ¿e easyshop nie ma podzia³u na ró¿ne stawki VAT - zak³adamy ¿e to jest zawsze 22
     *
     * @return 22
     */
    function getVat() {
    	return 22;
    }
    
    /**
     * Zwracamy opis produktu
     * Jako ¿e w easyshopie opisy s± wieloczê¶ciowe i w ró¿nych formatach - ³±czymy je i zwracamy jako pe³en opis
     * Tutaj jest pomieszanie danych z prezentacj± i nie da siê odtworzyæ dok³adnie wygl±du opisu produktu
     *
     * @return string
     */
    function get_txt_attributes() {
    	$id=$this->values['product_no'];
    	$query="SELECT attrib,value FROM product_attrib_txt WHERE product_no=$id";
    	$result=$this->db2->Query($query);
    	$description="";
    	if ($result!=0) {
    		$num_rows = $this->db2->NumberOfRows($result);
    		for ($i=0;$i<$num_rows;$i++) {
    			$description.=$this->db2->FetchResult($result,$i,'value');
    			$description.="<br>\n";
    		}
    	}
    	return $description;
    }
    
    /**
     * Zwróæ krótki opis produktu
     * W easyshop jedno z pól jest wykorzystywane jako skrócony opis - ten opis jest wykorzystywany jako pole xml_short_description
     *
     * @return string
     */
    function get_short_description() {
    	$id=$this->values['product_no'];
    	$query="SELECT value FROM product_attrib_txt WHERE product_no=$id AND attrib=4";
    	$result=$this->db2->Query($query);
    	$description="";
    	if ($result!=0) {
			$description=$this->db2->FetchResult($result,0,'value');
		}
//		die ($description);
//		print "<pre>\n$description\n</pre>";
    	return $description;
    }
    
    /**
     * Tworzenie tre¶ci recenzjii
     * Jako ¿e recenzja w easyshop jest dwuczê¶ciowa - ³±czymy je i dajemy "tytu³owi" specjaln± prezentacje (bold i br)
     *
     * @param string $description
     * @return string
     */
    function make_review_description($description) {
    	$id=$this->values['id'];
    	$query="SELECT krotki FROM opinie WHERE id=$id";
    	$result=$this->db2->Query($query);
    	$short_desc="";
    	if ($result!=0) {
    		$short_desc=$this->db2->FetchResult($result,0,"krotki");
    		$short_desc="<b>$short_desc</b><br><br>";
    	}
    	$short_desc.=$description;
    	return $short_desc;
    }

    /**
     * Aktywno¶æ recenzji
     * Jako ¿e recenzje w easyshop mog± mieæ kilka statusów - wszystkie oprócz aktywnych s± uznawane za nieaktywne
     *
     * @param int $state
     * @return string
     */
    function review_active($state) {
    	if ($state!="1") {
    		return "0";
    	}
    	return "1";
    }
    
    /**
     * Identyfikator aktualnego produktu
     *
     * @return int
     */
    function reviews_prod_id() {
    	$id=$this->values['prod_no'];
    	return $id;
    }
    
    /**
     * Wersja jêzykowa
     * Jako ¿e easyshop jest jednojêzykowy zawsze zwracaj polske
     *
     * @return "pl"
     */
    function get_pl_lang() {
    	return "pl";
    }
    
    /**
     * Suma kontrolna od liczby losowej i obecnego czasu
     *
     * @return string
     */
    function calc_md5() {
    	return md5(time().rand());
    }
    
    /**
     * Pole tabeli w którym znajduje siê produkt na podstwie jego user_id
     *
     * @param string $user_id
     * @return int
     */
    function review_get_product_id($user_id) {
    	global $db;
    	$query="SELECT id FROM main WHERE user_id=$user_id";
    	$result=$db->Query($query);
    	$id="0";
    	if ($result!=0) {
    		$id=$db->FetchResult($result,0,'id');
    	}
    	return $id;
    }
    
    /**
     * Przetwarzanie oceny produktu
     * Ocena jest przekazywana do recenzji produktu oraz obliczana jest aktualna ¶rednia ocena aktywnych recenzji
     * Dane s± zapisywane do tabeli main, reviews oraz score
     *
     * @param int $score
     * @return int
     */
    function review_score($score) {
    	global $mdbd;
    	global $db;
    	global $stream;
    	$id_product=$this->review_get_product_id($this->values['prod_no']);
    	$score_amount=$score;
    	$scores_number=1;
    	$active=$this->review_active($this->values['zatwierdzone']);
    	if ($active) {
	    	$data=$mdbd->select("score_amount,scores_number","scores","id_product=?",array($id_product=>"text"));
	    	if (empty($last_review)) {
	    		$query = "INSERT INTO scores (id_product,score_amount,scores_number) VALUES ('$id_product','$score_amount','$scores_number')";
	    		$result=$db->query($query);
	    		if ($result==0) {
	    			die();
		    		$stream->line_green();
		    	}
	    	} else {
	    		$score_amount=$data['score_amout']+$score;
	    		$scores_number=$data['scores_amout']+1;
	    		$data=array($score=>"int",
	    					$scores_number=>"int",
	    					$id_product=>"text",
	    					);
	    		$query = "UPDATE scores SET score_amount='$score_amount',scores_number='$scores_number' WHERE id_product='$id_product'";
	    		$result=$db->query($query);
	    		if ($result==0) {
	    			die();
		    		$stream->line_green();
		    	}
	    	}
	    	
	    	$score_avg=$score_amount/$scores_number;
	    	$query = "UPDATE main SET user_score='$score_avg' WHERE id=$id_product";
	    	$result=$db->query($query);
	    	if ($result==0) {
	    		$stream->line_green();
	    	}
    	} else {
    		$stream->line_green();
    	}
    	return $score;
    }
    
    /**
     * Suma kontrolna od adresu e-mail
     * W sklepie u¿ywana ¿eby e-mail siê nie powtarza³
     *
     * @return string
     */
    function newsletter_md5() {
    	$md5=md5($this->values['mail'].$this->salt);
    	return $md5;
    }
    
    /**
     * Stan newslettera
     * Jako ¿e nie ma odpowiednika - zawsze aktywny
     *
     * @return 1
     */
    function newsletter_status() {
    	return "1";
    }
    
    /**
     * Dzisiejsza data w formacie YYYY-mm-dd
     *
     * @return string
     */
    function newsletter_get_date() {
    	$date= date("Y-m-d");
    	return $date;
    }
    /**
     * Cena bez vatu
     *
     * @return float
     */
    function product_price_currency() {
    	return $this->values['price']/1.22;
    }
    /**
     * Zawsze zero
     *
     * @return 0
     */
    function zero() {
    	return 0;
    }
    /**
     * Zawsze jeden
     *
     * @return 1
     */
    function one() {
    	return 1;
    }
    /**
     * Zwróæ identyfikator tej grupy
     *
     * @return int
     */
    function newsletter_groups_uid() {
    	return $this->values['id'];
    }
    /**
     * Zwróæ numer grupy newslettera takjak przyjmuje j± sklep
     *
     * @param int $id
     * @return string
     */
    function newsletter_groups($id) {
    	return ":$id:";
    }
} // end class EasyShop
?>

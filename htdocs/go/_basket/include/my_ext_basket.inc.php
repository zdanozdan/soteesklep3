<?php
require_once("include/cookie.inc");

require_once("./include/my_new_basket.inc.php");
require_once("./include/points_buy.inc.php");
// klasa do encodingu urla
include_once ("include/encodeurl.inc");

/**
 * Klasa koszyka oraz przechowalni produktów
 * Zapis do bazy danych, odtwarzanie na podstawie ciastka oraz sesji
 * Podmieniane podczas logowania uzytkownika
 * Mo¿liwo¶æ przenoszenia produktów pomiêdzy jednym a drugim
 * Weryfikacja obecno¶ci produktów w bazie i obecno¶ci poszczególnych opcji produktów
 * Dodawanie, usuwanie i edycja seryjna
 *
 * @author lukasz@sote.pl
 * @package basket
 * @version $Id: my_ext_basket.inc.php,v 1.5 2006/11/29 22:43:57 tomasz Exp $
 *
 */
class My_Ext_Basket extends My_New_Basket {

    /**
    * @var bool czy w tym obiekcie wolno trzymaæ nieaktywne obieky
    * @access private
    */
	var $_allow_not_avail; 

	var $_move_target; // obiekt do którego s± przenoszone produkty je¿eli nie wolno trzymaæ nieaktywnych w tym obiekcie

	var $_id_basket; // id wpisu do bazy danych zaw obecny koszyk

	var $_sess_name; // nazwa bie¿±cego obiektu w sesji i ciastku

	var $_auto_add=false; // czy dodawane produkty sa wewnêtrznie (³adowanie z bazy danych)

	var $_new_on_add=false; // czy stworzyæ nowe wpisy (cookie i baza) przy dodaniu pierwszego produktu

	var $_display_above=true; // czy to jest pierwszy element wy¶wietlany ? (koszyk czy przechowalnia)

	var $_key=''; // hash obiektów

	var $mode=''; // tryb obiektu (punkty/normalny/brak)

	var $point_check; // obiekt sprawdzaj±cy dostêpno¶æ produktu - zale¿nie od trybu ($mode) i innych parametrów.

	var $_error=false; // flaga b³êdu

	var $error_message=''; // je¿eli wyst±pi b³±d to tutaj bêdzie widoczny komunikat tekstowy.

	var $_error_code=0; // kod komunikatu b³êdu

	/**
	 * Konstruktor
	 *
	 * @return My_Ext_Basket
	 * @param string $type - typ obiektu (wishlist?)
	 */
	function My_Ext_Basket($type='') {
		//okre¶lamy czy dzia³amy na koszyku czy przechowalnu
		if ($type=='wishlist') {
			$this->_allow_not_avail=true;
			$this->mode='standard';
			$this->_sess_name='global_wishlist_data';
			$this->_display_above=false;
		} else {
			$this->_allow_not_avail=false;
			$this->mode='unset';
			$this->_sess_name='global_basket_data';
		}
		// obiekt sprawdzaj±cy dostêpno¶æ produktu
		$this->point_check=& new Points_Buy();
	}

	/**
	 * Podstawowe rzeczy które s± konieczne przy prze³adowaniu obiektu
	 * nie znajduj± sie w konstruktorze poniewa¿ obiekt musi ju¿ istnieæ aby wywo³ywaæ jego metody
	 * a dodawanie odczytanych z bazy produktów odbywa siê przez wewnêtrzn± metodê
	 *
	 */
	function init() {
		// sprawdzamy przypadek wywo³ania
		if ($this->_sess_is_good()) {
			// jest sesja
			$this->_load_from_session();
			if ($this->_display_above) return (0);
		} else {
			if ($this->_verify_cookie()) {
				// jest ciastko
				$this->_load_from_db();
			} else {
				// niema sesji ani ciastka - przy pierwszym dodanym producie dodajemy nowy koszyk/przechowalnie
				$this->_flush_cookie();
				$this->_new_on_add = true;
			}
		}
		if ($this->isEmpty() ) {
			$this->mode='unset';
//			&& $this->_display_above
		}
	}


	/**
	 * Zapisujemy dane w sesji, obliczamy koszta
	 *
	 */
	function register() {
		global $sess;
		global $global_wishlist_data;
		global $global_wishlist_count;
		global $global_basket_amount,$global_basket_count,$global_order_amount,$global_basket_data,$global_delivery;
		$this->calc();
		// niektore rzeczy takie jak liczba produktow w koszyku maja byc widoczne tylko dla koszyka a nie przechowalni
		if ($this->_display_above) {
			$global_basket_amount=$this->amount;
			$global_basket_count=$this->num;
			$sess->register("global_basket_amount",$global_basket_amount);
			$sess->register("global_basket_count",$global_basket_count);
			$global_order_amount=@$global_delivery['cost']+$global_basket_amount;
			$sess->register("global_order_amount",$global_order_amount);
		} else {
			$global_wishlist_count=$this->num;
			$sess->register("global_wishlist_count",$global_wishlist_count);
		}
		// zapamiêtaj stan koszyka w sesji
		$global_basket_data=array("items"=>$this->items,"count"=>$this->_count,"hash"=>$this->_key,"id_basket"=>$this->_id_basket,"mode"=>$this->mode);
		$global_wishlist_data=$global_basket_data;
		if ($this->_sess_name=='global_basket_data') {
			$sess->register('global_basket_data',$global_basket_data);
		} else {
			$sess->register('global_wishlist_data',$global_wishlist_data);
		}
		// kwota do zaplazy z kosztami dostawy
		if (! empty($_SESSION['global_delivery'])) {
			$global_delivery=$_SESSION['global_delivery'];
		}
	}

	/**
	 * £adujemy dane z sesji
	 *
	 * @return void
	 */
	function _load_from_session() {
		global $_SESSION;
		$basketdata=@$_SESSION[$this->_sess_name];
		// lista produktów
		$this->items=$basketdata['items'];
		// liczba produktów
		$this->_count=$basketdata['count'];
		// id koszyka
		$this->_id_basket=$basketdata['id_basket'];
		// klucz koszyka
		$this->_key=@$basketdata['hash'];
		$this->mode=@$basketdata['mode'];

		return;	
	}

	/**
	 * Sprawdzamy czy jest sesja dla tego obiektu
	 *
	 * @return bool
	 */
	function _sess_is_good() {
		global $_SESSION;
		//        return true;
		// czy istnieje sesja z danymi
		// i czy zawiera identyfikator koszyka
		if (isset($_SESSION[$this->_sess_name])) {
			$basketdata=$_SESSION[$this->_sess_name];
			if (! empty($basketdata['id_basket']) || $this->_display_above) {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * Czy¶cimy zawarto¶æ ciastka
	 * wywo³ywane je¿eli id obiektu w ciastku jest nieprawid³owe
	 *
	 */
	function _flush_cookie() {
		global $cookie;
		$cookie->write_array($this->_sess_name,array(""));
		$this->_new_on_add=true;
	}

	/**
	 * Sprawdzamy poprawno¶æ danych w ciastku
	 * innymi s³owy sprawdzamy czy relacja id do id w bazie i hashe z ciastka siê zgadzaj±
	 *
	 * @return bool
	 */
	function _verify_cookie() {
		global $db;
		global $cookie;
		// ³adujemy dane z ciastka
		$id_basket=$cookie->read_array($this->_sess_name);
		$hash=$cookie->read_array('hash');
		// sprawdzamy czy podane warto¶ci istniej±
		if (!empty($id_basket) && !empty($hash)) {
			// sprawdzamy czy w bazie wszystko jest ok
			$query="SELECT id FROM basket WHERE id=? AND `hash`=?";
			$prepared_query=$db->PrepareQuery($query);
			$db->QuerySetInteger($prepared_query,1,$id_basket);
			$db->QuerySetText($prepared_query,2,$hash);
			if ($prepared_query) {
				$result=$db->ExecuteQuery($prepared_query);
				if ($result!=0) {
					$num_rows=$db->NumberOfRows($result);
					// czy dostali¶my dok³adnie jeden wynik ?
					if ($num_rows==1) {
						// good - mo¿na ustawiæ zawarto¶æ ciastka jako aktywne
						$this->_id_basket=$id_basket;
						$this->_key=$hash;
						return true;
					} else return false;
				} else return false;
			} else return false;
		} else return false;
	}

	/**
	 * Zapis ciastka - utworzenie nowego wpisu do bazy danych.
	 *
	 * @return bool
	 */
	function _write_cookie() {
		global $cookie;
		// czytamy klucz z ciastka
		// istotne bo nie wiemy czy najpierw zapisali¶my klucz do tego obiektu czy do jego brata
		// (relacja koszyk <=> przechowalnia)
		$key=$cookie->read_array('hash');
		// je¿eli jest ju¿ klucz w ciastku to go wykorzystaj
		// je¿eli nie - wygeneruj nowy
		if (($key==null) || empty($key)) {
			// generujemy klucz
			$key=md5(time().$this->_sess_name);
		}
		// zapisujemy klucz obiektu
		$this->_key=$key;
		//tworzymy wpis do bazy danych
		$this->_new_db_basket();
		// je¿eli poprawnie nadano nowe id to je zapisz
		if ($this->_id_basket!=0) {
			// zapisujemy wygenerowane dane do ciastka
			$cookie->write_array($this->_sess_name,array($this->_id_basket));
			$cookie->write_array('hash',array($key));
		} else return false;
		return true;
	}

	/**
	 * Stwórz nowy wpis do bazy danych zawieraj±cy koszyk
	 * i ustaw $this->_id_basket na tej podstawie
	 *
	 */
	function _new_db_basket() {
		if ($this->_display_above) {
			$this->_id_basket=0;
			return 0;
		}
		global $db;
		$query="INSERT INTO `basket` (`hash`,`date_update`) VALUES (?,NOW());";
		$prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
			$db->QuerySetText($prepared_query,1,$this->_key);
			$db->QuerySetText($prepared_query,2,'NOW()');
			$db->ExecuteQuery($prepared_query);
			$query="SELECT max(id) FROM basket";
			$result_id=$db->Query($query);
			if ($result_id!=0) {
				// szukamy ostatniego dodanego wiersza
				$num_rows=$db->NumberOfRows($result_id);
				if ($num_rows==1) {
					$id=$db->FetchResult($result_id,0,'max(id)');
					$this->_id_basket=$id;
				} else return 4; // b³±d odczytu nowego pola (z³a liczba pól zwrócona)
			} else return 5; // b³±d odczytu nowego pola (nie dodano pola ?)
		} else return 6; //b³±d dodania nowego pola
		// wszystko posz³o dobrze :)
		return 1;
	}

	/**
	 * £adowanie koszyka/przechowalni z bazy danych
	 *
	 */
	function _load_from_db() {
		if ($this->_display_above) {
			//			print "Nic nie ³aduje!!!!";
			return (0);
		}
		global $db;
		$data='';
		$query="SELECT data FROM basket WHERE id=?";
		$prepared_query=$db->PrepareQuery($query);
		if (!empty($this->_id_basket)) {
			if ($prepared_query) {
				// za³aduj dane dot _tego_ obiektu
				$db->QuerySetInteger($prepared_query,1,$this->_id_basket);
				$result=$db->ExecuteQuery($prepared_query);
				if ($result!=0) {
					$data=$db->FetchResult($result,0,'data');
					$data=unserialize($data);
				} else return 2; // brak rezultatów
			} else return 3;// b³±d zapytania
		} else return 4;// brak zdefiniowanego id
		// czy jest co przetwarzaæ ?
		if (!empty($data)) {
			// blokada na sprawdzanie xml_options
			$this->_auto_add=true;
			foreach ($data as $value=>$key) {
				if ($data[0]!="Blank") {
					$user_id=$key['user_id'];
					$num=$key['num'];
					$xml_options=@$key['xml_options'];
					$xml_options=unserialize($xml_options);
					// w koszyku funkcjonuje id a nie user_id
					$id=$this->_get_id($user_id);
					$this->add_prod($id,$num,$xml_options,'','',true);
				} else {
					$this->items=array();
					$this->_count=0;
					$this->basket_amount=0;
					$this->num=0;
					$this->amount=0;
				}
			}
			// zdjêcie blokady
			$this->_auto_add=false;
		}
		return (0);
	}

	/**
	 * Zapisujemy wszystko w bazie danych
	 *
	 */
	function _save_to_db() {
		if ($this->_display_above) {
			return (0);
		}
		global $db;
		$data=array();
		if (true) {
			if (!empty($this->items)) {
				// zapisujemy dane potrzebne do odtworzenia koszyka
				foreach ($this->items as $value=>$key) {
					$num=$key['num'];
					$id=$key['ID'];
					if (isset($key['options'])) {
						$xml_options=$key['options'];
						$xml_options=serialize($xml_options);
					} else $xml_options='';
					// zapisujemy user_id poniewa¿ ono nie ulega zmianom
					$user_id=$this->_get_user_id($id);
					$data[]=array("user_id"=>$user_id,"num"=>$num,"xml_options"=>$xml_options);
				}
			}
			if (empty($data)) { $data[]="Blank" ;}
			$data=serialize($data);
			$query="UPDATE basket SET data=? WHERE id=?";
			$prepared_query=$db->PrepareQuery($query);
			if ($prepared_query && !empty($this->_id_basket)) {
				$db->QuerySetText($prepared_query,1,$data);
				$db->QuerySetInteger($prepared_query,2,$this->_id_basket);
				$result=$db->ExecuteQuery($prepared_query);
				if ($result!=0) {
					return 2; // b³±d podczas zapisywania informacji w bazie
				}
			} return 3; // b³±d przygotowanego zapytania/puste id koszyka
		} return 4;// b³±d pobierania listy produktów
	}

	/**
	 * Wyci±gnij z bazy danych user_id produktu na podstawie jego id
	 *
	 * @param int $id
	 * @return string
	 */
	function _get_user_id($id) {
		global $mdbd;
		$user_id='';
		if (empty($id)) return "unknown";
		$user_id=$mdbd->select('user_id','main',"id=?",array("$id"=>"int"));
		return $user_id;
	}

	/**
	 * Wyci±gnij z bazy danych id produktu na podstawie jego user_id
	 *
	 * @param string $user_id
	 * @return int
	 */
	function _get_id($user_id) {
		global $mdbd;
		$id=0;
		$id=$mdbd->select('id','main','user_id=?',array("$user_id"=>"text"));
		return $id;
	}

      function check_options($id,$num=1,$xml_options='',$basket_cat='',$ext_basket='',$ignore_lock=false) 
         {
            if (!$this->_auto_add)
            {
               require_once("force_basket_options.inc.php");
               if (check_options($id, $xml_options) == false)
               {
                  return true;
               }
            }
            return false;
         }

	function del_product($id) 
         {
            unset($this->items[$id]);
         }
	/**
	 * Dodaj produkt do obiektu
	 *
	 * @param int $id
	 * @param int $num
	 * @param mixed $xml_options
	 * @param mixed $basket_cat
	 * @param mixed $ext_basket
	 * @param bool $ignore_lock
	 */
      function add_prod($id,$num=1,$xml_options='',$basket_cat='',$ext_basket='',$ignore_lock=false) 
         {       
            /////////////////////////////////////////////////////////////
            //TZ begin
            //sprawdzanie czy dany towar ma przydzielone opcje xml
            
            $options_exit = false;
            //print "<br><br>add_prod ID " . $id . " Num : " . $num . " XML : " . $xml_options . "<br>";
            if (!$this->_auto_add)
            {
               require_once("force_basket_options.inc.php");
               if (check_options($id, $xml_options) == false)
               {
                  //print "check options ID " . $id . " Num : " . $num . " XML : " . $xml_options . "<br>";
                  // przenosimy usera na strone wyboru opcji która jest w theme 
                  $options_exit = true;
                  //$location = "Location:/go/_info/options_only.php?id=" . $id;
                  //header($location);
               }
            }

            if ($options_exit == false)
            {
               // produkt jest niedostepny do tego stopnia ze w ogole nie figuruje w bazie danych
               // sprawdz czy produkty maja byc sprawdzane pod katem obecnosci.
               if ($this->point_check->check_avail($id,$this->mode)!='1') 
               {
                  $this->error($this->point_check->check_avail($id,$this->mode));
                  //$this->_show_error();
                  return (0);
               }
               if ($this->mode=='points') 
                {
                   $this->add_for_points($id,$num,$xml_options);
                   return (0);
		}
               if (!$this->_allow_not_avail && $this->_auto_add) 
               {
                  if ($this->_get_user_id($id)=='unknown') 
                  {
                     // produkt jest niedostepny
                     $this->_move_target->_add_unknown_product($id,$num);
                     return;
                  } 
                  else if ($this->_check_avail($id,$xml_options)) 
                  {
                     // produkt jest dostepny - dodajemy
                     $this->add($id,$xml_options,$num,$basket_cat,$ext_basket,$ignore_lock);
                  } 
                  else 
                  {
                     // produkt niedostepny - dodajemy, ale do brata
                      $this->_move_target->add_prod($id,$num,$xml_options,$basket_cat,$ext_basket,$ignore_lock);
                      // zaznaczamy jako niedostepny
                      $this->_move_target->_mark_unavail($this->_count);
                  }
                  // tutaj zaczynamy dzialania na produktach ktore napewno beda dodane do tego obiektu
               } 
               else if ($this->_auto_add) 
                {
                   if ($this->_get_user_id($id)=='unknown') 
                   {
                      // produkt jest niedostepny
                      $this->_add_unknown_product($id,$num);
                   } 
                   elseif (!$this->_check_avail($id,$xml_options)) 
                   {
                      // produkt jest niedostepny ale istnieje (xml_options)
                      $this->add($id,$xml_options,$num,$basket_cat,$ext_basket,$ignore_lock);
                      $this->_mark_unavail($this->_count);
                   } 
                   else 
                   {
                      $this->add($id,$xml_options,$num,$basket_cat,$ext_basket,$ignore_lock);
                   }
		} 
               else 
               {
                  $this->add($id,$xml_options,$num,$basket_cat,$ext_basket,$ignore_lock);
               }
               // czy pozwalamy na dodawanie niedostêpnych produktów
               // i czy dodajemy automatycznie (nie ladujac z bazy danych)
               // czy to jest pierwsze wywolanie koszyka usera ktory nie ma ciastka, id ani wpisu ?
               if ($this->_new_on_add) 
               {
                  // wygeneruj id, klucz i zapisz to w ciastku
                  $this->_write_cookie();
               }
               // wy³±cz generowanie nowego ciastka
               $this->_new_on_add=false;
               // zapisz do bazy i zarejestruj                
               $this->_save_to_db();
               //

               //global $http_referer;
               //$location = "Location: ".$http_referer;
            }
            //TZ end
            /////////////////////////////////////////////////////////////            
            return (0);
	}

	/**
	 * Prze³adowanie zawarto¶ci koszyka - 
	 * usuniêcie wszystkich produktów które znajduj± siê w obiekcie i ich ponowne dodanie
	 * celem np. ponownego obliczenia ceny, rabatu itd.
	 * wykorzystywane przy okazji logowania uzytkownika i wej¶cia w grupe rabatow±.
	 *
	 */
	function reload(){
		$old_items=$this->items;
		$this->emptyBasket();
		if (count($old_items)>=1) {
			foreach ($old_items as $key=>$value) {
				$this->add_prod($value['ID'],$value['num'],$value['data']['options'],'','',true);
			}
		}
		$this->register();
	}
	
	/**
	 * Usuwamy wiele produktów
	 *
	 * @param array $items - array($int_id1,$int_id2)
	 */
	function del_many_prod($items) {
		$this->del_many($items);
		$this->update_points();
		$this->_save_to_db();
		if (empty($this->items) && $this->_display_above) {
			$this->mode='unset';
		}
		return (0);
	}

	/**
	 * Dodajemy do listy produkt który nie figuruje w bazie danych
	 *
	 * @param unknown_type $id
	 * @param unknown_type $num
	 */
	function _add_unknown_product($id,$num) {
		global $config;
		global $lang;
		global $sess;
		global $_SESSION;
		$link['before']="<a href=\"/?did=$id\">";
		$link['after']="</a>";
		foreach ($config->lang_active as $key=>$value) {
			$sess_data[$key]=$link['before'].$lang->basket_elements['name_unavailable'].$link['after'];
			$lang_id=array_search($key,$config->langs_symbols);
			$sess_data["$lang_id"]=$link['before'].$lang->basket_elements['name_unavailable'].$link['after'];
		}
		$lang_names=$_SESSION['products_lang_name'];
		$lang_names[$lang->basket_elements['name_unavailable']]=$sess_data;
		$sess->register("products_lang_name",$lang_names);
		$data=array();
		$data['vat']=0;
		$data['weight']=0;
		$data['options']='';
		$data['ID']=$id;
		$data['lang_names']=$sess_data;
		$data['user_id']="unavailable";
		$this->items[++$this->_count]=array("ID"=>$id,"name"=>$lang->basket_elements['name_unavailable'],"num"=>$num,"price"=>'0',"data"=>$data,"unavail"=>1);
		return (0);
	}

	/**
	 * Zaznacz produkt jako niedostepny
	 *
	 * @param int $int_id - wewnetrzne id produktu w tabeli items
	 */
	function _mark_unavail($int_id) {
		$this->items[$int_id]["unavail"]="1";
		return (0);
	}

	/**
	 * Zaznacz produkt jako dostepny
	 *
	 * @param int $int_id - wewnetrzne id produktu w tabeli items
	 */
	function _mark_avail($int_id) {
		unset($this->items[$int_id]["unavail"]);
		return (0);
	}


	/**
	 * Przenosimy produkty z jednego obiektu do drugiego
	 *
	 * @param array $items - array ($int_id_in_basket => $is_checked)
	 */
	function move_many_prod($items) {
		foreach ($items as $key => $value) {
			$int_id=key($value);
			$id=$this->items[$int_id]['ID'];
			$xml_options=$this->items[$int_id]['options'];
			$num=$this->items[$int_id]['num'];
			$this->_move_target->add_prod($id,$num,$xml_options,'','',true);
		}
		$this->del_many_prod($items);
		$this->_save_to_db();
		return (0);
	}

	/**
	 * Sprawd¼ czy produkt jest dostêpny
	 *
	 * @param int $id - id produktu
	 * @param string $xml_options - opcje xml produktu
	 * @return bool
	 */
	function _check_avail($id,$xml_options='') {
		global $db;
		$is_xml=false;
		// czy s± jakie¶ opcje xml
		if (!empty($xml_options)) {
			// czy s± zapisane w tablicy
			if (is_array($xml_options)) {
				foreach ($xml_options as $key) {
					// czy s± ró¿ne od zera ?
					if ($key!="") $is_xml=true;
				}
			}
		}
		if ($is_xml && $this->_auto_add) return false;
		$sql="SELECT id FROM main WHERE id=? AND active=1 AND ask4price!=1 AND hidden_price!=1";
		$prepared_query=$db->PrepareQuery($sql);
		if ($prepared_query) {
			$db->QuerySetInteger($prepared_query,1,$id);
			$result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
				$num_rows=$db->NumberOfRows($result);
				if ($num_rows==1) {
					return true; // znaleziono dok³adnie jeden produkt który spe³nia kryteria;
				}
			}
		}
		return false;
	}

	
	/**
	 * Aktualizacja liczby produktów na stronie.
	 *
	 * @param array $items array (array($id=>$num),array($id2=>$num),[...])
	 */
	function update_many($items) {
		// je¿eli operujemy na produktach punktowych to aktualizujemy liczbe punktów
		if ($this->mode=='points') {
			foreach ($items as $key) {
				$id=key($key);
				$value=$key[$id];
				// nie pozwalamy na ujemne warto¶ci liczby produktów
				// ¿eby nie umo¿liwiæ wygenerowania -1000 punktów i skorzystania z ró¿nicy aby wk³adaæ do koszyka kolejne produkty
				if ($value<0) {
					$value=0;
				}
				// aktualna liczba punktów w warto¶æ punktowa produktu (liba punktów obecnie/liczba produktów obecnie) * nowa ilo¶æ produktów
				$this->items[$id]['points_value']=$this->items[$id]['points_value']/$this->items[$id]['num']*$value;
			}
		}
		// lepiej nie ryzykowaæ
		reset($items);
		if ($this->mode=="points") {
			// to wszystko robimy tylko je¿eli jestesmy w trybie punktowym
			// w przeciwny wypadku mielibysmy zera i cholera wie co siê stanie
			$this->update_points();
			$total_points=@$_SESSION['form']['points']+@$_SESSION['form']['points_reserved'];
			if ($this->_points_value>$total_points) {
				// jest za ma³o punktów - wiêc wywo³ujemy b³êda
				$this->error(302);
				// i ³adujemy dane z sesji jeszcze raz - bo juz je zmienili¶my w obiekcie
				$this->_load_from_session();
				// i jeszcze raz przeliczamy punkty
				$this->update_points();
			} else {
				// wywo³ujemy metode rodzica - po co pisaæ to jeszcze raz jak ju¿ jest i dzia³a ? :)
				parent::update_many($items);
			}
		} else {
			parent::update_many($items);
		}
		// aktualizujemy liczbe dostêpnych punktów
	}

	/**
	 * Aktualizujemy liczbe punktów w sesji
	 * Uwaga!
	 * Jako ¿e mo¿liwe s± tutaj nadu¿ycia, konieczna jest weryfikacja sumy punktów
	 * zarezerwowanych i wolnych pod koniec zamówienia - czy te dane zgadzaj± sie z zawarto¶ci± bazy!
	 *
	 */
	function update_points($update_session=true) {
		global $sess;
		$points_total=0;
		reset ($this->items);
		// sumujemy punkty produktów które s± w sesji
		foreach ($this->items as $key=>$value) {
			$points_total=$points_total+@$value['points_value'];
		}
		reset($this->items);
		// czytamy dane które z sesji które bêdziemy aktualizowaæ
		$points_reserved=@$_SESSION['form']['points_reserved'];
		$points=@$_SESSION['form']['points'];
		// zuzytych jest wiecej punktow niz zapisanych w sesji
		// dodano produkt - zwiekszono jego ilosc
		if ($points_total>$points_reserved) {
			$points=$points-($points_total-$points_reserved);
			$points_reserved=$points_total;
		// zuzytych jest mniej punktow niz zapisanych w sesji
		// usunieto produkt - zmniejszono jego ilosc
		} else if ($points_total<$points_reserved) {
			$points=$points+($points_reserved-$points_total);
			$points_reserved=$points_total;
		}
		// je¿eli nie zaszed³ ¿aden z schematów opisanych powy¿ej - niema potrzeby czegokolwiek zmieniaæ
		// tworzymy kopie form z sesji
		$form=@$_SESSION['form'];
		// aktualizujemy dane
		$form['points']=$points;
		$form['points_reserved']=$points_reserved;
		$this->_points_value=$points_reserved;
		// zapisujemy w sesji
		if ($update_session) {
			$sess->register("form",$form);
		}
		// sprawdzamy czy nie trzeba zmieniæ trybu:
		// istotne tylko przy pustym koszyku
		if ($this->_display_above && $this->isEmpty()) {
			$this->mode='unset';
		}
	}

	/**
	 * Dodawanie produktów za punkty do listy
	 * Metoda jest w sumie zmodyfikowan± metod± add_produkt w której za³adowana jest "stara" zawarto¶æ basket_add.inc.php
	 *
	 * @param int $id - id produktu który ma zostaæ dodany
	 * @param int $num - ilo¶æ danego produktu
	 * @param string $xml_options - opcje xml do danego produtku (musz± byæ puste)
	 * @param bool $igonre_lock - czy zignorowaæ dodawanie tego produktu podczas pobytu w koszyku ?
	 */
	function add_for_points($id,$num=1,$xml_options='',$ignore_lock=false) {
		global $global_prev_request_md5;
		global $global_request_md5;
		global $sess;
		global $config;
		global $db;
		if ($xml_options!='') {
			// do koszyka w trybie punktowym nie wolno dodawaæ produktów z xml_options!!!
			$this->error("103");
			return;
		}
		$reload=false;
		if (! empty($global_prev_request_md5)) {
			if ($global_prev_request_md5==$global_request_md5) {
				// wywolano reload w koszyku, zapamietaj zeby nie dodawac produktu
				$reload=true;
			}
		}
		$ignore_lock=true;
		if ($num==0) $num=1;
		// sprawdzamy czy wolno nam dodaæ produkt - czy nie ma prze³adowania strony itd.
		if ((($reload==false) && (@$_SESSION['basket_add_lock']!=1)) || $ignore_lock) {
			// tutaj zaczynamy dodawanie
			// w³±czamy blokade
			$basket_add_lock=1;
			$sess->register("basket_add_lock",$basket_add_lock);

			// zapytanie o wlaciwosci rekordu
			$query = "SELECT * FROM main WHERE id=? AND active=1";
			$prepared_query=$db->PrepareQuery($query);
			$db->QuerySetText($prepared_query,1,"$id");
			$result=$db->ExecuteQuery($prepared_query);

			// tutaj skorzystamy z mo¿liwo¶ci dodanej obs³ugi b³êdów do koszyka...
			if ($result==0) {
				// nie ma takiego produktu lub b³±d w zapytaniu
				$this->error("102");
				return;
			}
			// je¿eli dot±d by³o ok - to lecimy dalej
			$id=$db->FetchResult($result,0,"id");
			$user_id=$db->Fetchresult($result,0,"user_id");

			// odczytaj nazwy w aktywnych jezykach
			$name=$db->FetchResult($result,0,"name_L0");
			for($i = 0; $i < count($config->langs_active); $i++) {
				if($config->langs_active[$i] == 1) {
					$lang_name[$config->langs_symbols[$i]]=$db->FetchResult($result,0,"name_L" . $i);
					$lang_name[$i]=$lang_name[$config->langs_symbols[$i]];
					if (empty($lang_name[$config->langs_symbols[$i]])) {
						$lang_name[$config->langs_symbols[$i]] = $name;
						$lang_name[$i] = $name;
					}
				}
			}
			// zapamiêtaj w sesji t³umaczenia zakupionych produktów
			if (! empty($_SESSION['products_lang_name'])) {
				$products_lang_name=$_SESSION['products_lang_name'];
			} else $products_lang_name=array();
			$products_lang_name[$name]=$lang_name;
			$sess->register("products_lang_name",$products_lang_name);
			// end

			$producer=$db->FetchResult($result,0,"producer");
			$points_value=$db->FetchResult($result,0,"points_value");
			// zapamietaj do jakiej kategorii nalezy dodawany produkt; informacja ta bedzie wykorzytana
			// do stworzenia linku do kategorii produtku w celu kontynuwoania zakupow w danej kategorii
			$__add_basket_category['id_category1']=$db->Fetchresult($result,0,"id_category1");
			$__add_basket_category['id_category2']=$db->Fetchresult($result,0,"id_category2");
			$__add_basket_category['id_category3']=$db->Fetchresult($result,0,"id_category3");
			$__add_basket_category['id_category4']=$db->Fetchresult($result,0,"id_category4");
			$__add_basket_category['id_category5']=$db->Fetchresult($result,0,"id_category5");
			$__add_basket_category['category1']=$db->Fetchresult($result,0,"category1");
			$__add_basket_category['category2']=$db->Fetchresult($result,0,"category2");
			$__add_basket_category['category3']=$db->Fetchresult($result,0,"category3");
			$__add_basket_category['category4']=$db->Fetchresult($result,0,"category4");
			$__add_basket_category['category5']=$db->Fetchresult($result,0,"category5");
			$__add_basket_category['id_producer'] =$db->Fetchresult($result,0,"id_producer");
			$__add_basket_category['producer'] =$db->Fetchresult($result,0,"producer");
			$data['category']=$__add_basket_category;

			// dodatkowe atrybuty rekordu zapamietywane w koszyku
			// niektóre s± niepotrzebne i dla pewno¶ci zerowane
			$data['currency']=$config->currency;
			$data['vat']=0;
			$data['user_id']=$user_id;
			$data['weight']=0;
			$data['lang_names'] = $lang_name;
			// dodajemy obs³uge punktów
			
			// a teraz w³a¶ciwe dodawanie:
			//sprawdzamy czy produkt dodaæ, czy tylko zwiêkszyæ liczbe ju¿ istniej±cego?
			$pos=$this->getId($id,$data);
			// nie jest konieczna weryfikacja opcji koszyka tak jak by¶my to robili normalnie
			// poniewa¿ produkty punktowe nie mog± mieæ xml_options
			if ($pos>0) {
				// tutaj obs³uga zwiêkszania ilo¶ci
				$this->items[$pos]['num']++;
				$this->items[$pos]['points_value']=$points_value*$this->items[$pos]['num'];
				$this->update_points();
			} else {
				// poprostu dodajemy
				// dodaj produkt do koszyka
				$this->items[++$this->_count]=array("ID"=>$id,"name"=>$name,"num"=>$num,"price"=>0,"points_value"=>$points_value,"data"=>$data);
				// zaznaczamy produkt tak ¿eby nie mo¿na by³o go przenosiæ miêdzy przechowalni± a koszykiem
				$this->_mark_unavail($this->_count);
				// przenosimy odliczamy punkty (w sesji)
				$form=$_SESSION['form'];
				
				$form['points_reserved']=@$form['points_reserved']+$points_value;
				if ((empty($form['points_left']) && @$form['points_left']!=0) || @$form['points_left']<0) {
					$form['points_left']=$form['points'];
				}
				$form['points']=$form['points']-$points_value;
//				$form['points_left']=$form['points_left']-$points_value;
				$sess->register("form",$form);
			}
		}
	}

	/**
	 * Pokazujemy kominikat b³êdu nad koszykiem, wraz z przyciskiem kontynuuj zakupy
	 *
	 * @return bool - true je¿eli wyst±pi³ b³±d, false je¿eli nie.
	 */
	function _show_error() {
		global $theme;
		global $lang;
		// dodajemy obs³uge b³êdów
                if ($this->_error) {
			// dodatkowy b³±d widoczny tylko w przechowalni
			// ¿eby pokazaæ ¿e do przechowalni nie mozna dodawac prezentow
			if (!$this->_display_above && $this->_error_code=="2") {
				$this->error("002");
			}
			print "<p>\n";
			print "<div align=\"left\">\n";
			print "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
			print "  <tr>\n";
			print "    <td valign=\"top\" align=\"left\">";
			// button kontynuuj zakupy
			if ($this->display=='form') {
                           $theme->button($lang->basket_order_continue,"/",220);
			}
			print "</td>\n";
			print "  </tr>\n";
			print "</table>\n";
			print "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
			print "  <tr>\n";
			print "    <td>\n";
			// pokaz kategorie dodawanego produktu - linki do ketegorii
			$this->add_category_links();
			print "<td>\n";
			print "  </tr>\n";
			print "</table>\n";
			print "</div>\n";
			print "<br><br>";
			print "<center>$this->error_message</center>";
			//			print "<b>$this->_error</b>";
			return true;
        }
		return false;
	}

      function updateAjaxBasket($type)
         {
            global $theme;
            global $shop;
            global $lang;

            if ($type=="head")
            {
               if (count($this->items) > 0)
               {
                  $this->showAjaxBasketLimited();
               }
               else
               {
                  $this->showEmptyBasket();
               }
            }

            if ($type=="normal")
            {
	      print "<table class='table table-bordered table-mikran'>";
               if (count($this->items) > 0)
               {
		 //print "<span id=\"header_4\">";
		 //print  "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" align=\"center\" width=\"100%\">\n";
                 $this->basket_thLimited($this->display,$this->_display_above);
                  
                  /* uaktualnij warto¶c zakupów i dodatkowe dane prodyuktów */
                  $this->calc();
                  
                  // wy¶wietl pozycje z koszyka w wierszach
                  reset($this->items);
                  foreach ($this->items as $id=>$item) {
                     $this->_rowLimited($id,$item);
                  }
                  
                  //echo "<tr><td class=\"summary_small\">".$lang->shopping_amount."</td><td></td><td></td><td></td><td></td><td class=\"red_summary\">".$theme->price($this->amount)."</td><td class=\"red_summary\">".$shop->currency->currency."</td><td></td></tr>";
                  //print "</table>";
                  //print "</span>";
               }
               else
               {
		 //print "<table width=\"100%\" class=\"block_1_basket\"><tr><td>";
                  $this->showEmptyBasket();
                  //print "</table>";
               }
	       print "</table>";
            }
         }

	/**
    * Formularz z zawartoscia koszyka.
    * Wyswo³anie funckji powoduje wy¶wietlenie na stronie koszyka + elementów formularza (zmiana ilo¶ci).
    * Funkcja wywo³uje tabelke z opisem oraz pe³ny formularz <form> ... </form>. WY¶wietlane te¿ s±
    * informacje o dostawie i promocjach, które mo¿na wybraæ w koszyku.
    *
    * @return wartosc zamowienia, bez kosztow dostawy
    * \@global object $basket        obiekt klasy Basket
    * \@global object $delivery_obj  obiekt z klasy Delivery
    */
      function showBasketForm() {
	global $theme;
	global $lang;
	global $delivery_obj;
	global $global_basket_calc_button;
	global $config;
	global $shop;

	// je¶li koszyk jest pusty to poka¿ odpowiedni komunikat
	if ($this->_display_above) {
	  $formname="basketForm";
	} else {
	  $formname="wishlistForm";
	  if ($this->display!="form") {
	    return;
	  }
	}
	if (empty($this->items)) 
	  {
	    if ($this->_display_above) 
	      {
		if ($this->_error) 
		  {
		    $theme->bar($lang->$formname);
		    $this->_show_error();
		    return;
		  }

		$theme->basket_empty();
		//$theme->file("basket_up_empty.html");
		print "<table width=\"100%\" class=\"block_1_basket\"><tr><td>";
		$this->showEmptyBasket();
		print "</table>";
	      } 
	    else {
	      if ($this->_error) {
		$theme->bar($lang->$formname);
		$this->_show_error();
		return;
	      }

	      $theme->wishlist_empty();
	      $theme->file("wishlist_up_empty.html");
	    }
	    return;
	  }

	if (!empty($_SESSION['current_step']))
	  $step = $_SESSION['current_step'];
	else
	  $step = 1;
	
	if ($this->_display_above)
	  $theme->display3steps($step);

	//print "</div>";
                
	print "<div>";
		if ($this->display=='form') {
			if ($this->_display_above) {
                           //$theme->theme_file("basket_up.html.php");
			} else {
                           $theme->theme_file("wishlist_up.html.php");
			}
		}

                $last_id_link = "<a href=/id" . $this->items[$this->_count]['ID']."/redirectname>".$lang->basket_order_continue2."</a>";
		
		print "<ul class='nav nav-pills'>";
		print "<li class='pull-right'>";
                print $last_id_link;
		print "</li></ul>";
		
		if ($this->mode!="points") {
                   //print "<br>".$lang->basket_currency.": ".$shop->currency->currency;
		}
				
		print "</div>";
		if ($this->display=="form") 
                {
                   if ($this->_display_above) 
                   {
                      // obs³uga ssl'a - tylko w koszyku
                      if ($config->ssl) 
                      {
                         global $sess;
                         print "<form action=\"https://".$_SERVER['HTTP_HOST']."/go/_basket/index.php\" method=\"post\" name=\"$formname\">\n";
                         // koniecznie przekazaæ sid przy takim przej¶ciu !
                         print "<input type=\"hidden\" name=\"sid\" value=".$sess->id.">\n";
                      } else 
                         print "<form onSubmit='return onFormSubmit(this);' action=\"/go/_basket/index.php\" method=\"post\" name=\"$formname\">\n";
                   } 
                   else 
                   {
                      print "<form action=\"/przechowalnia\" method=\"post\" name=\"$formname\">\n";
                   }
                   print "<input name=\"formName\" id=\"formName\" value=\"$formname\" type=hidden>\n";
		}
		
		// start koszyk lista produktów

                print "<span id=\"ajax_basket\">";
                print "<span id=\"header_4\">";
		print  "<table class='table table-bordered table-mikran'>";
		$this->basket_thLimited($this->display,$this->_display_above);

		/* uaktualnij warto¶c zakupów i dodatkowe dane prodyuktów */
		$this->calc();

		// wy¶wietl pozycje z koszyka w wierszach
		reset($this->items);
		foreach ($this->items as $id=>$item) {
		  $this->_rowLimited($id,$item);
		}
                //podsumowanie warto¶ci produktów koszyka
// 		global $shop;
// 		$shop->currency();
                $st = "style=\"font:bold 14px Tahoma;text-align:center;color:#FF0000\"";
                if ($this->display=="form")
                {
		  echo "<tr><td class=\"summary_small\">".$lang->shopping_amount."</td><td></td><td></td><td></td><td></td><td class=\"red_summary\" $st>".$theme->price($this->amount)."</td><td class=\"red_summary\">".$shop->currency->currency."</td></tr>";
                }
                else
                {
                   $price_netto = $theme->price($delivery_obj->delivery_cost/(1 + $delivery_obj->vat/100));
                   $price_brutto = $theme->price($delivery_obj->delivery_cost);
                   echo "<tr align=\"center\" bgcolor=" . @$config->theme_config['colors']['basket_td']."><td align=\"right\">".$lang->basket_delivery_cost.": "."(".$delivery_obj->delivery_name.")"."</td><td>".$price_netto."</td><td>".$delivery_obj->vat."</td><td>".$price_brutto."</td><td>1</td><td>".$price_brutto."</td></tr>";

                   $total = $theme->price($this->amount + $delivery_obj->delivery_cost);
                   echo "<tr $st align=\"center\"><td align=\"right\">".$lang->basket_total_order_amount.":"."</td><td></td><td></td><td></td><td></td><td $st>".$total." ".$shop->currency->currency."</td></tr>";
                }

		print "</table>";
                print "</span>";
                print "</span>";

                if ($this->display!="form")
                {
                   $p_num = $_SESSION['ajax_pay_number'];

		   //print "<p style=\"font:14px Tahoma\">P³atno¶æ:</p>";
		   print "<div class=\"alert alert-info text-left\">";
		   print "<p class='red-money'>";
		   print $lang->payment_method_table_title.": ".$lang->pay_method[$p_num];
		   print "</p>";
		   print $lang->payment_description_by_id[$p_num];
                   echo "<p style=\"font-size:12px;text-align:right\"><a href=\"/koszyk-start\"> << ".$lang->basket_change_message."</a></p>";
		   print "</div>";

		   print "<div class=\"alert alert-info text-left\">";
		   print "<p class='red-money'>";
		   print $lang->basket_delivery_country.": ". $lang->country[$_SESSION['global_country_delivery']];
		   print "</p>";
		   print "</div>";
                }

		if (($this->display=="form") && ($this->_display_above) && ($this->mode=='standard')) {
			// pokaz: suma zamowienia, podsumuj wprowadzone zmiany, zaplac, powrot

                        //$theme->print_page("/go/_basket/print.php");

                        //print "<table><tr><td class=\"payment_itext\">
                        print "<div class=\"alert alert-info text-left\"><br>";
                        print $lang->order_disclaimer['3'];
                        print "<a href=/go/_files/?file=terms.html>";
                        print "&nbsp ";
                        print $lang->order_disclaimer['5'];
                        print "</a>";
			print "</div>";

			$delivery_obj->show_country();
			$delivery_obj->show();

			$this->order_amount=$this->amount+$delivery_obj->delivery_cost;

                        print "<span id=\"order_step_one\">";
                        $theme->show_order_step_one($theme->price($this->amount),
			                         $theme->price($this->order_amount),
			                         $delivery_obj->delivery_name,
			                         $delivery_obj->delivery_cost);
                        print "</span>";

			print "</form>\n";


			// pokaz dostepne promocje
			global $config;
			if ((in_array("promotion",$config->plugins)) && ($this->_display_above)) {
				$theme->showPromotions();
			}
		} else if (($this->display=="form") && ($this->mode=='points')) {
			print "<div>";
			$delivery_obj->show_country();
			$delivery_obj->show();
			print "</div>";
			$theme->basket_points_submit($theme->price($this->amount),
                                                     $theme->price(@$this->order_amount),
                                                     $delivery_obj->delivery_name,
                                                     $delivery_obj->delivery_cost);
			print "</form>\n";
		} else {
			print "<p>";
		}

		return $this->amount;
	} // end showBasketForm()

	/**
    * Przedstaw pozycje/wiersz z koszyka w formacie html
    *
    * @param int   $id   id systemowe koszyka, pozycja w koszyku
    * @param array $item dane dot. produktu
    *
    * @access private
    * @return none
    */
	function _row($id,$item) {
		global $theme, $config, $lang, $mdbd;
		if ($this->_display_above) {
			$formname="basketForm";
		} else {
			$formname="wishlistForm";
		}
		// przet³umacz nazwê
		$name=$item['data']['lang_names'][$config->lang_id];
		$user_id=$this->_get_user_id($item['ID']);
		$item_id = $item['ID'];

		$enc = new EncodeUrl;
		$rewrite_name = $enc->encode_url_category($name);
		$new_url = '/'.$config->lang."/id".$item_id."/$rewrite_name";

		$namelink="<a href=\"$new_url\">$name</a>";

		//$namelink="<a href=\"/?id=$user_id\">$name</a>";
		$points_value=$item['points_value'];
		if ($this->mode!="points" && $config->basket_wishlist['prod_ext_info']==1) {
			$namelink.="<br>".$lang->basket_products_extra['user_id'].": $user_id, ".$lang->basket_products_extra['points_value'].": $points_value";
		}
		print "<tr bgcolor=" . @$config->theme_config['colors']['basket_td'] . ">\n";
		print "<td>".$namelink;
		if (! empty($item['data']['options'])) {
			$options=$item['data']['options'];
			$this->_showOptions($options,"html");
		}

		print "</td>\n";

		// start waluty:
		global $shop;
		$shop->currency();
		$item2=$item;
		if ($shop->currency->changed()) {
			$item2['price']=$shop->currency->price($item2['price']);
			$item2['price_netto']=$shop->currency->price($item2['price_netto']);
			$item2['sum_brutto']=$shop->currency->price($item2['sum_brutto']);
		}
		// end waluty:
		if ($this->mode!='points') {
			print "<td align=\"center\">".$item2['price_netto']."</td>\n";
			print "<td align=\"center\">".$item['data']['vat']."</td>\n";
			print "<td align=\"center\">".$item2['price']."</td>\n";
		}
		if ($this->display=="form") {
			if ($_SESSION['depository_status'] == false and isset($_SESSION['depository_status']))
			{
				$num_max = $mdbd->select("num","depository","user_id_main=?",array($user_id=>"text"),"","auto");
				$num_id = explode(" ",$_SESSION['depository_error_id']);
				for ($i=0;$i<=count($num_id)-1;$i++)
				{
					if ($user_id == $num_id[$i]) $item['num'] = $num_max;
				}
			}
			print "<td align=\"center\"><input type=\"text\" size=\"4\" maxsize=\"6\" name=\"num[$id]\" value=\"".$item['num']."\">";
			if ($_SESSION['depository_status'] == false and isset($_SESSION['depository_status'])) {
				for ($i=0;$i<=count($num_id)-1;$i++)
				{
					if ($user_id == $num_id[$i] and $num_max != 0){ print "<br /><font color=\"red\"><b>($num_max $lang->basket_max)</b></font>"; break; } 
					elseif ($user_id != $num_id[$i] and $num_max != 0) { print "<br />($num_max $lang->basket_max)"; break; }
				} 
			}
			
			print "</td>\n";
			
		} else {
			print "<td align=\"center\">".$item['num']."</td>\n";
		}
		if ($this->mode!='points') {
			print "<td align=\"center\">".$item2['sum_brutto']."</td>\n";
		}
		// je¿eli tryb punktów to poka¿ te dane
		if ($this->mode=='points') {
			print "<td align=\"center\">".$item['points_value']."</td>";
		}
		$target_mode=@$this->_move_target->mode;
		$compatible_target=false;
		if ($this->mode==$target_mode) {
			$compatible_target=true;
		} else if ($this->mode=="unset" || $target_mode=="unset") {
			$compatible_target=true;
		}
		// checkboxy usuñ i do przechowalni
		if ($this->display=="form") {
			// w trybie punktowym nie mo¿na przenosiæ
			if ($this->mode!='points') {
				// nie wy¶wietlaj opcji przeniesienia produktu je¿eli jest on zaznaczony jako niedostêpny
				if ((@$this->items[$id]['unavail']!=1) && $compatible_target) {
					print "<td><input class=\"border0\" type=\"checkbox\" id=\"move\" name=\"move[$id]\" ></td>\n";
				} else print "<td></td>";
				//onClick=\"this.form.submit();
			}
			print "<td><input class=\"border0\" type=\"checkbox\" id=\"del\" name=\"del[$id]\" ></td>\n";

		}
		print "</tr>\n";
		return;
	} // end _row()


	/**
    * Wyswietl nazwy pol formularza w koszyku. Jesli jest to prezentacja z formularzem
    * to dodaj pole "usun"
    * funkcja przeniesiona z theme.inc.php dla zachowania spójno¶ci koszyka i umo¿liwenia dynamicznego pokazywania kolumn.
    *
    * @param string $display "form" - wyswietl naglowek "usun" do tabeli z lista produktow w koszyku
    */
	function basket_th($display="",$is_basket=true) {
		global $lang, $config;
		global $shop;
		// poprawiamy szeroko¶æ nazwy przy trybie punktowym
		if ($this->mode!='points') {
			$proc="40%";
		} else $proc="70%";
		// jesli koszyk jest do wydruku to nie wyswietlaj kolorów i usuñ
		if ($config->theme!='print'){
			print "<tr bgcolor='"; echo $config->theme_config['colors']['basket_th']; echo "'>
                 <th width=$proc>$lang->basket_th_product_name</th>";
            if ($this->mode!='points') {
				print "     
		         <th>$lang->basket_th_netto</th>
                 <th>$lang->basket_th_vat</th>
		         <th>$lang->basket_th_brutto</th>";
            }
		    print "<th>$lang->basket_th_count</th>";
		    if ($this->mode!='points') {
				print "<th>$lang->basket_th_sum</th>";
		    } else {
				print "<th>$lang->basket_th_points</th>";
			}
			if ($display=="form") {
				// w trybie punktowym nie mo¿na przenosiæ
				if ($this->mode!='points') {
					if ($is_basket) {
						print "<th>$lang->basket_th_move</th>\n";
					} else {
						print "<th>$lang->wishlist_th_move</th>\n";
					}
				}
				print "<th>$lang->basket_th_delete</th>";
			}

		}else{
			// to jest przypadek w którym wy¶wietlamy liste do wydruku
			print "<tr>
                 <th width=$proc>$lang->basket_th_product_name</th>";
				if ($this->mode!='points') {
	                 print "
			         <th>$lang->basket_th_netto ".$shop->currency->currency."</th>
	                 <th>$lang->basket_th_vat</th>
	                 <th>$lang->basket_th_brutto ".$shop->currency->currency."</th>
	                 <th>$lang->basket_th_count</th>
			         <th>$lang->basket_th_sum ".$shop->currency->currency."</th>";
				}
			if ($this->mode=='points') {
				print "<th>$lang->basket_th_sum ".$shop->currency->currency."</th>";
				print "<th>$lang->basket_th_points</th>";
			}
			print "</tr>";
		}
		return(0);

	} // end basket_th()

	/**
    * Oproznij koszyk
    *
    * @access public
    * @return none
    */
	function emptyBasket() {
		$this->amount=0;
		$this->_item=array();
		$this->items=array();		
		$this->_count=0;             // #3012 poprawka dodawania pustego wiersza do zamowienia m@sote.pl		
		$this->basket_data_txt="";
		$this->_save_to_db();
		if ($this->_display_above) {
			$this->mode='unset';
		}
		$this->register();
		return(0);
	} // end empty_basket()
	
	
	/**
	 * Przedstaw zawartosc koszyka w TXT, ale w tym wypadku z produktami punktowymi.
	 * Informacje te sa dodawane do maila z zamowieniem.
	 *
	 */
	function basket_txt_points() {
		global $lang;
		// obliczamy warto¶æ zamówienia w punktach, ale nie zapisujemy danych do sesji
		// bo w sesji liczniki s± ju¿ pokasowane i ich aktualizacja spowoduje dublowanie siê kosztów punktowych
		$this->update_points(false);
		
		$this->basket_data_txt.=$lang->basket_txt_title.":\n";
        reset($this->items);$this->_pos=1;
        foreach ($this->items as $id=>$item) {
            $this->basket_data_txt.=$this->_rowTXT_points($item);
            $this->_pos++;
        }
        $o=$this->basket_data_txt;
        $o.=$lang->basket_amount_name."\n";
        $o.=$lang->basket_points_cost.": ".$this->_points_value."\n";
        $o.=$lang->basket_points_left.": ".$_SESSION['form']['points']."\n";
        return $o;
	}

	
    /**
    * Przedstaw zawartosc koszyka w postaci TXT. Informacja ta zostanie dodana do
    * maila z zamowieniem
    *
    * proste przeci±¿enie metody ¿eby mo¿na by³o w inny sposób wy¶wietlaæ produkty punktowe
    * @access public
    * @return string zwraca zawartosc calego goszyka w formacie TXT
    */
    function basket_txt() {
        global $lang;
        global $_SESSION;
        global $config;
        if ($this->mode=="points") {
        	return ($this->basket_txt_points());
        }
        $this->calc();
        
        $global_delivery=$_SESSION['global_delivery'];
        $global_order_amount=$_SESSION['global_order_amount'];
        
        $this->basket_data_txt.=$lang->basket_txt_title.":\n";
        reset($this->items);$this->_pos=1;
        foreach ($this->items as $id=>$item) {
            $this->basket_data_txt.=$this->_rowTXT($item);
            $this->_pos++;
        }
        
        
        // start waluty:
        global $shop;
        $shop->currency();
        
        $curr_delivery_cost=$shop->currency->price($global_delivery['cost']);
        $curr_amount=$shop->currency->price($this->amount);
        $curr_order_amount=$shop->currency->price($global_order_amount);
        
        // end waluty:
        
        $o=$this->basket_data_txt;
        $o.="\n".$lang->basket_delivery_name.": ".$global_delivery['name'].", ";
        $o.=$lang->basket_delivery_cost.": ".$curr_delivery_cost." ".$shop->currency->currency."\n";
        $o.=$lang->basket_amount_name.": ".$curr_amount." ".$shop->currency->currency."\n";
        $o.=$lang->basket_order_amount_name.": ".$curr_order_amount." ".$shop->currency->currency."\n";
        
        global $shop;
        $shop->promotions();
        $o.=$shop->promotions->txtInfo();
        
        return $o;
    } // end basket_txt()


    /**
    * Przedstaw zawartosc koszyka w postaci TXT. Informacja ta zostanie dodana do
    * maila z zamowieniem
    *
    * proste przeci±¿enie metody ¿eby mo¿na by³o w inny sposób wy¶wietlaæ produkty punktowe
    * @access public
    * @return string zwraca zawartosc calego goszyka w formacie TXT
    */
    function basket_google() {
        global $lang;
        global $_SESSION;
        global $config;
        global $db;

        //UTM:T|[order-id]|[affiliation]|[total]|[tax]| [shipping]|[city]|[state]|[country]

        //przyklad wiersza pierwszego
        //UTM:T|34535|mikran.pl|111108.06|8467.06|10.00|Ursynow|Warszawa|Polska 


        //UTM:I|[order-id]|[sku/code]|[productname]|[category]|[price]|[quantity]
        //UTM:I|34535|XF-1024|Urchin podkoszulki|Koszulki|11399.00|9
        //UTM:I|34535|CU-3424|Urchin Uchwyt na napoje|Akcesoria|20.00|2

        $g="";

        // odczytaj order_id
        if (! empty($_SESSION['global_order_id']))
        {
           $order_id=$_SESSION['global_order_id'];
           
           $utm_t = "UTM:T|".$order_id."||";

           $this->calc();
           
           $global_delivery=$_SESSION['global_delivery'];
           $global_order_amount=$_SESSION['global_order_amount'];

           // start waluty:
           global $shop;
           $shop->currency();
           
           $curr_delivery_cost=$shop->currency->price($global_delivery['cost']);
           $curr_amount=$shop->currency->price($this->amount);
           $curr_order_amount=$shop->currency->price($global_order_amount);

           $form = $_SESSION['form'];
           if (!empty($form['country']))
              $country = $form['country'];
           else
              $country = "Polska";

           //Obliczanie podatkow
           reset($this->items);
           foreach ($this->items as $id=>$item) 
           {
              $sum_netto += ($item['price_netto'] * $item['num']);
              $sum_brutto += ($item['price_brutto'] * $item['num']);
           }       

           $tax = $shop->currency->price($sum_brutto-$sum_netto);

           $utm_t .= $curr_order_amount."|".$tax."|".$curr_delivery_cost."|".$form['city']."|".$form['city']."|".$country."\n"; 

           //UTM:I|[order-id]|[sku/code]|[productname]|[category]|[price]|[quantity]
           //UTM:I|34535|XF-1024|Urchin podkoszulki|Koszulki|11399.00|9
           //Obliczanie wierszy utmi
           $utm_i="";
           reset($this->items);
           foreach ($this->items as $id=>$item) 
           {
              $price_netto = $shop->currency->price($item['price_netto']);
              $category="";

              $sql="SELECT category1,category2,category3,category4,category5  FROM main WHERE id=?";
              $prepared_query=$db->PrepareQuery($sql);
              if ($prepared_query) {
                 $db->QuerySetInteger($prepared_query,1,$item['ID']);
                 $result=$db->ExecuteQuery($prepared_query);
                 if ($result!=0) {
                    $num_rows=$db->NumberOfRows($result);
                    if ($num_rows==1) {
                       if (strlen($db->Fetchresult($result,0,"category1")) > 0)
                          $category .=$db->Fetchresult($result,0,"category1");
                       if (strlen($db->Fetchresult($result,0,"category2")) > 0)
                          $category .= ">>".$db->Fetchresult($result,0,"category2");
                       if (strlen($db->Fetchresult($result,0,"category3")) > 0)
                          $category .= ">>".$db->Fetchresult($result,0,"category3");
                       if (strlen($db->Fetchresult($result,0,"category4")) > 0)
                          $category .= ">>".$db->Fetchresult($result,0,"category4");
                       if (strlen($db->Fetchresult($result,0,"category5")) > 0)

                          $category .= ">>".$db->Fetchresult($result,0,"category5");
                    }
                 }
              }
              $options="";
              if (! empty($item['data']['options'])) {
                 $options=$this->show_options($item['data']['options'],"txt");
              }         

              $utm_i .= "UTM:I|".$order_id."|".$item['ID']."|".$item['name'].$options."|".$category."|".$price_netto."|".$item['num']."\n";
           }   

           $g = $utm_t . $utm_i;
        }
        
        return $g;
    } // end basket_txt()
    
        
    /**
    * Dane rekordu z koszyka w postaci TXT dla produtków punktowych
    *
    * @param array $item dane produktu
    *
    * @access private
    * @return string dane produktu w TXT
    */
    function _rowTXT_points($item) {
        global $lang;
        
        // przet³umacz nazwê produktu
        $name=LangF::name($item['name']);
        
        $o="";
        $nr=$this->_pos;
        $o.="$nr ".$lang->basket_elements['name'].": ".$name;
        
        $o.="\n";
        $o.="\t".$lang->basket_elements['user_id'].": ".$item['data']['user_id']."\n";
        $o.="\t".$lang->basket_elements['points_value'].": ".$item['points_value']."\n";
        $o.="\t".$lang->basket_elements['num'].": ".$item['num']."\n";
//        $o.="\t".$lang->basket_elements['sum_brutto'].": ".$item['sum_brutto']." ".$shop->currency->currency."\n\n";
        
        return $o;
    } // end _row_txt()

    
	/**
	 * Obs³uga b³êdów koszyka
	 * za³o¿enie jest takie ¿e wywo³ujemy t± metodê je¿eli sta³o siê co¶ nie tak
	 * kody b³êdów s± przechowywane w langach modu³u, ka¿demu kodowi odpowiada komunikat
	 * kody b³êdów powinny zaczynaæ siê od ??2, ¿eby zachowaæ zgodno¶æ z typem bool.
	 * na zasadzie ¿e je¿eli funkcja zaraca true lub false - jest ok, ale je¿eli zwraca integera wyst±pi³ b³±d o tym numerze.
	 *
	 * @param int $error_id - id b³êdu którego opis znajduje siê w langach
	 */
	function error($error_id) {
//		print "<pre>";
//		print_r (debug_backtrace());
//		print "</pre>";
		global $lang;
		$this->error_message=@$lang->basket_error[$error_id];
		$this->_error=true;
		$this->_error_code=$error_id;
	}

      function showAjaxBasketLimited()
         {
		global $theme;
		global $lang;
		global $delivery_obj;
		global $global_basket_calc_button;
		global $config;
		global $shop;
                global $prefix;
                global $global_wishlist_count;
                global $global_basket_count;

                if ($_POST['basket_action'] == "add")
                {
                   if (is_numeric($_POST['id']))
                   {
                      $id=$_POST['id'];
                      if (is_numeric($_POST['amount']))
                      {
                         $amount=$_POST['amount'];
                         $this->add_prod($id,$amount,'','','',true);
                         $this->register();
                      }
                   }
                }

                $this->calc();

		// je¶li koszyk jest pusty to poka¿ odpowiedni komunikat
		if ($this->_display_above) 
                {
                   $formname="basketForm";
		} 
                else 
                {
                   $formname="wishlistForm";
                   if ($this->display!="form") 
                   {
                      //!?
                      return;
                   }
		}
                $img_wishlist = "<img src=\"".$theme->filepath($prefix . $config->theme_config['icons']['wishlist'])."\" border=\"0\" title=\"".$lang->tooltip['wishlist_head']."\">";
                $img_basket = "<img src=\"".$theme->filepath($prefix . $config->theme_config['icons']['basket'])."\" border=\"0\" title=\"".$lang->tooltip['basket_head']."\">";

                $img_expand_collapse = "<img src=\"/themes/base/base_theme/_img/expand.ico\" border=\"0\" title=\"".$lang->tooltip['basket_head']."\">";

		if (!empty($this->items)) 
                {
                   // Nie wiadomo o co chodzi z tymi b³êdami - na razie usuwam to
                   //if ($this->_show_error()) {
                   //   return;
                   // }

                   if ($this->display=="form") 
                   {
                      if ($this->_display_above) 
                      {
                         // obs³uga ssl'a - tylko w koszyku
                         if ($config->ssl) 
                         {
                            global $sess;
                            //print "<form action=\"https://".$_SERVER['HTTP_HOST']."/go/_basket/index.php\" method=\"post\" name=\"$formname\">\n";
                            print "<form action=\"https://".$_SERVER['HTTP_HOST']."/go/_basket/basket_redirect.php\" method=\"post\" name=\"$formname\">\n";
                            // koniecznie przekazaæ sid przy takim przej¶ciu !
                            print "<input type=\"hidden\" name=\"sid\" value=".$sess->id.">\n";
                         } else 
                         {
                            //print "<form action=\"index.php\" method=\"post\" name=\"$formname\">\n";
                            print "<form name=\"$formname\" action=\"/go/_basket/basket_redirect.php\" method=\"post\">\n";
                         }
                      } 
                      else 
                      {
                         print "<form name=\"$formname\" action=\"/go/_basket/basket_redirect.php\" method=\"post\">\n";
                         //print "<form action=\"index3.php\" method=\"post\" name=\"$formname\">\n";
                      }
                      print "<input name=\"formName\" id=\"formName\" value=\"$formname\" type=hidden>\n";
                   }

                   //print "<table class=\"table table-bordered\">";
		   //print "<tr><th>xxxxxxxx</th></tr>";
		
                   $show_basket = $_SESSION['show_basket'];
                   if (empty($show_basket))
                      $show_basket = "collapse";

                   if ($show_basket == "collapse")
		     $show_basket_msg = $lang->collapse_basket;//"Zwiñ koszyk";
                   else
		     $show_basket_msg = $lang->expand_basket;//"Rozwiñ koszyk";

		   print "<ul class=\"nav nav-pills basket-pills\">";
		   print "<li style=\"cursor:pointer;color:#FF6000;padding:7px\" onclick='this.style.cursor=\"wait\";xmlhttpGet(\"/go/_basket/ajax_basket.php?action=show_basket&value=$show_basket\",\"ajax_basket\")'><i class=\"icon-list\"></i> $show_basket_msg.$img_expand_collapse</li>";
		   //print "<li><button class='btn btn-primary btn-mini' type='button' onclick='this.style.cursor=\"wait\";xmlhttpGet(\"/go/_basket/ajax_basket.php?action=show_basket&value=$show_basket\",\"ajax_basket\")'><i class=\"icon-list icon-white\"></i> $show_basket_msg</button></li>";
                   if ($global_wishlist_count > 0)
		     {
		       print "<li><a href=\"/przechowalnia\">".$img_wishlist."</a></li>";
		       print "<li><a href=\"/przechowalnia\">".$lang->head_wishlist_number.$global_wishlist_count."</a></li>";
		     }

		   if ($show_basket == "expand")
                   {
                      $this->calc();
		      print "<li>";
		      print "<ul class='nav nav-stacked'>";
                      print "<li><a href=\"/koszyk-start\">".$lang->head_products_count_number.$global_basket_count."</a></li>";
                      print "<li><a href=\"/koszyk-start\">".$lang->head_in_basket.$theme->price($this->amount)." ".$shop->currency->currency."</a></li>";
		      print "</ul>";
		      print "<li>";
		   }		      

                   //print "<tr><td>";
                   //print "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\">";
                   //print "<tr><td style=\"text-align:left\"><span style=\"cursor:pointer;color:#FF6000\" onclick='this.style.cursor=\"wait\";xmlhttpGet(\"/go/_basket/ajax_basket.php?action=show_basket&value=$show_basket\",\"ajax_basket\")'>".$show_basket_msg.$img_expand_collapse."</span></td>";
                   //print "<td>";
                   //if ($global_wishlist_count > 0)
                   //{
		   //  print "<a href=\"/przechowalnia\">".$lang->head_wishlist_number."&nbsp;"."</a><nobr>".$global_wishlist_count."</nobr>&nbsp&nbsp";
		   //  print "<a href=\"/przechowalnia\">".$img_wishlist."</a>";
                   //}
                   //print "</td>";

                   //$st_coll = "style=\"font:bold 12px Tahoma;text-align:center;color:#FF0000\"";
                   //if ($show_basket == "expand")
		   // {
		   //  $this->calc();
		   //  print "<td><span id=\"header_4\"><table border=\"0\"><tr>";
		   //  print "<td class=\"summary_small_center\"><a href=\"/koszyk-start\">".$lang->head_products_count_number."</a>".$global_basket_count."</td>";
		   //  print "</tr><tr>";
		   //  print "<td class=\"red_summary_small\"><a href=\"/koszyk-start\">".$lang->head_in_basket."</a>".$theme->price($this->amount)." ".$shop->currency->currency."</td>";
		   // print "</table>";
		   //  print "</span>";
		   // }

		   //print "<li class='pull-right'><button class='btn btn-primary' type='button'><a href=\"/koszyk-start/\">".$img_basket."</button></a></li>";
                   print "<li class='pull-right'><a href=\"/koszyk-start\"><span class='btn btn-warning'>".$lang->head_products_show."</span></a></li>";
		   print "</ul>";

		     //print "<td width=\"30%\"><table><tr><td><a href=\"/koszyk-start/\">".$img_basket."</td></a>";
		     //print "<td><table border=\"0\"><tr><td>";
		     //print "<a href=\"/koszyk-start\"><blink>".$lang->head_products_new."</blink></a>";
		     //print "</td><tr><tr><td>";
		     //print "<a href=\"/koszyk-start\">".$lang->head_products_show."</a>";
		     //print "</td></tr></table></td></tr></table>";
		     //print "</td></table></tr>";

                   if ($show_basket == "collapse")
                   {
                      print  "<table class='table table-bordered table-mikran'>";
                      $this->basket_thLimited($this->display,$this->_display_above);
                      
                      /* uaktualnij warto¶c zakupów i dodatkowe dane prodyuktów */
                      //$this->calc();
                      
                      // wy¶wietl pozycje z koszyka w wierszach
                      reset($this->items);
                      foreach ($this->items as $id=>$item) {
			$this->_rowLimited($id,$item,"head");
                      }

		      print "<tr>";
		      print "<td colspan='4'><span>$lang->basket_summary</span></td>";
		      echo "<td>".$lang->num_of_products.": "."<span>".$global_basket_count."</span></td><td><span class='red-money'>".$theme->price($this->amount)."</span></td><td><span class='red-money'>".$shop->currency->currency."</span></td>";
		      print "</tr>";

                      print "</table>\n";
                   }

		   print "<hr class='tight'>";
		   print "<p class='text-left'>";
		   print $lang->last_added . ": ";//"Ostatnio dodane: ";
		   $item_id = $item['ID'];
		   $name = $this->items[$this->_count]['data']['lang_names'][$config->lang_id];

		   $enc = new EncodeUrl;
		   $rewrite_name = $enc->encode_url_category($name);

		   print "<a style='padding:3px;' href='/$config->lang/id$item_id/$rewrite_name'>".$name."</a>";
		   print "</p>";

                   //$st = "style=\"font:bold 11px Tahoma;text-align:left;\"";
                   //print "<tr><td style=\"text-align:left\"><div class=\"tools\"><span $st>Ostatnio dodane: </span>".$this->items[$this->_count]['name']."</div></tr></td>";
                   print "</form>\n";                  
                }
                else
                {
                   //print "<tr><td>";
                   $this->showEmptyBasket();
                   // print "</td></tr>";
                }
		print "</table>";

	} // end showBasketForm()

	function showBasketFormLimited() 
         {
            print "<span id=\"ajax_basket\">";
            $this->showAjaxBasketLimited();
            print "</span>";
            
            return $this->amount;
         }

      function showEmptyBasket()
         {
            global $theme;
            global $lang;
            global $config;
            global $prefix;
            global $global_wishlist_count;
            
            $img_wishlist = "<img src=\"".$theme->filepath($prefix . $config->theme_config['icons']['wishlist'])."\" border=\"0\" title=\"".$lang->tooltip['wishlist_head']."\">";
            $img_basket = "<img src=\"".$theme->filepath($prefix . $config->theme_config['icons']['basket'])."\" border=\"0\" title=\"".$lang->tooltip['basket_head']."\">";
            print "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\">";
            print "<tr><td>";
            if ($global_wishlist_count == 0)
               print "<nobr><a href=\"/przechowalnia\">".$lang->wishlist_empty."</nobr></a>";
            else
               print "<a href=\"/przechowalnia\">".$lang->head_wishlist_number."&nbsp;"."</a><nobr>".$global_wishlist_count."</nobr>&nbsp&nbsp";
           
            print "<a href=\"/przechowalnia\">".$img_wishlist."</a>";
            print "</td><td>";
            
            print "<nobr>".$lang->basket_empty."</nobr>";
            print $img_basket;
            print "</td></tr></table>";
         }

	/**
    * Przedstaw pozycje/wiersz z koszyka w formacie html
    *
    * @param int   $id   id systemowe koszyka, pozycja w koszyku
    * @param array $item dane dot. produktu
    *
    * @access private
    * @return none
    */
	function _rowLimited($id,$item, $type="normal") {
           global $theme, $config, $lang, $mdbd, $global_delivery;
		if ($this->_display_above) {
			$formname="basketForm";
		} else {
			$formname="wishlistForm";
		}

		// przet³umacz nazwê
		$name=$item['data']['lang_names'][$config->lang_id];
		//		print_r($item);
		$user_id=$this->_get_user_id($item['ID']);
		$item_id = $item['ID'];

		$enc = new EncodeUrl;
		$rewrite_name = $enc->encode_url_category($name);
		$new_url = '/'.$config->lang."/id".$item_id."/$rewrite_name";

		$namelink="<a href=\"$new_url\">$name</a>";

		$points_value=$item['points_value'];
		if ($this->mode!="points" && $config->basket_wishlist['prod_ext_info']==1) 
		  {
		    $namelink.="<br>".$lang->basket_products_extra['user_id'].": $user_id, ".$lang->basket_products_extra['points_value'].": $points_value";
		  }
		print "<tr bgcolor=" . @$config->theme_config['colors']['basket_td'] . ">\n";
		//print "<tr>";
		print "<td><span id=\"name_$id\">".$namelink;
		if (! empty($item['data']['options'])) {
			$options=$item['data']['options'];
			$this->_showOptions($options,"html");
		}


		print "</span></td>\n";

		// start waluty:
		global $shop;
		$shop->currency();
		$item2=$item;
		if ($shop->currency->changed()) {
			$item2['price']=$shop->currency->price($item2['price']);
			$item2['price_netto']=$shop->currency->price($item2['price_netto']);
			$item2['sum_brutto']=$shop->currency->price($item2['sum_brutto']);
		}
		// end waluty:
		if ($this->mode!='points') {
			print "<td>".$item2['price_netto']."</td>";
			print "<td>".$item['data']['vat']."</td>";
			print "<td>".$item2['price']."</td>";
		}

		if ($this->display=="form") 
                {
                   if ($this->_display_above == true)
                   {
                      $da = $_SESSION['disable_ajax'];
                      if ($da == "true")
                      {
                         print "<td><span id=\"calculate_$id\"><input onkeypress='return event.keyCode!=13' class=\"input\" type=\"text\" maxsize=\"6\" name=\"num_$id\" value=\"".$item['num']."\">";

			 //print "<button class='btn btn-info btn-small' type='button' onclick='basketUpdate(\"/go/_basket/ajax_basket.php?action=update&type=$type\",\"$id\", document.forms[\"$formname\"].num_$id, \"ajax_basket\");'><i class='icon-refresh'></i> $lang->basket_num_change</button>";
                         print "<input class=\"btn btn-info btn-small\" type=\"button\" onclick='basketDeliveryUpdate(\"/go/_basket/ajax_basket.php?action=update&type=$type&disable_ajax=$da\",\"$id\", document.forms[\"$formname\"].num_$id, \"ajax_basket\");' value='$lang->basket_num_change'>";

                         print "</span></td>\n";
                      }
                      else
                      {
                         print "<td  align=\"center\"><nobr><span id=\"calculate_$id\"><input onkeypress='return event.keyCode!=13' class=\"input\" type=\"text\" size=\"4\" maxsize=\"6\" name=\"num_$id\" value=\"".$item['num']."\">";
                         print "&nbsp";

                         print "<input class=\"btn btn-info btn-small\" type=\"button\" onclick='basketUpdate(\"/go/_basket/ajax_basket.php?action=update&type=$type\",\"$id\", document.forms[\"$formname\"].num_$id, \"ajax_basket\");' value='$lang->basket_num_change'>";			
			 //print "<button class='btn btn-info btn-small' type='button' onclick='basketUpdate(\"/go/_basket/ajax_basket.php?action=update&type=$type\",\"$id\", document.forms[\"$formname\"].num_$id, \"ajax_basket\");'><i class='icon-refresh'></i> $lang->basket_num_change</button>";
                         
                         print "</span></td>\n";
                      }
                   }
                   else
                   {
                      print "<td align=\"center\"><nobr><input onkeypress='return event.keyCode!=13' type=\"text\" size=\"4\" maxsize=\"6\" name=\"num[$id]\" value=\"".$item['num']."\">";
                      print "<input class=\"input\" type=\"submit\" value='$lang->basket_num_change'>";
                      print "<input type=\"hidden\" name=\"submit_update\" value=\"order_update\">";
                      print "</td>";
                   }
			
		} else {
			print "<td>".$item['num']."</td>";
		}
		if ($this->mode!='points') {
		  print "<td><span id=\"sum_brutto_$id\">".$item2['sum_brutto']."</span></td>\n";
		}
		// je¿eli tryb punktów to poka¿ te dane
		//if ($this->mode=='points') {
		//	print "<td align=\"center\">".$item['points_value']."</td>";
		//}
		$target_mode=@$this->_move_target->mode;
		$compatible_target=false;
		if ($this->mode==$target_mode) {
			$compatible_target=true;
		} else if ($this->mode=="unset" || $target_mode=="unset") {
			$compatible_target=true;
		}
		// checkboxy usuñ i do przechowalni
		if ($this->display=="form") 
                {
                   if ($this->mode!='points') 
                   {
                      if ($this->_display_above == false) 
                      {
                         // w trybie punktowym nie mo¿na przenosiæ
                         // nie wy¶wietlaj opcji przeniesienia produktu je¿eli jest on zaznaczony jako niedostêpny
                         if ((@$this->items[$id]['unavail']!=1) && $compatible_target) 
			   {
			     print "<td><button class=\"btn btn-small\" type=\"submit\" id=\"move\" name=\"move[$id]\">".$lang->move."</button></td>\n";
			   } 
			 else print "<td></td>";
                         print "<td><button class=\"btn btn-small\" type=\"submit\" id=\"del\" name=\"del[$id]\"><i class='icon-remove'></i></button></td>";
                      }
                   }
                   if ($this->_display_above == true) 
                   {
                      print "<td><span id=\"delete_$id\">";
                      print "<button class=\"btn btn-small\" type=\"button\" onclick='basketDelete(\"/go/_basket/ajax_basket.php?action=delete&type=$type\",\"$id\",\"ajax_basket\");'><i class='icon-remove'></i></button>";
                      print "</span></td>";
                   }
		}
		print "</tr>";
	} // end _row()

      /*
       * Wyswietl nazwy pol formularza w koszyku. Jesli jest to prezentacja z formularzem
       * to dodaj pole "usun"
       * funkcja przeniesiona z theme.inc.php dla zachowania spójno¶ci koszyka i umo¿liwenia dynamicznego pokazywania kolumn.
       *
       * @param string $display "form" - wyswietl naglowek "usun" do tabeli z lista produktow w koszyku
       */
	function basket_thLimited($display="",$is_basket=true) {
		global $lang, $config;
		global $shop;
		// poprawiamy szeroko¶æ nazwy przy trybie punktowym
		if ($this->mode!='points') {
                   $proc="40%";
		} else $proc="70%";
		// jesli koszyk jest do wydruku to nie wyswietlaj kolorów i usuñ
		if ($config->theme!='print'){
                   print "<tr bgcolor='"; echo $config->theme_config['colors']['basket_th']; echo "'>
                 <th width=$proc>$lang->basket_th_product_name</th>";
                   if ($this->mode!='points') {
                      print "     
		         <th>$lang->basket_th_netto</th>
                 <th>$lang->basket_th_vat</th>
		         <th>$lang->basket_th_brutto</th>";
                   }
                   print "<th>$lang->basket_th_count</th>";
                   if ($this->mode!='points') {
				print "<th>$lang->basket_th_sum</th>";
                   } else {
                      print "<th>$lang->basket_th_points</th>";
                   }
                   if ($display=="form") {
                      // w trybie punktowym nie mo¿na przenosiæ
                      if ($this->mode!='points') {
                         if ($is_basket == false) {
                            print "<th>$lang->wishlist_th_move</th>\n";
                         }
                      }
                      print "<th>$lang->basket_th_delete</th>";
                   }
                   
		}else{
                   // to jest przypadek w którym wy¶wietlamy liste do wydruku
                   print "<tr>
                 <th width=$proc>$lang->basket_th_product_name</th>";
				if ($this->mode!='points') {
                                   print "
			         <th>$lang->basket_th_netto ".$shop->currency->currency."</th>
	                 <th>$lang->basket_th_vat</th>
	                 <th>$lang->basket_th_brutto ".$shop->currency->currency."</th>
	                 <th>$lang->basket_th_count</th>
			         <th>$lang->basket_th_sum ".$shop->currency->currency."</th>";
				}
			if ($this->mode=='points') {
                           print "<th>$lang->basket_th_sum ".$shop->currency->currency."</th>";
                           print "<th>$lang->basket_th_points</th>";
			}
			print "</tr>";
		}
		return(0);
                
	} // end basket_th()
} // end class MyExtBasket
?>

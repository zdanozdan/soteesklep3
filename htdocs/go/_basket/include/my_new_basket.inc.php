<?php

require_once ("./include/my_basket.inc.php");

require_once ("./include/basket_options.inc.php");

/**
 * Wrapper do istniej±cych (starych) funkcji koszyka - emulacja postów, getów i requestów
 * Nadaje koszykowi w³a¶ciwo¶ci obiektowe.
 *
 * @author lukasz@sote.pl
 * @package basket
 * @since 3.1RC9-devel
 * @version $Id: my_new_basket.inc.php,v 2.13 2006/08/16 10:22:26 lukasz Exp $
 *
 */
class My_New_Basket extends MyBasket {

	/**
	 * Blokada wywo³añ - czy wowo³aæ rodzica, czy lokaln± metode
	 *
	 * @var bool
	 */
	var $local_lock = false;

	/**
	 * Tablica przechowywanych $_POST'ow
	 *
	 * @var array
	 */
	var $POST;

	/**
	 * Tablica przechowywanych $_GET'ow
	 *
	 * @var array
	 */
	var $GET;

	/**
	 * Tablica przechowywanych $_REQUEST'ow
	 *
	 * @var array
	 */
	var $REQUEST;


	/**
	 * Zapisuwanie napisywanie wszystkich elementow $_POST odpowiednimi elementami z $items, zapisujac stare wartosci w $this->POST
	 *
	 * @param array $items
	 */
	function _switch_POST (&$items) {
		foreach ($items as $name => $value) {
			$this->POST[$name] = @$_POST[$name];
			unset($_POST[$name]);
			if (!empty($value)) {
				$_POST[$name]=$value;
			}
		}
	}

	/**
	 * Odtwarzanie elemetow $_POST okreslonych w $items, na podstawie $this->POST
	 *
	 * @param array $items
	 */
	function _restore_POST (&$items) {
		foreach ($items as $name => $value) {
			unset ($_POST[$name]);
			$_POST[$name]=$this->POST[$name];
		}
	}

	/**
	 * Zapisuwanie napisywanie wszystkich elementow $_POST odpowiednimi elementami z $items, zapisujac stare wartosci w $this->POST
	 *
	 * @param array $items
	 */
	function _switch_REQUEST (&$items) {
		foreach ($items as $name => $value) {
			$this->REQUEST[$name] = @$_REQUEST[$name];
			unset($_REQUEST[$name]);
			if (!empty($value)) {
				$_REQUEST[$name]=$value;
			}
		}
	}

	/**
	 * Odtwarzanie elemetow $_POST okreslonych w $items, na podstawie $this->POST
	 *
	 * @param array $items
	 */
	function _restore_REQUEST (&$items) {
		foreach ($items as $name => $value) {
			unset ($_REQUEST[$name]);
			$_REQUEST[$name]=$this->REQUEST[$name];
		}
	}

	/**
	 * Zapisuwanie napisywanie wszystkich elementow $_GET odpowiednimi elementami z $items, zapisujac stare wartosci w $this->GET
	 *
	 * @param array $items
	 */	
	function _switch_GET (&$items) {
		foreach ($items as $name => $value) {
			$this->GET[$name] = @$_GET[$name];
			unset($_GET[$name]);
			if (!empty($value)) {
				$_GET[$name]=$value;
			}
		}
	}

	/**
	 * Odtwarzanie elemetow $_GET okreslonych w $items, na podstawie $this->GET
	 *
	 * @param array $items
	 */
	function _restore_GET (&$items) {
		foreach ($items as $name => $value) {
			unset ($_GET[$name]);
			$_GET[$name]=$this->GET[$name];
		}
	}

	/**
	 * Dodawanie produktu do koszyka
	 *
	 * @param int $id id produku - ¿ywcem z bazy danych
	 * @param array $options - tablica opcji (zaawansowanych atrybutów)
	 * @param int $num - ilo¶æ dodwanych produktów (s± bugi warstwe ni¿ej)
	 * @param array $basket_cat - lista produktów dodanych (przez xml_options)
	 * @param array $ext_basket - dodatkowe produkty dodane do koszyka (akcesoria)
	 * @param bool $ignore_lock - ignoruj blokadê dodawania produktów gry jest siê w koszyku (wymagane do wielokrotnego dodawania)
	 */
	function add($id,$options='',$num='',$basket_cat='',$ext_basket,$ignore_lock=false) {
		global $_SESSION;
		global $global_secure_test, $sess, $global_request_md5, $global_prev_request_md5, $db, $mdbd;

		// sprawdzamy blokade - czy wywo³aæ dodawanie u rodzica
		if ($this->local_lock) {
			$this->items[++$this->_count]=array("ID"=>$id,"name"=>$options,"num"=>$num,"price"=>$basket_cat,"data"=>$ext_basket,"points_value"=>$ignore_lock);
			//			$this->register();
		} else {
			// ignorujemy zabezpieczenie przed dodawaniem wielu produktów do koszyka (np przez od¶wierzanie)
			if ($ignore_lock) {
				$_basket_add_lock=@$_SESSION['basket_add_lock'];
				unset($_SESSION['basket_add_lock']);
				$_global_prev_request_md5=$global_prev_request_md5;
				$global_prev_request_md5='false';
			}
			// tablica podmienianych elemetów
			$items= array (
			'id'=>"$id",
			'num'=>"$num",
			'basket_cat'=>$basket_cat,
			'options'=>$options,
			'basket'=>$ext_basket,
			);
			// podmieniam i zapamiêtuje requesty
			$this->_switch_REQUEST($items);

			// blokada, wywo³ania, blokada
			$this->local_lock=true;
			$basket=$this;
//			print getcwd();
			$old_dir=getcwd();
			global $DOCUMENT_ROOT;
			$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
			chdir($path_to_basket);
			require_once("./include/container.inc.php");
			$container=& new Basket_Container();
			require("./include/basket_add.inc.php");
			$container->me=&$this;
			$container->me=$basket;
			chdir($old_dir);
//			$this=$basket;
			$this->local_lock=false;

			// odtwarzam requesty z przed wywo³ania
			$this->_restore_REQUEST($items);
			// odtwarzamy zabezpieczenie
			if ($ignore_lock) {
				$sess->register("basket_add_lock",$_basket_add_lock);
				$global_prev_request_md5=$_global_prev_request_md5;
			}
		}
	}

	/**
	 * Usuwamy produkt o wewnêtrznym id koszyka (Basket->items)
	 *
	 * @param int $id
	 */
	function del ($id) {
		// sprawdzamy blokade - czy wywo³aæ usuwanie u rodzica
		if ($this->local_lock) {
			unset($this->items[$id]);
		} else {
			global $global_secure_test, $sess;
			// generujemy tablice do posta
			// i zapisujemy num ¿eby nie wywo³ywaæ aktualizacji liczby produktów
			$int_prod_id=key($id);
			$items=array(
			'del' => array( "$int_prod_id" => "on" ),
			'num' => '',
			);

			// podmieniamy posty
			$this->_switch_POST($items);

			// blokada, wywo³anie, blokada
			$this->local_lock=true;
			$basket=$this;
			$old_dir=getcwd();
			global $DOCUMENT_ROOT;
			$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
			chdir($path_to_basket);
			require_once("./include/container.inc.php");
			$container=& new Basket_Container();
			include("./include/basket_update.inc.php");
			$container->me=&$this;
			$container->me=$basket;
			
			chdir($old_dir);
			
			$this->local_lock=false;

			// odtwarzamy posty i zmienne
			$this->_restore_POST($items);
		}
	}

	/**
	 * Aktualizujemy liczbe sztuk produktu o wewnêtrznym id koszyka (Basket->items)
	 *
	 * @param int $id
	 * @param int $num
	 */
	function update($id,$num) {
		global $global_secure_test, $sess;

		// nie sprawdzamy locka poniewa¿ nie istnieje taka metoda w ¿adnym z rodziców
		// ale i tak bêdziemy musieli go w³±czyæ na czas wykonywania w³a¶ciwej procedury.

		// generujemy tablice do posta
		// i zapisujemy del ¿eby nie usuwaæ produktów

		$items=array(
		'num' => array( "$id" => "$num" ),
		'del' => '',
		);

		// podmieniamy posty
		$this->_switch_POST($items);

		// blokada, wywo³anie, zdjecie blokady
		$this->local_lock=true;
		$basket=$this;	
		$old_dir=getcwd();
		global $DOCUMENT_ROOT;
		$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
		chdir($path_to_basket);
		require_once("./include/container.inc.php");
		$container=& new Basket_Container();
		include("include/basket_update.inc.php");
		chdir($old_dir);
		$container->me=&$this;
		$container->me=$basket;
			
//		$this=$basket;
		$this->local_lock=false;

		// odtworzenie postów
		$this->_restore_POST($items);
	}

	//num - to tablica elementów do zaktualizowania liczby
	//del - to tablica elementów do usuniêcia
	// zachowane dla pe³nej emulacji
	/**
	 * Po przej¶cie do kolejnego etapu zamawiania
	 * Zastosowanie wszystkich zmian wprowadzonych do formularza (usuniêcia, zmiany w ilo¶ci) oraz obliczenie kosztów dostawy
	 *
	 * @param array $num
	 * @param array $del
	 */
	function proceed($num='', $del='') {
		global $delivery_obj, $global_delivery, $theme, $sess, $mdbd, $db;
		
		$i=0;
		$_SESSION['depository_status'] = "";
		$_SESSION['depository_error_id'] = "";
		foreach($_SESSION['global_basket_data']['items'] as $key => $value ){

			$item_id = $mdbd->select("user_id","main","id=?",array($value['ID']=>"text"),"","auto");
			$select = $mdbd->select("num","depository","user_id_main=?",array($item_id=>"text"),"","auto");

			//echo "select: ".$select."; ".$item_id;
			if ($select == 0) $select="n";
			if ($select >= $num[$i][$key] or $select == "n") 
			{
				$_SESSION['depository_status'] = true;
			}
			else
			{
                           //TZ change - nie sprawdzamy stanow magazynowych, pozwalamy zamowic ile fabryka dala
				$_SESSION['depository_status'] = true;                               
// 				$_SESSION['depository_status'] = false;
// 				$_SESSION['depository_error_id'].= $item_id." ";
// 				if ($i == count($_SESSION['global_basket_data']['items'])-1) return false;
                           //TZ change
			} 
			$i++;
		}
			/* zapisz dane koszyka w sesji */
		// aktualizujemy wszystkie produkty którym chcemy zmieniæ ilo¶æ
		$this->update_many($num);
		// usuwamy wszystkie zaznaczone produkty
		if (is_array($del)) {
			$this->del_many($del);
		} else if (is_int($del)) {
			$this->del($id);
		}
		// oblicz koszty dostawy
		// #505 local
		$this->calc();
		$this->register();
		$this->calc_delivery();
		/**
	    * Zapisz dane koszyka w sesji 
	    * Dane s± zapisuwane przed head(), gdy¿ s± one wykorzystywane m.in. do pokazania ilo¶ci produktów w koszyku itp.
	    * w nag³ówku.
	    */
		//$this->register();
		// end #505 local
		$basket=$this;
		//$my_basket=&$basket;
		// wywolaj nowy skrypt
		//include_once("register.php");
		// zakoncz dzialanie tego skryptu
		//exit;
	}

	/**
	 * Oblicz koszta dostawy
	 *
	 */
	function calc_delivery() {
		global $delivery_obj, $global_delivery, $theme, $sess;
		$delivery_obj->calc();
		$global_delivery=array();
		$global_delivery['id']=$delivery_obj->delivery_id;
		$global_delivery['name']=$delivery_obj->delivery_name;
		$global_delivery['cost']=$theme->price($delivery_obj->delivery_cost);
		$global_delivery['pay']=$delivery_obj->delivery_pay;
		$sess->register("global_delivery",$global_delivery);
	}

	/**
	 * Aktualizacja wielu produktów naraz
	 *
	 * @param array $items
	 */
	function update_many($items) {
		foreach ($items as $key) {
			$id=key($key);
			$value=$key[$id];
			$this->update($id,$value);
		}
	}

	/**
	 * Usuwanie wielu produktów naraz
	 *
	 * @param array $items ($int_id1,$int_id2)
	 */
	function del_many($items) {
		foreach ($items as $id) {
			$this->del($id);
		}
	}

	/**
	 * Dodanie wielu produktów naraz
	 * Tablica wej¶æiowa: 
	 *	 array ('1' => array (
	 *			 	"id" => id produktu (z bazy danych),
	 *			 	"options" => xml_options,
	 *			 	"num" => liczba produktow,
	 *			 	"bakset_cat" => nieznana (przekazywana w ciemno),
	 *			 	),
	 *			 )
	 *	Dane przekazywane bez zmian do $this->add	 	
	 *
	 * @param array $items
	 * @param bool $ignore_lock
	 */
	function add_many($items,$ignore_lock) {
		foreach ($items as $key) {
			$id=$items[$key]['id'];
			$options=$items[$key]['options'];
			$num=$items[$key]['num'];
			$basket_cat=$items[$key]['basket_cat'];
			$this->add($id,$options,$num,$basket_cat,$ignore_lock);
		}
	}
}
?>

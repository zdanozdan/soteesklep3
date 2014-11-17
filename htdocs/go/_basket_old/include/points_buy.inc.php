<?php
/**
 * Klasa obs³uguj±ca zakupy za punkty
 * - sprawdzenie dostêpno¶ci produktu dla danego u¿ytkownika
 *
 * @author lukasz@sote.pl
 * @since 3.5alfa19 07.11.2005
 * @version $Id: points_buy.inc.php,v 2.2 2005/12/07 12:31:11 lukasz Exp $
 *
 */
class Points_Buy {
	
	/**
	 * Sprawdzenie czy produkt jest punktowy (zaznaczone pole prezent)
	 *
	 * @param unknown_type $id
	 * @return bool
	 */
	function is_points ($id) {
		global $mdbd;
		$is_points=$mdbd->select('points','main','id=?',array($id=>"int"));
		if ($is_points=='1') return true;
		return false;
	}
	
	/**
	 * Metoda sprawdza czy produkt moze zostac dodany do obecnego koszyka.
	 *
	 * @param int $id - id produtku
	 * @param string $mode - tryb obiektu ktory wywoluje ta metode
	 * @return int $error - blad ktory wystapil podczas weryfikacji (1-ok, pozosta³e wg langów basket_errors)
	 */
	function check_avail ($id,&$mode) {
		// sprawdzamy ju¿ czy u¿ytkownik mo¿e kupiæ ten produkt - bêdziemy to potem wykorzystywaæ przy komunikatach b³êdów
		// standard - warto¶æ 1 oznacza sukces ¿eby mo¿na by³o porównywaæ wynik jako boola
		$is_good_for_points=$this->is_good_for_points($id);
		// z jakim obiektem mamy do czynienia ?
		// obiekt który zawiera produkty punktowe
		if ($mode=='points') {
			if ($this->is_points($id)) {
				if ($is_good_for_points=="1") {
					return 1;
					// za malo punktow na koncie
				} else return $is_good_for_points;
			// produkt punktowy dodawany do normalnego koszyka
			} else return 4;
			
		// obiekt który zawiera standardowe produkty
		} else if ($mode=='standard') {
			if (!$this->is_points($id)) {
				return 1;
			} else {
				// do koszyka zawierajacego normalne produkty dodano produkt punktowy
				return 2;
			}
		// obiekt który nie zawiera produktów, i trzeba ustawiæ tryb
		} else {
			// jezeli produkt jest punktowy i dostêpny - ustawiamy tryb i pozwalamy na dodanie
			if ($this->is_points($id)) {
				if ($is_good_for_points=="1") {
					$mode="points";
					return 1;
				// produkt jest za punkty, ale jest niedostêpny. zwracamy zonka.
				} else {
				// za malo punktow na koncie
					return $is_good_for_points;
				}
				// je¿eli produkt jest normaly - ustawiamy tryb i dodajemy
			} else {
				$mode="standard";
				return 1;
			}
		}
	}
	
	/**
	 * Sprawdzanie dostêpno¶ci produktu dla danego u¿ytkownika
	 * @access $_SESSION['global_id_user']
	 *
	 * @param int $id - id produktu który jest sprawdzany
	 * @return bool - czy produkt jest dostêpny dla danego u¿ytkownika
	 */
	function is_good_for_points ($id) {
		global $mdbd;
		// sprawdzamy czy u¿ytkownik jest zalogowany - je¿eli nie to nie puszczamy
		if (!empty($_SESSION['global_id_user'])) {
			$__global_id_user=$_SESSION['global_id_user'];
		}
		// u¿ytkownik jest niezalogowany
		else return "12";
		// wyci±gamy do $data dane dot produktu - czy jest on za punkty i za ile punktów
		$points_value=$mdbd->select('points_value','main','id=?',array($id=>"int"));
		// wyci±gamy ile punktów ma na koncie u¿ytkownik
//		$user_points=$mdbd->select('points','users_points','id_user=?',array($__global_id_user=>"int"));
		$user_points=@$_SESSION['form']['points'];
		// czy u¿ytkownik ma do¶æ punktów na koncie ?
		// NIE:
		if ($user_points<$points_value) return "13";
		return "1";
	}
}
?>
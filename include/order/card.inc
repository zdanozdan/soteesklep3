<?php
/**
 * Klasa obs³uguj±ca zapis danych kart w bazie danych
 *
 * @author lukasz@sote.pl
 * @package include
 */
class Card_Pay {
	function Card_Pay() {
		require_once("include/rsa_crypt.inc");
		$this->encryptor=&new KeyHandler();
	}

	/**
	 * Pobierz id ostatniego wprowadzonego rzêdu
	 *
	 * @return int
	 */
	function get_last_row() {
		global $db;
		$query="SELECT max(id) FROM card_pay";
		$result_id=$db->Query($query);
		if ($result_id!=0) {
			// szukamy ostatniego dodanego wiersza
			$num_rows=$db->NumberOfRows($result_id);
			if ($num_rows==1) {
				$id=$db->FetchResult($result_id,0,'max(id)');
				return $id;
			} else return 0; // b³±d odczytu nowego pola (z³a liczba pól zwrócona)
		} else return 0; // b³±d odczytu nowego pola (nie dodano pola ?)
	}

	/**
	 * Zapisz dane karty do bazy danych
	 * przedtem dane s± kodowane tak ¿eby nie spowodowaæ injecta sql'a
	 * oraz szyfrowane kluczem publicznym - przez stworzony w konstruktorze obiekt
	 *
	 * @return unknown
	 */
	function save_to_db() {
		global $db;
		$form=$_POST['card'];
		$query="INSERT INTO card_pay (card, valid_to, cvv) VALUES (?,?,?)";
		$prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
			// pobieramy dane i upewniamy siê ze nie bedzie sql inject'a
			$card=addslashes($form['card_id']);
			$card=preg_replace("/-/","",$card);
			$valid_to=addslashes($form['exp_month'].'-'.$form['exp_year']);
			$cvv=addslashes($form['cvv']);
			// szyfrujemy
			$card=$this->encryptor->encrypt($card);
			$valid_to=$this->encryptor->encrypt($valid_to);
			$cvv=$this->encryptor->encrypt($cvv);
			// zapisujemy
			$db->QuerySetText($prepared_query,1,$card);
			$db->QuerySetText($prepared_query,2,$valid_to);
			$db->QuerySetText($prepared_query,3,$cvv);
			$result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
				return $this->get_last_row();
			} else die ("I".$db->Error());
		} else die ("J".$db->Error());
	}
}
?>
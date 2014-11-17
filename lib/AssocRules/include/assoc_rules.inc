<?php
/**
* Modu³ polecania produktów oparty na pozyskaniu wiedzy z historii transakcji
*
* Dla danego produktu x generowana jest lista produktów, które prawdopodobnie zostan± kupione,
* je¶li kupiony bêdzie produkt x
* 
* @author  lech@sote.pl
* @version $Id: assoc_rules.inc,v 1.5 2005/11/03 10:16:38 lechu Exp $
* @package assoc_rules
*/

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Klasa implementuj±ca mechanizmy pozyskania regu³ asocjacyjnych.
* @package assoc_rules
*/
class AssocRules {
	
	/**
	* Tablica regu³ asocjacyjnych
	*
	* Kluczem w danym elemencie tablicy jest user_id g³ównego produktu, a warto¶ci± jest
	* tablica. Kluczami tej tablicy s± identyfikatory produktów skojarzonych regu³ami asoc.,
	* a warto¶ciami s± dwuelementowe tablice ('sup' => wsparcie, 'conf' => ufno¶æ).
	*/
	var $Rules;
	
	/**
	* Parametr minimalnego wsparcia
	*/
	var $MinSupport;
	
	/**
	* Parametr minimalnej ufno¶ci
	*/
	var $MinConfidence;
	
	/**
	* Transakcje - tablica
	*
	* Kluczem ka¿dego elementu jest zwyk³a liczba porz±dkowa. Warto¶ci± - tablica identyfikatorów
	* produktów w transakcji.
	*/
	var $Transactions;
	
	/**
	* Ustalenie wsparcia
	*
	* @access private
	*/
	function _calculateMinSupport() {
		$this->MinSupport = 0.001;
	}

	/**
	* Ustalenie ufno¶ci
	*
	* @access private
	*/
	function _calculateMinConfidence() {
		$this->MinConfidence = 0.4;
	}

	/**
	* Kostruktor
	*
	*
	* @param string $transaction_file_path ¦cie¿ka do pliku z informacjami o transakcjach.
	* Ka¿dy wiersz w pliku odpowiada jednej transakcji. Identyfikatory produktów w wierszu
	* oddzielone s± ¶rednikami ";"
	*/
	function AssocRules($transaction_file_path) {
		// odczytaj plik
		if (is_file($transaction_file_path)) {
			if(filesize($transaction_file_path) > 0) {
				$fp = fopen($transaction_file_path, 'r');
				$file_contents = fread($fp, filesize($transaction_file_path));
				fclose($fp);
			}
		}
		else {
//			die("Transaction file <i>$transaction_file_path</i> not found.");
			echo("ERROR");
		}
		
		// pobierz transakcje
		if(isset($file_contents)) {
			$lines = explode("\n", $file_contents);
			for($i = 0; $i < count($lines); $i++) {
				$line = trim($lines[$i]);
				if(!empty($line)) {
					$transaction = explode(";", $line);
					$this->Transactions[] = $transaction;
				}
			}
		}
	}
	
	/**
	* Wygenerowanie regu³ asocjacyjnych
	*
	* G³ówny algorytm klasy. Tu zostaje wype³niona tablica $this->Rules.
	*/
	function generateRules() {
		$this->_calculateMinConfidence();
		$this->_calculateMinSupport();
		$pairs = array();
		$singles = array();
		for ($i = 0; $i < count($this->Transactions); $i++) {
			$singles_add = array();
			for ($j = 0; $j < count($this->Transactions[$i]); $j++) {
				$k1 = $this->Transactions[$i][$j];
				$singles_add[$k1] = 1;
				for ($m = $j + 1; $m < count($this->Transactions[$i]); $m++) {
					$k2 = $this->Transactions[$i][$m];
					if($k1 != $k2) {
						$key = "$k1;$k2";
						if($k2 < $k1) {
							$key= "$k2;$k1";
						}
						if(empty($pairs[$key])) {
							$pairs[$key] = 1;
						}
						else {
							$pairs[$key] ++;
						}
					}
				}
			}
			reset($singles_add);
			while (list($key, $val) = each($singles_add)) {
				if (empty($singles[$key])) {
					$singles[$key] = 1;
				}
				else {
					$singles[$key] ++;
				}
			}
		}


		reset($pairs);
		while (list($key, $val) = each($pairs)) {
			$products = explode(";", $key);
			$p1 = $products[0];
			$p2 = $products[1];
			/*
			if(($val > $singles[$p1]) || ($val > $singles[$p2]))
				echo $singles[$p1] . " - " . $singles[$p2] . " - " . $val . "<br>";
		    */
			$support = $val / count($this->Transactions);
			$confidence_1_2 = $val / $singles[$p1];
			$confidence_2_1 = $val / $singles[$p2];
			if($support >= $this->MinSupport) {
				if($confidence_1_2 >= $this->MinConfidence) {
					$this->Rules[$p1][$p2]['sup'] = $support;
					$this->Rules[$p1][$p2]['conf'] = $confidence_1_2;
				}
				if($confidence_2_1 >= $this->MinConfidence) {
					$this->Rules[$p2][$p1]['sup'] = $support;
					$this->Rules[$p2][$p1]['conf'] = $confidence_2_1;
				}
			}
		}
		return ;
	}
	
	/**
	* Wy¶wietlenie regu³ w tabelce
	*/
	function _displayRules() {
		if(!empty($this->Rules)) {
			reset($this->Rules);
			while (list($key, $val) = each($this->Rules)) {
				echo "<b>$key:</b> ";
				while (list($key2, $val2) = each($val)) {
					echo "$key2 [ " . number_format($val2['sup'], 3) . " : " . number_format($val2['conf'], 3) . " ], &nbsp;&nbsp;";
				}
				echo "<br>";
			}
		}
		else {
			echo "No rules retrieved.";
		}
		return ;
	}
	
}

?>
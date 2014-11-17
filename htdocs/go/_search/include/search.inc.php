<?php
/**
 * Funkcje Search
 *
 * @author rp@sote.pl
 */
class AdvSearch extends FormCheck {
    
    /**
	 * Rozszerzona funkcja do sprawdzania danych z formularza typu string
	 * dopuszcza aby pole by³o puste jesli sa jakies dane to sprawdza funkcja string
	 *	 
	 * @param  string $email adres do weryfikacji
	 *
	 * @access public
	 *
	 * @return void
	 */
	function string_null($data){		
	    if(empty($data)) return true;
		return $this->string($data);
	} // end string_null()
	
	/**
	 * Rozszerzona funkcja do sprawdzania danych z formularza typu int
	 * dopuszcza aby pole by³o puste jesli sa jakies dane to sprawdza funkcja int
	 *	 
	 * @param  string $email adres do weryfikacji
	 *
	 * @access public
	 *
	 * @return void
	 */
	function int_null($data){		
	    if(empty($data)) return true;
		return $this->int($data);
	} // end int_null()
    
    /**
     * pole listy rozwijanej generowane z tablicy asocjacyjnej
     * @version xHTML 4.01 and higher
     *
     * @param array $data       tablica z wartosciami dla pola listy rozwijanej
     * @param array $array_name nazwa w tablicy REQUEST
     * @param array $form_array nazwa tablicy dla REQUEST (opcjonalnie)
     *
     * @access public
     *
     * @return void
     */
    function list_field($data=array(), $field_name="list", $form_array="form"){
        global $_REQUEST;        
        
        if(empty($data) || empty($field_name)) return;
        /**
         * przechwytywanie wartosci zmiennej request w celu ustawienia pola <option> jako selected
         * jesli dokonano wyboru z listy a inne pola zwrocily blad
         * to na liscie podswietli sie ostatnio wybrana pozycja
         * @var string
         */
        if(!empty($_REQUEST[$form_array][$field_name])) $request=$_REQUEST[$form_array][$field_name];
        else if(!empty($_REQUEST[$form_array])) $request=$_REQUEST[$form_array];
        else $request="default";
        /**
         * jesli zadeklarowano, ze dane z formularza maja byc przesylane jako tablica
         * poprzez zdefiniowanie zmiennej $form_array
         * wygeneruj odpowiednia nazwe pola <select name="@var">
         * @var string
         */
        if(!empty($form_array)) $field_name=$form_array."[".$field_name."]";
        
        print "<select name=\"".$field_name."\">\n";
        while(list($value,$name)=each($data)){
            print "<option value=\"".$value."\"";
            if($value==$request) print " selected";
            print ">$name</option>\n";
        }
        print "</select>\n";
        
        return;
    } // end list_field()
    
    /**
    * wyswietla zawartosc tablicy asocjacyjnej
    * pomocnicze rozszerzenie standardowej funkcji print_r
    *
    * @param array $data tablica do wyswietlenia
    *
    * @access public
    *
    * @return void
    */
    function print_r($data){    
        
        print "<div align=\"left\">\n";
        print "  <pre>";
        print_r($data);
        print "  </pre>";
        print "</div>\n";
        
        return;
    } // end print_r();
    
} // end AdvSearch
?>
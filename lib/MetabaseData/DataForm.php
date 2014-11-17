<?php
/**
 * Budowanie elementow formularzy na podstawie MetabaseData
 *
 * @author  m@sote.pl
 * @version $id$
 * @package soteesklep
 */

require_once ("MetabaseData/MetabaseData.php");
require_once ("PEAR/HTML/Form.php");

class DataForm extends HTML_Form {
    
    /**
    * @var string $default_select domysla wartosc na liscie select
    */
    var $default_select="---";
    
    /**
     * Konstruktor
     *
     * @return none
     */
    function DataForm(&$mdbd,$action='',$method='get',$name='',$target='',$enctype='') {
        $this->mdbd=&$mdbd;
        $this->action=$action;
        $this->method=$method;
        $this->name=$name;
        $this->target=$target;
        $this->enctype=$enctype;
        $this->fields=array();
        $this->start();
        return(0);
    } // end DataForm()

    /**
     * Utworz liste rozwijana na podstawie danych z okreslonej tabeli
     *
     * @param  string $data          date wynikowe z funkcji $mdbd->select("id,name",...)
     *                               w zapytanieu select powinny byc 2 pola klucz,wartosc wyswietlana
     * @param  string $name          HTML_Form nazwa pola formularza
     * @param  string $title         HTML_Form opis pole     
     * @param  string $default       HTML_Form domyslna wartosc wyswietlana w liscie     
     * @param  int    $size          HTML_Form
     * @param  string $blank         HTML_Form
     * @param  bool   $multiple      HTML_Form
     * @param  string $attribs       HTML_Form
     * @return none
     *
     * @public
     */
    function dbAddSelect(&$data,$name,$title,$default='', $size = 1,$blank='',$multiple=false,$attribs='') {                                      
	$entries=$this->_prepareSelectData($data);	
	$this->addSelect($name,$title,$entries,$default,$size,$blank,$multiple,$attribs);        
        return;
    } // end dbAddSelect()

    // jw.
    function dbDisplaySelect(&$data,$name,$default='', $size = 1,$blank='',$multiple=false,$attribs='') {	
	$entries=$this->_prepareSelectData($data);		
	$this->displaySelect($name,$entries,$default,$size,$blank,$multiple,$attribs);	
	return;
    } // end dbDisplaySelect()
    
    /**
    * Wyswietl element select - opis analogiczny do dbAddSelect()
    *
    * @access public
    * @return string HTML z elementem SELECT + wartosci
    */
    function dbMemSelect(&$data,$name,$title,$default='', $size = 1,$blank='',$multiple=false,$attribs='') {                              
        $entries=$this->_prepareSelectData($data);
        $this->_select[$name]=$this->returnSelect($name,$entries,$default,$size,$blank,$multiple,$attribs);
	return $this->_select[$name];
    } // end dbMemSelect()

    /**
    * Wyswietl element select
    *
    * @param string $name nazwa elementu SELECT
    *
    * @access public
    * @return none
    */   
    function dbMemDisplaySelect($name) {
        if (! empty($this->_select[$name])) print $this->_select[$name];
        return (0);
    } // end dbMemDisplaySelect()
    
    
    /**
    * Przetworz dane z MetabaseData do tablicy danych do addSelect z HTML_Form
    *
    * @param array &$data dane z $mdbd->select()
    * @param int   $columns 1 - klucz i waretosc sa te same, odbrfana 1 zmienna z tabeli, 2 - odczytano klucz i wartosc
    *
    * @access private
    * @return array   dane do addSelect "$entries"
    */
    function _prepareSelectData(&$data,$columns=2) {
      reset($data);$entries=array();
        if (! empty($this->default_select)) {
            $entries[0]=$this->default_select;
        }        
        foreach ($data as $d) {	    
            reset($d);
            list(,$key) = each($d);   // 1 element jest kluczem (wartosc przekazywana w formularzu)
            list(,$val) = each($d);   // 1 element wartoscia wyswietlana przy formularzu

	    if ($columns==1) $entries[$key]=$key;
	    else $entries[$key]=$val;

	}          
	
        return $entries;
    } // end _prepareSelectData()
    
} // end class DataForm

?>

<?php
/**
 * Klasa do zarz±dzania datami
 * 
 * @author  rdiak@sote.pl
 * @version $Id: date_manage.inc.php,v 2.5 2004/12/20 17:59:20 maroslaw Exp $
* @package    admin_include
 */

 class DateManage {

	var $last_year='2010';			// rok do ktorego ma sie pokazywac data
	var $count='1';					// ile ma sie pokazac pol wyboru daty
	var $lang='en';					// jezyk w jakim wyswietalne maja byc miesiace
	var $month=array();	    		// miesiace
	var $table='main_param';			// tablica w bazie danych z ktorej bierzemy dane
	var $name_from='wp_valid';		// nazwa pola typu date z data "from"
	var $name_to='wp_producer'; 		// nazwa pola typu date z data "to";
	var $id_name='user_id';		// id wedlug ktorego dane beda wyciagane z bazy
	var $order_by='user_id';				// po ktorej kolumnie bedzie sortowanie		
	var $default_date="0000-0-0";	//domyslna data
	var $from='from';				// domyslna nazwa pola from
	var $to='to';					// domyslna nazwa pola to
	var $id='';						// id aktualnej wyprawy	
	var $line='two';						// jak maja byc wyswietlane daty "one" jedna linia , "two" dwie linie                
	var $path='';					// sciezka		
	var $show_match='all';			//czy ma pokazywac dwie daty czy jedna
	var $label_name_from='';
	var $label_name_to='';
	var $label_select='wybierz datê';
	
	/**
	 * Konstruktor obiektu DateManage
     *
	 * @return boolean
	 */
	function DateManage() {
		$this->monthDateManage();
		$this->show_match='one';
		return true;
	} // end DateManage

	/**
	 * Funkcja pobiera z REQUESTA dane i zapisuje w tablicy
	 *
	 * @return boolean
	 */
	function saveToDb() {
		global $_REQUEST;
		global $database;
		
		$data=array();
		
		$this->id=@$_REQUEST['id'];
		for($i=1; $i <= $this->count; $i++) {
			$dayfrom="day".$this->from.$i;
			$monthfrom="month".$this->from.$i;
			$yearfrom="year".$this->from.$i;
			$monthfrom=$this->MonthToInt(@$_REQUEST[$monthfrom]); 
			
			$dayto="day".$this->to.$i;
			$monthto="month".$this->to.$i;
			$yearto="year".$this->to.$i;
			$monthto=$this->MonthToInt(@$_REQUEST[$monthto]); 

			$date_from=@$_REQUEST[$yearfrom]."-".$monthfrom."-".@$_REQUEST[$dayfrom];
			$date_to=@$_REQUEST[$yearto]."-".$monthto."-".@$_REQUEST[$dayto];
			
			$adddate=@$_REQUEST["adddate".$i];
			$temp=array($i,$date_from,$date_to,$adddate);
			
			array_push ($data, $temp);	
			$tmp=& $data;
		}	
		return $tmp;
	} // end saveToDb
	
	/**
	 * Funkcja wyswietla pola z datami do wyboru
     *
	 * @return boolean
	 */
	function ShowDateManageOne($id='',$i) {
		global $_REQUEST;
		
		if(!empty($_REQUEST['action'])) {
			$data=$this->saveToDb();
			return $data; 
		}
		if(! empty($id)) {
			$data=$this->GetParamDb($id);
		}
		// wyswietl funkcje wspolna dla wszystkich tylko raz
		if($i == 1 ) {
			$this->genGetDateString();
		}
		// wyswietl tyle pol ile jest count
		if(empty($data[$i-1])) {
			// jesli nie ma danych z bazy danych wez wartosci domyslne
			$data[$i-1]=array($this->name_from=>$this->default_date,$this->name_to=>$this->default_date);		
		}	
		//print_r($data);
		// wygeneruj funkcje javascriptowe dla kazdego pola
		$this->genJScriptFunc($i);			
		$this->showItem($data[$i-1],$i);			
		return true;
	} // end ShowDateManage 

	
	/**
	 * Funkcja wyswietla jedeno pole z datami
     *
	 * @return boolean
	 */
	function ShowDateManage($id='') {
		global $_REQUEST;
		
		if(!empty($_REQUEST['action'])) {
			$data=$this->saveToDb();
			return $data; 
		}
		if(! empty($id)) {
			$data=$this->GetParamDb($id);
		}
		// wyswietl funkcje wspolna dla wszystkich
		$this->genGetDateString();
		// wyswietl tyle pol ile jest count
		for($i=1; $i <= $this->count; $i++) {
			if(! isset($data[$i-1])) {
				// jesli nie ma danych z bazy danych wez wartosci domyslne
				$data[$i-1]=array($this->name_from=>$this->default_date,$this->name_to=>$this->default_date);			
			}	
			// wygeneruj funkcje javascriptowe dla kazdego pola
			$this->genJScriptFunc($i);			
			$this->showItem($data[$i-1],$i);			
		}
		return true;
	} // end ShowDateManageOne 
			
	
	function genGetDateString() {
		$str="<SCRIPT LANGUAGE=\"JavaScript\" SRC=\"".$this->path."html/CalendarPopup.js\"></SCRIPT>";
		$str.="<SCRIPT LANGUAGE=\"JavaScript\">\n";
		$str.="function getDateString(y_obj,m_obj,d_obj) {\n";
		$str.="var y = y_obj.options[y_obj.selectedIndex].value;\n";
		$str.="var m = m_obj.options[m_obj.selectedIndex].value;\n";
		$str.="var d = d_obj.options[d_obj.selectedIndex].value;\n";
		$str.="if (y==\"\" || m==\"\") { return null; }\n";
		$str.="if (d==\"\") { d=1; }\n";
		$str.="return str= y+'-'+m+'-'+d;\n";
		$str.="}\n";
		$str.="</SCRIPT>";
		print $str;
		return true;
	} // end genGetDateString	
	
	
	/**
	 * Funkcja tworzy funcje javascriptowe potrzebne do obslugi pol
	 * z datami. Przed kazdym from o tu sa generowane dwie funkcje.
	 *
	 * @return string printuje funkcje.
	 */
	function genJScriptFunc($i) {
		$str="<SCRIPT LANGUAGE=\"JavaScript\">\n";
		$str.="var cal".$this->from.$i." = new CalendarPopup();\n";
		$str.="cal".$this->from.$i.".setReturnFunction(\"setMultipleValues".$this->from.$i."\");\n";
		$str.="function setMultipleValues".$this->from.$i."(y,m,d) {\n";
		$str.="document.forms[0].year".$this->from.$i.".value=y;\n";
		$str.="document.forms[0].month".$this->from.$i.".selectedIndex=m;\n";
		$str.="for (var i=0; i<document.forms[0].day".$this->from.$i.".options.length; i++) {\n";
		$str.="if (document.forms[0].day".$this->from.$i.".options[i].value==d) {\n";
		$str.="document.forms[0].day".$this->from.$i.".selectedIndex=i;\n";
		$str.="}}}\n";
		$str.="var cal".$this->to.$i." = new CalendarPopup();\n";
		$str.="cal".$this->to.$i.".setReturnFunction(\"setMultipleValues".$this->to.$i."\");\n";
		$str.="function setMultipleValues".$this->to.$i."(y,m,d) {\n";
		$str.="document.forms[0].year".$this->to.$i.".value=y;\n";
		$str.="document.forms[0].month".$this->to.$i.".selectedIndex=m;\n";
		$str.="for (var i=0; i<document.forms[0].day".$this->to.$i.".options.length; i++) {\n";
		$str.="if (document.forms[0].day".$this->to.$i.".options[i].value==d) {\n";
		$str.="document.forms[0].day".$this->to.$i.".selectedIndex=i;\n";
		$str.="}}}\n";
		$str.="</SCRIPT>\n";
		print $str;	
		return;
	} // end genJScriptFunc
	
	/**
	 * Funkcja printuje listy rozwijane z datami
	 *
	 * @return string printuje listy rozwijane z datami.
	 */
	function showItem($data,$number) {
		$check_from=split("[- ]",$data[$this->name_from]);
		$check_to=split("[- ]",$data[$this->name_to]);
		//print_r($check_from);
		$str= $this->label_name_from."&nbsp;&nbsp;";
		$str.=$this->showDay($number,$check_from[2],"day".$this->from); 
		$str.=$this->showMonth($number,$check_from[1],"month".$this->from); 
		$str.=$this->showYear($number,$check_from[0],"year".$this->from); 
		$str.=$this->showCalendarFrom($number);
		if($this->line == 'one') {
			$str.="&nbsp;&nbsp;&nbsp;&nbsp;";
		} else {
			$str.="<br>";
		}
		if($this->show_match == 'all') {
			$str.=$this->label_name_to."&nbsp;&nbsp;";
			$str.=$this->showDay($number,$check_to[2],"day".$this->to); 
			$str.=$this->showMonth($number,$check_to[1],"month".$this->to); 
			$str.=$this->showYear($number,$check_to[0],"year".$this->to); 
			$str.=$this->showCalendarTo($number);
		}
		print $str;
		return true;
	} // end showItem
	
	/**
	 * Funkcja tworzy onclicki dla kazdego pola daty from
	 *
	 * @return string printuje listy rozwijane z datami.
	 */
	function showCalendarFrom($i) {
		$str="<A HREF=\"#\" onClick=\"cal".$this->from.$i.".showCalendar";
		$str.="('anchor15',getDateString(document.forms[0].year".$this->from.$i;
		$str.=",document.forms[0].month".$this->from.$i;
		$str.=",document.forms[0].day".$this->from.$i.")); return false;\"";
		$str.=" NAME=\"anchor15\" ID=\"anchor15\">".$this->label_select."</A>";
		return $str;
	 } // end showCalendarFrom		
	
	/**
	 * Funkcja tworzy onclicki dla kazdego pola daty to
	 *
	 * @return string printuje listy rozwijane z datami.
	 */
	function showCalendarTo($i) {
		$str="<A HREF=\"#\" onClick=\"var d=getDateString(document.forms[0].year".$this->to.$i;
		$str.=",document.forms[0].month".$this->to.$i.",document.forms[0].day".$this->to.$i.");";
		$str.=" cal".$this->to.$i.".showCalendar('anchor16',(d==null)?getDateString(document.forms[0].";
		$str.="year".$this->from.$i.",document.forms[0].month".$this->from.$i.",document.forms[0].";
		$str.="day".$this->from.$i."):d); return false;\" ";
		$str.=" NAME=\"anchor16\" ID=\"anchor16\">".$this->label_select."</A>";
		return $str;
	} // end  showCalendarTo		
	
	/**
	 * Funkcja pobiera dane o dacie o odpowiednio jest formatuje.
	 * Jesli id nie jest podane dane brane sa z $_REQUESTA;
	 *
	 * @return array odpowiednio sforamtowane dane do daty.
	 */
	function & GetParamDb($id) {
		global $database;
		if(!empty($id)) {
			// dane pobierane z bazy danych	
			$data=$database->sql_select_multi_array4(array($this->name_from,$this->name_to),$this->table,"$this->id_name=$id","ORDER BY $this->order_by"); 
		} else {
			// dane brane z $_REQUESTA
		}
		
		$tmp= &$data;
		return $tmp;
	} // end GetParamDb 

	/**
	 * Funkcja ustawia ilosc wyswietlanych pol
     *
	 * @return boolean
	 */
	function setCount($count) {
		$this->count=$count;
		return true;	
	} // end setCount

	/**
	 * Funkcja ustawia ilosc wyswietlanych pol
     *
	 * @return boolean
	 */
	function getCount() {
		return $this->count;	
	} // end getCount

	/**
	 * Funkcja ustawia ostatni wyswietlany rok
     *
	 * @return boolean
	 */
	function setLastYear($year) {
		$this->last_year=$year;
		return true;
	} // end setLastYear 
	
	/**
	 * Funkcja ustawia jezyk wyswietalnia nazwy miesiecy
     *
	 * @return boolean
	 */
	function setLang($lang) {
		$this->lang=$lang;
		return true;
	} // end setLang

	/**
	 * Funkcja wyswietla liste rozwiajana z latami
     *
	 * @param  int $number liczba porzadkowa pola bedzie dodana do nazwy
	 * @param  string $name nazwa pola
	 * @param  string $default domyslna wartosc
     * @return boolean
	 */
	function & showYear($number,$default='',$name='') {
		if(empty($name)) {
			$name="year";
		}
		$str="<SELECT NAME=\"".$name.$number."\">\n";
		$str.="<OPTION>\n";
		$year=date("Y");
		for($i=$year; $i<=$this->last_year; $i++) {
			if(	$default == $i ) {
				$str.="<OPTION VALUE=\"".$i."\" selected>".$i."\n";
			} else {	
				$str.="<OPTION VALUE=\"".$i."\">".$i."\n";
			}
		}
		$str.="</SELECT>\n";
		$temp=&$str;
		return $temp;	
	} // end showYear

	/**
	 * Funkcja zmienia cyforwy miesiac na trzyliterowy skrot
     *
	 * @param  int $default miesiac w postaci cyfry
     * @return boolean
	 */ 		
	function IntToMonth($default) {
		$i=1;
		foreach($this->month as $key=>$value) {
			if($i == $default) {
				preg_match("/^([-a-zA-Z]{3})/",$key,$data);
				$default=$data[1];
				return $default;
			}
			$i++;	
		}	
	} // end IntToMonth

	/**
	 * Funkcja zmienia cyforwy miesiac na trzyliterowy skrot
     *
	 * @param  int $default miesiac w postaci cyfry
     * @return boolean
	 */ 		
	function MonthToInt($month) {
		$i=1;
		if(!empty($month)) {
			foreach($this->month as $key=>$value) {
				if(ereg("$month",$key)) {
					return $i;
				}
				$i++;	
			}
		}		
	} // end MonthToInt
	
	/**
	 * Funkcja wyswietla liste rozwiajana z miesiacami
     *
	 * @param  int $number liczba porzadkowa pola bedzie dodana do nazwy
	 * @param  string $name nazwa pola
	 * @param  string $default domyslna wartosc
     * @return boolean
	 */
	function & showMonth($number,$default='',$name='') {
		if(empty($name)) {
			$name="month";
		}
		if(ereg("[0-9]{1,2}",$default)) {
			$default=$this->IntToMonth($default);
		}
		$str="<SELECT NAME=\"".$name.$number."\">\n";
		$str.="<OPTION>\n";
		foreach($this->month as $key=>$value) { 
			$cut=preg_match("/^([-a-zA-Z]{3})/",$key,$data);
			if(	$default == $data[1]) {
				if($this->lang == 'en') {
					$str.="<OPTION VALUE=\"".$data[1]."\" selected>".$key."\n";
				} else {
					$str.="<OPTION VALUE=\"".$data[1]."\" selected>".$value."\n";
				}
			} else {	
				if($this->lang == 'en') {
					$str.="<OPTION VALUE=\"".$data[1]."\">".$key."\n";
				} else {
					$str.="<OPTION VALUE=\"".$data[1]."\">".$value."\n";
				} 	
			}
		}
		$str.="</SELECT>\n";
		$temp=&$str;
		return $temp;	
	} // end showMonth 

	/**
	 * Funkcja wyswietla liste rozwiajana z latami
     *
	 * @param  int $number liczba porzadkowa pola bedzie dodana do nazwy
	 * @param  string $name nazwa pola
	 * @param  string $default domyslna wartosc
     * @return boolean
	 */
	function & showDay($number,$default='',$name='') {
		if(empty($name)) {
			$name="day";
		}
		$str="<SELECT NAME=\"".$name.$number."\">\n";
		$str.="<OPTION>\n";
		for($i=1; $i<=31; $i++) {
			if(	$default == $i ) {
				$str.="<OPTION VALUE=\"".$i."\" selected>".$i."\n";
			} else {	
				$str.="<OPTION VALUE=\"".$i."\">".$i."\n";
			}
		}
		$str.="</SELECT>\n";
		$temp=&$str;
		return $temp;	
	} // end showDay 

	function monthDateManage() {
		$this->month=array(
							"January"=>"Styczeñ",
							"February"=>"Luty",
							"March"=>"Marzec",
							"April"=>"Kwiecieñ",
							"May"=>"Maj",
							"June"=>"Czerwiec",
							"July"=>"Lipiec",
							"August"=>"Sierpieñ",
							"September"=>"Wrzesieñ",
							"October"=>"Pa¼dziernik",
							"November"=>"Listopad",
							"December"=>"Grudzieñ",
							);							
		return true;
	} // end monthDateManage
 } // end class DateManage

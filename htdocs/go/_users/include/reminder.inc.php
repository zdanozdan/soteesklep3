<?php
/**
 * Klasa do zarzadzania terminarzem uzytkownika
 * 
 * @author  rp@sote.pl
 * @version $Id: reminder.inc.php,v 1.3 2004/12/20 18:01:56 maroslaw Exp $
* @package    users
 */ 
class UserReminder{   
    
    var $max_records=12;
     
    /**
     * Edycja rekordow
     *
     * @access public
     * @return array
     */     
    function editRecord(){        
        if(empty($_REQUEST['id'])) return;        
        $data=$this->_selectData();
        $data=$this->_convertData($data);                
        return $data;    
     } // end editRecord()
     
    /**
     * Konwersja tablicy sql na dane do formularza
     *
     * @pararm array $data dane do przekonwertowania
     *
     * @access private
     * @return array
     */     
    function _convertData($data){
        if(!is_array($data)) return;
        foreach($data as $key=>$val){
            $key=ereg_replace("remind_","",$key);
            $record[$key]=$val;
        }        
        return $record;
    } // end convertData()

    /**
     * Wyswietlanie rekordow z bazy
     *
     *
     * @access public
     * @return none
     */          
     function deleteRecord(){         
         global $mdbd,$_SESSION,$sess,$theme;
         
         if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;         
         
         if(!empty($_REQUEST['del'])){
             $id=$_REQUEST['del'];
         } else {             
             return(0);
         }
         if (!$sess->reload()){
             $mdbd->delete("users_reminder",
                           "id=? and id_users=?",
                           array(
                                 "1,".$id=>"int",
                                 "2,".$_SESSION['global_id_user']=>"int"                                                                )
                           );
                           
         $this->_sessCountDel();         
         // pokaz plik html
	     $theme->theme_file("_users/reminder/reminder_del.html.php");
         }         
         $this->addUrl();
	     // lub wyswietl ksiazke adresowa		     
         $theme->theme_file("_users/reminder/reminder.html.php");
	     return(0);         
         
     } // end deleteRecord()
    
    /**
     * Wyswietlanie rekordow z bazy
     *
     *
     * @access public
     * @return none
     */          
     function showReminders(){
         global $sess, $address_book_rec, $theme;
         
         $data=$this->_selectData();
         if(empty($data)) {
             // zapisz 0 w sesji
             $this->_sessCountNull();
             $this->addUrl();
             return;
         }
         $this->_sessCountAddArray($data);
         $this->_showRecords($data); // wyswietl rekordy
         return(0);
     } // end showReminders()

    /**
     * Funkcja wpisuje dane w szablon i wyswietla
     *
     * @param array $data dane z bazy danych
     *
     * @access public
     * @return none
     */          
     function _showRecords($data){
         global $theme,$lang;
         
         $row="record_odd";
         foreach($data as $key => $value) {             
             $date=explode("-",$value['remind_date']);
             
             $day=$date[0];
             $day=ereg_replace("^0+","",$day);
             $value['remind_day']=$day;
             
             $month=$date[1];
             $month=ereg_replace("^0+","",$month);
             $value['remind_month']=$lang->month_name[$month];             
             
             $theme->record=&$value;
             $theme->reminder_row=$row;
             
             $theme->theme_file("_users/reminder/reminder_record.html.php");                                  
             
             if($row=="record_odd"){
                 $row="record_even";
             } else {
                 $row="record_odd";
             }
         }
     }
     
     /**
     * Wyswietlanie rekordow
     *
     * @access private
     * @return array
     */     
	function _selectData(){
	    global $mdbd,$_SESSION;
	    
	    if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
	    	    
	    // zawsze zwroc tablice
	    if (!empty($_REQUEST['id'])) {
    	    $_sql="AND id=?";    	    
    	    $id=$_REQUEST['id'];
    	    $type="auto";	        	
	    } else {
	        $_sql='';
	        $id=0;
	        $type="array";
	    }	    	    
	    
	    $data=$mdbd->select("id,id_users,remind_date,remind_occasion,remind_event,remind_advise,remind_handling1,remind_handling2,remind_handling3",
	                        "users_reminder",
	                        "id_users=? $_sql",
	                        array(
	                              "1,".$_SESSION['global_id_user']=>"int",
	                              "2,".$id=>"int"
	                              ),
	                        "ORDER BY id LIMIT 0,$this->max_records",
	                        $type
	                        );
	    return $data;
	} // end _selectData()
	
	/**
	 * Wyswietl zawartosc tablicy
	 *
	 * @param array $data tablica do wyswietlenia
	 * @acces private
	 * @return none
	 */
	 function _showArray($data){
	     global $_SESSION, $sess;
	     print "<div align=\"left\">\n";
	     print "  <pre>";
	     print_r($data);
	     print "</pre>\n";
	     print "</div>\n";
	 } // end _showArray()
	 
	/**
	 * Dodaj liczbe rekordow z tablicy sql do sesji
	 *
	 * @param array $data tablica do wyswietlenia
	 * @acces private
	 * @return none
	 */
	 function _sessCountAddArray($data){
	     global $sess, $reminder_data;
	     $count=count($data);
         $reminder_data=array("reminder_rec_count"=>$count);
         $sess->register("reminder_data",$reminder_data);
	 } // end _sessCountAdd()

	/**
	 * Odejmij wartosc z sesji
	 *
	 * @param array $data tablica do wyswietlenia
	 * @acces private
	 * @return none
	 */
	 function _sessCountAdd(){
	     global $sess, $reminder_data;
	     $count=@$_SESSION['reminder_data']['reminder_rec_count']+1;	     
         $reminder_data=array("reminder_rec_count"=>$count);
         $sess->register("reminder_data",$reminder_data);         
	 } // end _sessCountAdd()
	 
    /**
	 * Odejmij wartosc z sesji
	 *
	 * @param array $data tablica do wyswietlenia
	 * @acces private
	 * @return none
	 */
	 function _sessCountDel(){
	     global $sess, $reminder_data;
	     $count=@$_SESSION['reminder_data']['reminder_rec_count']-1;	     
         $reminder_data=array("reminder_rec_count"=>$count);
         $sess->register("reminder_data",$reminder_data);         
	 } // end _sessCountAdd()
	 
	/**
	 * Rejestrowanie wartosci 0 jako liczbe rekordow w bazie
	 *
	 * @param array $data tablica do wyswietlenia
	 * @acces private
	 * @return none
	 */
	 function _sessCountNull(){
	     global $sess, $reminder_data;
	     $count=0;
         $reminder_data=array("reminder_rec_count"=>$count);
         $sess->register("reminder_data",$reminder_data);
	 } // end _sessCountNull()
	
    /**
     * Linki "Dodaj" (HTML)
     *
     * @access private
     * @return none
     */     
    function addUrl(){        
        global $theme,$lang;
        $count=@$_SESSION['reminder_data']['reminder_rec_count'];
        if(empty($count)) $count=0;
        if($count==0){
            $theme->add_rec_top="&raquo;&nbsp;<a href=\"/go/_users/reminder1.php\">".$lang->add_reminder."</a>&nbsp;&laquo;";
            $theme->add_rec_bottom="&nbsp;";
        } else if ($count<$this->max_records){            
            $theme->add_rec_top="&raquo;&nbsp;<a href=\"/go/_users/reminder1.php\">".$lang->add_reminder."</a>&nbsp;&laquo;";
            $theme->add_rec_bottom="&raquo;&nbsp;<a href=\"/go/_users/reminder1.php\">".$lang->add_reminder."</a>&nbsp;&laquo;";            
        } else {                        
            $theme->add_rec_top="&nbsp;";
            $theme->add_rec_bottom="&nbsp;";
        }
    } // end addUrl()
	 
	 
	 /**
	 * Funkcja generuje nazwy miesiecy dla pola select
	 *
	 * @param array  $data tablica miesiecy
	 * @acces public
	 *
	 * @return none
	 */
	 function selectMonth(){
	     global $_POST, $lang, $theme;
	     if(!empty($_POST['reminder']['day'])){
	         $current_choice=@$_POST['reminder']['month'];
	     }
	     else if(!empty($theme->form['date'])){
	         $month=explode("-",$theme->form['date']);
	         $current_choice=$month[1];
	         
	     }   	     
	     // nazwy miesiecy z glownej klasy lang
	     $month=$lang->month_name;
	     	     
	     print "<select name=\"reminder[month]\">";
	     while(list($key,$value)=each($month)){
	         if($key<=9) $key="0".$key;	     
	         if($key==$current_choice){
	             print "  <option value=\"".$key."\" selected>".$value."</option>\n";
	         } else {	             
	             print "  <option value=\"".$key."\">".$value."</option>\n";
	         }
	     }
	     print "</select>\n";
	 } // end selectMonth()
	 
    /**
	 * Funkcja generuje nazwy miesiecy dla pola select
	 *	 
	 * @acces  public
	 * @return none
	 */
	 function selectDay(){	     
	     global $_POST, $theme;	     	     
	     if(!empty($_POST['reminder']['day'])){
	         $current_choice=$_POST['reminder']['day'];
	     }
	     else if(!empty($theme->form['date'])){
	         $day=explode("-",$theme->form['date']);
	         $current_choice=$day[0];
	     } 
	     	     
	     print "<select name=\"reminder[day]\">";
	     $j=1;
	     for ($i=1;$i<=31;$i++){	       	       	       
	         if($j<=9) $j="0".$j;
	         if($j==$current_choice){
	             print "  <option value=\"".$j."\" selected>".$i."</option>\n";
	         } else {	             
	             print "  <option value=\"".$j."\">".$i."</option>\n";
	         }
	         $j++;
	     }
	     print "</select>\n";
	 } // end selectMonth()
	 
    /**
	 * Funkcja generuje nazwy "okazji" dla pola select
	 *
	 * @param array  $data tablica miesiecy
	 * @acces public
	 *
	 * @return none
	 */
	 function selectOccasion(){
	     global $_POST,$lang,$theme;
	     	     
	     if(!empty($_POST['reminder']['occasion'])){
	         $current_choice=@$_POST['reminder']['occasion'];
	     }
	     else if(!empty($theme->form['occasion'])){
	         $current_choice=$theme->form['occasion'];
	     }   	     
	     
	     // nazwy okazji z klasy lang (lokalnej)
	     $occasion=$lang->occasion;	     
	     print "<select name=\"reminder[occasion]\">";
	     while(list($key,$value)=each($occasion)){
	         if($value==$current_choice){
	             print "  <option value=\"".$value."\" selected>".$value."</option>\n";
	         } else {	             
	             print "  <option value=\"".$value."\">".$value."</option>\n";
	         }
	     }
	     print "</select>\n";
	 } // end selectOccasion() 
	 
	/**
	 * Funkcja generuje nazwy "powiadomien" dla pola select
	 *
	 * @param array  $data tablica "powiadomien"
	 * @acces public
	 *
	 * @return none
	 */
	 function selectAdvise(){
	     global $_POST,$lang,$theme;	
	     
	     if(!empty($_POST['reminder']['advise'])){
	         $current_choice=@$_POST['reminder']['advise'];
	     }
	     else if(!empty($theme->form['advise'])){
	         $current_choice=$theme->form['advise'];
	     }   	     
	     
	     // nazwy pobrane z klasy lang (lokalnej)
	     $advise=$lang->advise;
	          
	     print "<select name=\"reminder[advise]\">";
	     while(list($key,$value)=each($advise)){
	         if($key==$current_choice){
	             print "  <option value=\"".$key."\" selected>".$value."</option>\n";
	         } else {	             
	             print "  <option value=\"".$key."\">".$value."</option>\n";
	         }
	     }
	     print "</select>\n";
	 } // end selectAdvise() 

	/**
	 * Funkcja generuje checkbox
	 *	 
	 * @acces public
	 *
	 * @return none
	 */
	 function checkBox($name){
	     global $_POST,$theme;		  
	     	     
	     if(!empty($_POST['reminder'][$name])){
	         $current_choice=@$_POST['reminder'][$name];
	     }
	     else if(!empty($theme->form[$name])){
	         $current_choice=$theme->form[$name];
	     } else {
	         $current_choice=0;
	     }  	   
	          
         if($current_choice==1){
             print "<input class=\"border0\" type=\"checkbox\" name=\"reminder[".$name."]\" value=\"1\" checked>";
         } else {	             
             print "<input class=\"border0\" type=\"checkbox\" name=\"reminder[".$name."]\" value=\"1\">";
         }
	 } // end selectAdvise() 
	 
	/**
     * Dodanie nowego rekordu do bazy
     *
     * @author rp@sote.pl
     *
     * @param array $data dane z formularza
     *
     * @return none;     
     */
	 function insertData(&$data){
		global $mdbd, $_SESSION, $theme;
		global $sess;		
		
		if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
		
		if(empty($data['handling1'])) $data['handling1']=0;
		if(empty($data['handling2'])) $data['handling2']=0;
		if(empty($data['handling3'])) $data['handling3']=0;
		
		if(@$_SESSION['reminder_data']['reminder_rec_count']>=$this->max_records) return;
		
		if (! $sess->reload()) {
		    $mdbd->insert("users_reminder","id_users,
		                                        remind_date,
		                                        remind_occasion,
		                                        remind_event,
		                                        remind_advise,
		                                        remind_handling1,
		                                        remind_handling2,
		                                        remind_handling3",
		                                        "?,?,?,?,?,?,?,?",
		                                        array(
		                                             "1,".$_SESSION['global_id_user']=>"int",
		                                             "2,".$data['day']."-".$data['month']=>"text",
		                                             "3,".$data['occasion']=>"text",
		                                             "4,".$data['event']=>"text",
		                                             "5,".$data['advise']=>"text",
		                                             "6,".$data['handling1']=>"int",
		                                             "7,".$data['handling2']=>"int",
		                                             "8,".$data['handling3']=>"int"		                                         
		                                             )
		                 );				
		$this->_sessCountAdd();
		// pokaz plik html z podziekowaniem
	    $theme->theme_file("_users/reminder/reminder_add.html.php");
		}			    	    		
		$this->addUrl();			    
	    $theme->theme_file("_users/reminder/reminder.html.php");
	    return(0);
	} // end insertData()
	
    /**
     * Update rekordu
     *
     *
     * @param  array $data dane z formularza
     * @return none;     
     */
     function updateRecord(&$data){
		global $mdbd, $_SESSION, $theme;
		global $sess;		
		
		if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
		if(@$_SESSION['global_id_user']!=$data['id_users']) return;		
		
		if(empty($data['handling1'])) $data['handling1']=0;
		if(empty($data['handling2'])) $data['handling2']=0;
		if(empty($data['handling3'])) $data['handling3']=0;
		
		if (! $sess->reload()) {
		    
		    $mdbd->update("users_reminder","remind_date=?,		                                        
		                                        remind_occasion=?,
		                                        remind_event=?,
		                                        remind_advise=?,
		                                        remind_handling1=?,
		                                        remind_handling2=?,
		                                        remind_handling3=?",
		                                        "id_users=? AND id=?",
		                                        array(
		                                             "1,".$data['day']."-".$data['month']=>"text",
		                                             "2,".$data['occasion']=>"text",
		                                             "3,".$data['event']=>"text",
		                                             "4,".$data['advise']=>"text",
		                                             "5,".$data['handling1']=>"int",
		                                             "6,".$data['handling2']=>"int",
		                                             "7,".$data['handling3']=>"int",	
		                                             "8,".$_SESSION['global_id_user']=>"int",
		                                             "9,".$data['id']=>"int"
		                                             )
		                 );		
		// pokaz plik html z podziekowaniem
	    $theme->theme_file("_users/reminder/reminder_upd.html.php");
		}					
		$this->addUrl();	
	    //wyswietl terminarz
	    $theme->theme_file("_users/reminder/reminder.html.php");
	    return(0);
	} // end insertData()
	 
} // end class UserReminder

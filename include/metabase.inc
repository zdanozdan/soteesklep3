<?php
/**
 * Klasa ulatwiajca dostep do bazy danych i wyciagania czesto uzywanych struktur danych
 *
 * @deprecated  klasa nieuzywana w nowych elementach utworzonych po 2003-11-16
 *              zastepuje ja biblioteka MetabaseData ($mdbd)
 *
 * @author      rdiak@sote.pl m@sote.pl
 * @version     $Id: metabase.inc,v 2.32 2006/01/06 13:14:42 scalak Exp $ 
* @package    include
 */


class my_Database {

  /**
   * Funkcja selectuje z tabeli bazy danych jedna wartosc 
   * Przyk³ad: $data=$database->sql_select("code","table","where");
   *
   * @param  string $code  nazwa kolumny, 
   * @param  string $table nazwa tabeli
   * @param  string $where warunek postaci data=data
   * @return string $code1 dana z bazy danych - wynik zapytania SQL
   */
    function sql_select($code,$table,$where='',$opt='') {
        global $db;
        
        $query="SELECT $code FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        if(!empty($opt)) {
        	$query.=$opt;
        }	
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    $code1=$db->FetchResult($result,0,$code);
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return @$code1;
    }
    
    /**
     * Funkcja selectuje z tabeli bazy danych tablice wartosci jednej kolumny 
     * Przyk³ad: $data=$database->sql_select_array("code","table","where");
     *
     * @param  string $code  nazwa kolumny, 
     * @param  string $table nazwa tabeli
     * @param  string $where warunek postaci data=data
     * @return array  $ret_table tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_select_array($code,$table,$where='') {
        global $db;
        
        $ret_table=array();
        $query="SELECT $code FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        array_push ($ret_table, $code1);
                    }
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }  
    
    /**
     * Funkcja aktualizujaca dane w tablicy w bazie danych
     * Przyk³ad: $data=$database->sql_update("code","table","data");
     *
     * @param  string $table nazwa tabeli
     * @param  string $where warunek postaci data=data
     * @param  array  $data  tablica asocjacyjna 
     * @return array  $code1 tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_update($table,$where,$data) {
        global $db;
        $query="UPDATE $table SET ";
        while ( list( $key, $value ) = each( $data ) ) {
            $query.=$key."=?, ";
        }

        reset($data);
        $query=ereg_replace(", $", " ",$query);
        if($where != "" ) {
            $where_sp=split("=",$where);
            $query.=" WHERE $where_sp[0]=? ";
        }
        $prepared_query=$db->PrepareQuery($query);
        //print $query;
        if ($prepared_query) {
            $i=1;
            while ( list( $key, $value ) = each( $data ) ) {
                $db->QuerySetText($prepared_query,$i,$value);
                $i++;
            }
            if($where != "" ) {
                $db->QuerySetText($prepared_query,$i,$where_sp[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result==0) {
                die ($db->Error());
            }
        } else {
			die ($db->Error());
        }
        return $result;
    }

     /**
     * Funkcja aktualizujaca dane w tablicy w bazie danych
     * Przyk³ad: $data=$database->sql_update("code","table","data");
     *
     * @param  string $table nazwa tabeli
     * @param  string $where warunek postaci data=data
     * @param  array  $data  tablica asocjacyjna 
     * @return array  $code1 tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_update1($table,$where,$data,$opt='') {
        global $db;
        $query="UPDATE $table SET ";
        while ( list( $key, $value ) = each( $data ) ) {
            $query.=$key."=?, ";
        }

        reset($data);
        $query=ereg_replace(", $", " ",$query);
        if($where != "" ) {
            $where_sp=split("=",$where);
            $query.=" WHERE $where_sp[0]=? ";
        }
        if($opt != "" ) {
            $query.=$opt;
            
        }
        $prepared_query=$db->PrepareQuery($query);
        //print $query;
        if ($prepared_query) {
            $i=1;
            while ( list( $key, $value ) = each( $data ) ) {
                $db->QuerySetText($prepared_query,$i,$value);
                $i++;
            }
            if($where != "" ) {
                $db->QuerySetText($prepared_query,$i,$where_sp[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result==0) {
				return $result;
            }
        } else {
			die ($db->Error());
        }
        return $result;
    }

    /**
     * Funkcja aktualizujaca dane w tablicy w bazie danych
     * Przyk³ad: $data=$database->sql_update("code","table","data");
     *
     * @param  string $table nazwa tabeli
     * @param  string $where warunek postaci data=data
     * @param  array  $data  tablica asocjacyjna 
     * @return array  $code1 tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_update2($table,$where,$data,$opt='') {
        global $db;
        $query="UPDATE $table SET ";
        while ( list( $key, $value ) = each( $data ) ) {
            $query.=$key."=".$value.", ";
        }

        reset($data);
        $query=ereg_replace(", $", " ",$query);
        if($where != "" ) {
            $where_sp=split("=",$where);
            $query.=" WHERE $where_sp[0]='".$where_sp[1]."' ";
        }
        if($opt != "" ) {
            $query.=$opt;
            
        }
        $prepared_query=$db->PrepareQuery($query);
        //print $query;
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result==0) {
				return $result;
            }
        } else {
			die ($db->Error());
        }
        return $result;
    }
        
    
    
    /**
     * Funkcja insertujaca dane w tablicy w bazie danych
     * Przyk³ad: $data=$database->sql_insert("table","data");
     * 
     * @param  string $table nazwa tabeli
     * @param  array  $data  tablica asocjacyjna 
     * @return array  $code1 tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_insert($table,$data) {
        global $db;
        $query="INSERT INTO $table";
        $name=" (";
        $field=" VALUES (";
        while ( list( $key, $value ) = each( $data ) ) {
            $name.=$key.",";
            $field.="?,";
        }
        $name=ereg_replace(",$", ")",$name);
        $field=ereg_replace(",$", ")",$field);                              
        $query.=$name.$field;
        reset($data);
        //print $query;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $i=1;
            while ( list( $key, $value ) = each( $data ) ) {
                $db->QuerySetText($prepared_query,$i,$value);
                $i++;
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result==0) {
                return 0;
            }
        } else {
            return 0;
        }
        return $result;
    }

    /**
     * Funkcja insertujaca dane w tablicy w bazie danych
     * Przyk³ad: $data=$database->sql_insert("table","data");
     * 
     * @param  string $table nazwa tabeli
     * @param  array  $data  tablica asocjacyjna 
     * @return array  $code1 tablica danych  z bazy danych - wynik zapytania SQL
     */
    function sql_insert_table($table,$data) {
        global $db;
        foreach($data as $key1=>$value1) {
        	
        	$query="INSERT INTO $table";
        	$name=" (";
        	$field=" VALUES (";
        	while ( list( $key, $value ) = each( $value1 ) ) {
            	$name.=$key.",";
            	$field.="?,";
        	}
        	$name=ereg_replace(",$", ")",$name);
        	$field=ereg_replace(",$", ")",$field);                              
        	$query.=$name.$field;
        	reset($value1);
        	$prepared_query=$db->PrepareQuery($query);
        	//print $query;
        	if ($prepared_query) {
            	$i=1;
            	while ( list( $key, $value ) = each( $value1 ) ) {
                	$db->QuerySetText($prepared_query,$i,$value);
                	$i++;
            	}
            	$result=$db->ExecuteQuery($prepared_query);
            	if ($result==0) {
                	return 0;
            	}
        	} else {
            	return 0;
        	}
        }	
        return $result;
    }
     
    /**
     * Funkcja kasujaca dane tabeli
     * Przyk³ad: $result=$database->sql_delete("accounts","where");
     *
     * @param  string $table  nazwa tabeli
     * @param  string $where  warunek sql 
     * @return int    $result ilosc skasowanych rekordow
     */
    function sql_delete($table,$where='') {
        global $db;
        $query="DELETE FROM $table";
        if($where != "" ) {
            $where_sp=split("=",$where);
            $query.=" WHERE $where_sp[0]=? ";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$where_sp[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result==0) {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $result;
    }
    
    /**
     * Funkcja selectuaca dwia pola z bazy danych
     * Przyklad: $data=$database->sql_select_data("pole1","pole2","table","where");
     *
     * @param  string $code     nazwa pierwszego pola w bazie danych
     * @param  string $code_dir nazwa drugiego pola w bazie danych
     * @param  string $table    nazwa tabeli
     * @param  string $where    warunek sql 
     * @return array  $data     array($code,$code_dir) dwuelementowa tablica  - wynik zapytania SQL
     */
    function sql_select_data($code,$code_dir,$table,$where) {
        global $db;
        
        $query="SELECT $code,$code_dir FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $code1=$db->FetchResult($result,0,$code);
                $code_dir1=$db->FetchResult($result,0,$code_dir);
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        $data=array($code1,$code_dir1);
        return $data;
    }

    /**
     * Funkcja selectujaca dane z dwoch pol z bazy danych
     * Przyklad: $data=$database->sql_select_data_array("pole1","pole2","table","where");
     * 
     * @param string $code       nazwa pierwszego pola w bazie danych
     * @param string $code_dir   nazwa drugiego pola w bazie danych
     * @param string $table      nazwa tabeli
     * @param string $where      warunek sql 
     * @return array $ret_table  array($code1=>$code_dir1) tablica asocajcyjna $code1=>$code_dir1 z wartosciami  
     */
    function sql_select_data_array($code,$code_dir,$table,$where='') {
        global $db;
        
        $ret_table=array();        
        $query="SELECT $code,$code_dir FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
            
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $code_dir1=$db->FetchResult($result,$i,$code_dir);
                        $ret_table = $ret_table+array($code1=>$code_dir1);
                    }
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }

    /**
     * Funkcja selectujaca  z bazy danych kilka pol 
     * Przyk³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql 
     * @return array  $ret_table tablica z wartosciami
     */
    function sql_select_multi_array($records,$table,$where) {
        global $db;
        
        $ret_table=array();        
        $str="";
        foreach($records as $value){
            $str.=$value.",";
        }
        reset($records);
        $str=ereg_replace(",$","",$str);
        $query="SELECT $str FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    foreach($records as $value){
                        $code1=$db->FetchResult($result,0,$value);
                        array_push ($ret_table, $code1);
                    }
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }

    /**
     * Funkcja selectujaca  z bazy danych kilka pol 
     * Przyk³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql 
     * @return array  $ret_table tablica z wartosciami
     */
    function sql_select_multi_array2($records,$table,$where) {
        global $db;
        
        $ret_table=array();        
        $str="";
        foreach($records as $value){
            $str.=$value.",";
        }
        reset($records);
        $str=ereg_replace(",$","",$str);
        $query="SELECT $str FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        print $query;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    foreach($records as $value){
                        $code1=$db->FetchResult($result,0,$value);
                        $ret_table = $ret_table+array($value=>$code1);
                    }
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }
     /**
     * Funkcja selectujaca  z bazy danych kilka pol 
     * Przyk³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql 
     * @return array  $ret_table tablica z wartosciami
     */
    function sql_select_multi_array5($records,$table,$where) {
        global $db;
        
        $ret_table=array();        
        $str="";
        foreach($records as $value){
            $str.=$value.",";
        }
        reset($records);
        $str=ereg_replace(",$","",$str);
        //print $str;
        $query="SELECT $str FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        //print "<br>".$query."<br>";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    foreach($records as $value){
                        $code1=$db->FetchResult($result,0,$value);
                        $ret_table = $ret_table+array($value=>$code1);
                    }
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }
   
    /**
     * Funkcja selectujaca  z bazy danych dwie wartosci i tworzaca strukture <select><option></option></select>
     * Przyk³ad: $data=$database->sql_select_select("table","label","code","name","default","where");
     *
     * @param  string $table   nazwa tabeli
     * @param  string $label   wartosc pola name w poleceniu <select name=$label>  
     * @param  string $code    pole ktore bedzie wpisane w <option value=$code> (pole z tabeli $table)
     * @param  string $name    pole ktore bedzie wpisane w <option value=$code> $name </option> (pole z tabeli $table) 
     * @param  string $default domyslna wartosc ( ta ktora ma sie pokazac w okienku ) 
     * @param  string $where   warunek sql
     * @return global string   $this->result wynik zapytania w postaci tablicy PHP array("nazwa"=>"wartosc",...) (m@sote.pl 20030523)
     * @return string $res     gotowa do wyswietlenia struktura <select><option></option></select> 
     */
	function sql_select_select($table,$label,$code,$name,$default='',$where='',$opt='',$size=1) {
        global $db;


        $query="SELECT $code,$name FROM $table";
        if($where != "" ) {
            if(ereg('where',$where)) { 
        		$data=split("=",$where);
            	$query.=" WHERE $data[0]=? ";
            } else {
            	$query.=$where;
            }
        }
        $res="\n<select class=form name=\"$label\" size=\"$size\">";

        // inicjuj tablice, w ktorej beda zapamietane poszczegolne wyniki zapytania SQL 
        $tab_result=array();

        if($opt != "" ) {
            $data1=split("=",$opt);
            $res.="<option value=\"$data1[0]\">".$data1[1]."\n"; 
        }
        $prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
            if($where != "" ) {
                if(ereg('where',$where)) { 
					$data=split("=",$where);
					$db->QuerySetText($prepared_query,1,$data[1]);
                }
            }
            $result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
				if($num_rows >0 ) {

                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $name1=$db->FetchResult($result,$i,$name);
                        $sel=""; 
                        if ($code1 == $default){
                            $sel="selected";
                        }
                        $res.="<option $sel value=\"$code1\">".$name1."\n"; 
                        $tab_result[$name1]=$code1;
                    } // end for

                    $res.="</select>\n";
				} else $res="";

			} else die ($db->Error());
		} else die ($db->Error());

        $this->result=&$tab_result;

        return $res;
	} // end sql_select_select()

    /**
     * Funkcja selectujaca  z bazy danych dwie wartosci i tworzaca strukture <select><option></option></select>
     * Przyk³ad: $data=$database->sql_select_select("table","label","code","name","default","where");
     *
     * @param  string $table   nazwa tabeli
     * @param  string $label   wartosc pola name w poleceniu <select name=$label>  
     * @param  string $code    pole ktore bedzie wpisane w <option value=$code> (pole z tabeli $table)
     * @param  string $name    pole ktore bedzie wpisane w <option value=$code> $name </option> (pole z tabeli $table) 
     * @param  string $default domyslna wartosc ( ta ktora ma sie pokazac w okienku ) 
     * @param  string $where   warunek sql
     * @return global string   $this->result wynik zapytania w postaci tablicy PHP array("nazwa"=>"wartosc",...) (m@sote.pl 20030523)
     * @return string $res     gotowa do wyswietlenia struktura <select><option></option></select> 
     */
	function sql_select_select1($table,$label,$code,$name,$name_add,$default='',$where='',$opt='',$size=1) {
        global $db;


        $query="SELECT $code,$name,$name_add FROM $table";
        if($where != "" ) {
            if(ereg('where',$where)) { 
        		$data=split("=",$where);
            	$query.=" WHERE $data[0]=? ";
            } else {
            	$query.=$where;
            }
        }
        $res="\n<select class=form name=\"$label\" size=\"$size\">";

        // inicjuj tablice, w ktorej beda zapamietane poszczegolne wyniki zapytania SQL 
        $tab_result=array();

        if($opt != "" ) {
            $data1=split("=",$opt);
            $res.="<option value=\"$data1[0]\">".$data1[1]."\n"; 
        }
        $prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
            if($where != "" ) {
                if(ereg('where',$where)) { 
					$data=split("=",$where);
					$db->QuerySetText($prepared_query,1,$data[1]);
                }
            }
            $result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
				if($num_rows >0 ) {

                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $name1=$db->FetchResult($result,$i,$name);
                        $name_add1=$db->FetchResult($result,$i,$name_add);
                        $sel=""; 
                        if ($code1 == $default){
                            $sel="selected";
                        }
                        $res.="<option $sel value=\"$code1\">".$name1."->".$name_add1."\n"; 
                        $tab_result[$name1]=$code1;
                    } // end for

                    $res.="</select>\n";
				} else $res="";

			} else die ($db->Error());
		} else die ($db->Error());

        $this->result=&$tab_result;

        return $res;
	} // end sql_select_select()

/**
     * Funkcja selectujaca  z bazy danych dwie wartosci i tworzaca strukture <select><option></option></select>
     * Przyk³ad: $data=$database->sql_select_select("table","label","code","name","default","where");
     *
     * @param  string $table   nazwa tabeli
     * @param  string $label   wartosc pola name w poleceniu <select name=$label>  
     * @param  string $code    pole ktore bedzie wpisane w <option value=$code> (pole z tabeli $table)
     * @param  string $name    pole ktore bedzie wpisane w <option value=$code> $name </option> (pole z tabeli $table) 
     * @param  string $default domyslna wartosc ( ta ktora ma sie pokazac w okienku ) 
     * @param  string $where   warunek sql
     * @return global string   $this->result wynik zapytania w postaci tablicy PHP array("nazwa"=>"wartosc",...) (m@sote.pl 20030523)
     * @return string $res     gotowa do wyswietlenia struktura <select><option></option></select> 
     */
	function sql_select_select2($table,$label,$code,$name,$default='',$where='',$opt='',$options='',$size=1) {
        global $db;
		global $config;
		global $lang;

        $query="SELECT $code,$name FROM $table";
        if($where != "" ) {
            if(ereg('where',$where)) { 
        		$data=split("=",$where);
            	$query.=" WHERE $data[0]=? ";
            } else {
            	$query.=$where;
            }
        }
        $res="\n<select class=form name=\"$label\" size=\"$size\">";

        // inicjuj tablice, w ktorej beda zapamietane poszczegolne wyniki zapytania SQL 
        $tab_result=array();

        if($opt != "" ) {
            $data1=split("=",$opt);
            $res.="<option value=\"$data1[0]\">".$data1[1]."\n"; 
        }
        if(!empty($options)) {
        	$query.=$options;
        }
        //print $query;
        $prepared_query=$db->PrepareQuery($query);
		if ($prepared_query) {
            if($where != "" ) {
                if(ereg('where',$where)) { 
					$data=split("=",$where);
					$db->QuerySetText($prepared_query,1,$data[1]);
                }
            }
            $result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
				if($num_rows >0 ) {

                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $name1=$db->FetchResult($result,$i,$name);
                        $sel=""; 
                        if ($code1 == $default){
                            $sel="selected";
          	            }
                        if ($config->base_lang!=$config->lang) {
		    				$name1=LangFunctions::f_translate($name1);
						}    
                        $res.="<option $sel value=\"$code1\">".$name1."\n"; 
                        $tab_result[$name1]=$code1;
                    } // end for

                    $res.="</select>\n";
				} else $res="";

			} else die ($db->Error());
		} else die ($db->Error());

        $this->result=&$tab_result;

        return $res;
	} // end sql_select_select()

    /**
     * Funkcja selectujaca  z bazy danych dwie wartosci i tworzaca strukture <select><option></option></select>
     * Przyk³ad: $data=$database->sql_select_select("table","label","code","name","default","where");
     *
     * @param  string $table   nazwa tabeli
     * @param  string $label   wartosc pola name w poleceniu <select name=$label>  
     * @param  string $code    pole ktore bedzie wpisane w <option value=$code> (pole z tabeli $table)
     * @param  string $name    pole ktore bedzie wpisane w <option value=$code> $name </option> (pole z tabeli $table) 
     * @param  string $default domyslna wartosc ( ta ktora ma sie pokazac w okienku ) 
     * @param  string $where   warunek sql
     * @return global string   $this->result wynik zapytania w postaci tablicy PHP array("nazwa"=>"wartosc",...) (m@sote.pl 20030523)
     * @return string $res     gotowa do wyswietlenia struktura <select><option></option></select> 
     */
	function sql_select_multiple($table,$label,$code,$name,$default='',$where='',$opt='',$size=1,$select=array()) {
        global $db;


        $query="SELECT $code,$name FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
            
        }
        $res="\n<select class=form name=\"$label\" size=\"$size\" multiple>";

        // inicjuj tablice, w ktorej beda zapamietane poszczegolne wyniki zapytania SQL 
        $tab_result=array();

        if($opt != "" ) {
            $data1=split("=",$opt);
            $res.="<option value=\"$data1[0]\">".$data1[1]."\n"; 
        }

        $prepared_query=$db->PrepareQuery($query);
		//print $query;
        if ($prepared_query) {
            if($where != "" ) {
                $data=split("=",$where);
				$db->QuerySetText($prepared_query,1,$data[1]);
            }

            $result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
				if($num_rows >0 ) {

                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $name1=$db->FetchResult($result,$i,$name);
                        $sel=""; 
						if(!empty($select)) {
                        	foreach($select as $key=>$value) {
			  					if ($code1 == $value){
                            		$sel="selected";
			  					}
							}
						}	
                        $res.="<option $sel value=\"$code1\">".$name1."\n"; 
                        $tab_result[$name1]=$code1;
                    } // end for

                    $res.="</select>\n";
				} else $res="";

			} else die ($db->Error());
		} else die ($db->Error());

        $this->result=&$tab_result;

        return $res;
	} // end sql_select_select()

     /**
     * Funkcja selectujaca  z bazy danych dwie wartosci i tworzaca strukture <select><option></option></select>
     * Przyk³ad: $data=$database->sql_select_select("table","label","code","name","default","where");
     *
     * @param  string $table   nazwa tabeli
     * @param  string $label   wartosc pola name w poleceniu <select name=$label>  
     * @param  string $code    pole ktore bedzie wpisane w <option value=$code> (pole z tabeli $table)
     * @param  string $name    pole ktore bedzie wpisane w <option value=$code> $name </option> (pole z tabeli $table) 
     * @param  string $default domyslna wartosc ( ta ktora ma sie pokazac w okienku ) 
     * @param  string $where   warunek sql
     * @return global string   $this->result wynik zapytania w postaci tablicy PHP array("nazwa"=>"wartosc",...) (m@sote.pl 20030523)
     * @return string $res     gotowa do wyswietlenia struktura <select><option></option></select> 
     */
	function sql_select_multiple1($table,$label,$code,$name,$name_add,$default='',$where='',$opt='',$size=1,$select=array()) {
        global $db;


        $query="SELECT $code,$name,$name_add FROM $table";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
            
        }
        $res="\n<select class=form name=\"$label\" size=\"$size\" multiple>";

        // inicjuj tablice, w ktorej beda zapamietane poszczegolne wyniki zapytania SQL 
        $tab_result=array();

        if($opt != "" ) {
            $data1=split("=",$opt);
            $res.="<option value=\"$data1[0]\">".$data1[1]."\n"; 
        }

        $prepared_query=$db->PrepareQuery($query);
		//print $query;
        if ($prepared_query) {
            if($where != "" ) {
                $data=split("=",$where);
				$db->QuerySetText($prepared_query,1,$data[1]);
            }

            $result=$db->ExecuteQuery($prepared_query);
			if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
				if($num_rows >0 ) {

                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$code);
                        $name1=$db->FetchResult($result,$i,$name);
                        $name_add1=$db->FetchResult($result,$i,$name_add);
                        $sel=""; 
						foreach($select as $key=>$value) {
			  				if ($code1 == $value){
                            	$sel="selected";
			  				}
						}
                        $res.="<option $sel value=\"$code1\">".$name1."->".$name_add1."\n"; 
                        $tab_result[$name1]=$code1;
                    } // end for

                    $res.="</select>\n";
				} else $res="";

			} else die ($db->Error());
		} else die ($db->Error());

        $this->result=&$tab_result;

        return $res;
	} // end sql_select_select()
	
  /**
   * Funkcja selectuje z tabeli bazy danych jedna wartosc 
   * Przyk³ad: $data=$database->sql_select("code","table","where");
   *
   * @param  string $code  nazwa kolumny, 
   * @param  string $table nazwa tabeli
   * @param  string $where warunek postaci data=data
   * @return string $code1 dana z bazy danych - wynik zapytania SQL
   */
   function sql_select_show($code,$field='') {
        global $db;
        
        $ret_table=array();
        $query=$code;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    for($i=0; $i< $num_rows; $i++) {    
                        $code1=$db->FetchResult($result,$i,$field);
                        array_push ($ret_table, $code1);
                   }
                } else {
                    $code1="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return @$ret_table;
    }


  /**
   * Funkcja selectuje z tabeli bazy danych jedna wartosc 
   * Przyk³ad: $data=$database->sql_select("code","table","where");
   *
   * @param  string $code  nazwa kolumny, 
   * @param  string $table nazwa tabeli
   * @param  string $where warunek postaci data=data
   * @return string $code1 dana z bazy danych - wynik zapytania SQL
   */
    function sql_select_like($code,$table,$where='') {
        global $db;
        
        $query="SELECT $code FROM $table";
        if($where != "" ) {
            $query.=" WHERE ".$where;
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows >0 ) {
                    $code1=$db->FetchResult($result,0,$code);
                } else {
                    $code="";
                }  
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return @$code1;
    }
	    /**
     * Funkcja selectujaca  z bazy danych kilka pol
     * Przyk-B³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql
     * @return array  $ret_table tablica z wartosciami
     */
    function sql_select_multi_array3($records,$table,$where='',$option='') {
        global $db;

        $ret_table=array();
        $ret_table1=array();
        $str="";
        foreach($records as $value){
            $str.=$value.",";
        }
        reset($records);
        $str=ereg_replace(",$","",$str);
        $query="SELECT $str FROM $table ";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        if($option != '') {
            $query.=$option;
        }
        //print $query;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);

            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if($num_rows == 1 ) {
                    foreach($records as $value){
                        $code1=$db->FetchResult($result,0,$value);
                        $ret_table = $ret_table+array($value=>$code1);
                    }
                } elseif($num_rows > 1) {
                    for($i=0; $i< $num_rows; $i++) {
                        $ret_table1=array();
                        foreach($records as $value){
                            $code1=$db->FetchResult($result,$i,$value);
                            $ret_table1 = $ret_table1+array($value=>$code1);
                        }
                        array_push ($ret_table, $ret_table1);
                    }
                }
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        return $ret_table;
    }
   
    /**
     * Funkcja selectujaca  z bazy danych kilka pol
     * Przyk-B³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql
     * @return array  $ret_table tablica z wartosciami
     */
     function sql_select_multi_array4($records,$table,$where='',$opt='',$db2='') {
        global $db;

        if(!empty($db2)) {
            $db_tmp=$db;
            $db=$db2;
        }
        $ret_table=array();
        $ret_table1=array();
        $str="";
        if(is_array($records)) {
            foreach($records as $value){
                $str.=$value.",";
            }
            reset($records);
            $str=ereg_replace(",$","",$str);
        } else {
            $str="*";
        }
        $query="SELECT $str FROM $table ";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        if($opt != '') {
            $query.=$opt;
        }
        //print $query;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);

            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                $db->GetColumnNames($result,$column_name);
                for($i=0; $i< $num_rows; $i++) {
                    $ret_table1=array();
                    if(is_array($records)) {
                        foreach($records as $value){
                            $code1=$db->FetchResult($result,$i,$value);
                            $ret_table1 = $ret_table1+array($value=>$code1);
                        }
                    } else {
                        foreach($column_name as $key=>$value){
                            $code1=$db->FetchResult($result,$i,$key);
                            $ret_table1 = $ret_table1+array($key=>$code1);
                        }
                    }
                    array_push ($ret_table, $ret_table1);
                }
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        if(!empty($db2)) {
            $db=$db_tmp;
        }
        return $ret_table;
    }
    /**
     * Funkcja selectujaca  z bazy danych kilka pol
     * Przyk-B³ad: $data=$database->sql_select_multi_array(array("pole1","pole2","pole3"),"table","where");
     *
     * @param  array  $records   tablica pol ktore chcemy wyciagnac z bazy danych
     * @param  string $table     nazwa tabeli
     * @param  string $where     warunek sql
     * @return array  $ret_table tablica z wartosciami
     */
    function sql_select_multi_array7($records,$table,$where='',$opt='',$db2='',$keys='') {
        global $db;

        if(!empty($db2)) {
            $db_tmp=$db;
            $db=$db2;
        }
        $ret_table=array();
        $ret_table1=array();
        $str="";
        if(is_array($records)) {
            foreach($records as $value){
                $str.=$value.",";
            }
            reset($records);
            $str=ereg_replace(",$","",$str);
        } else {
            $str="*";
        }
        $query="SELECT $str FROM $table ";
        if($where != "" ) {
            $data=split("=",$where);
            $query.=" WHERE $data[0]=? ";
        }
        if($opt != '') {
            $query.=$opt;
        }
        //print $query;
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            if($where != "" ) {
                $db->QuerySetText($prepared_query,1,$data[1]);
            }
            $result=$db->ExecuteQuery($prepared_query);

            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                $db->GetColumnNames($result,$column_name);
                for($i=0; $i< $num_rows; $i++) {
                    $ret_table1=array();
                    if(is_array($records)) {
                        foreach($records as $value){
                            $code1=$db->FetchResult($result,$i,$value);
                            $ret_table1 = $ret_table1+array($value=>$code1);
                        }
                    } else {
                        foreach($column_name as $key=>$value){
                            $code1=$db->FetchResult($result,$i,$key);
                            $ret_table1 = $ret_table1+array($key=>$code1);
                        }
                    }
                    $ret_table=$ret_table+array($ret_table1['user_id']=>$ret_table1);
                }
            } else {
                die ($db->Error());
            }
        } else {
            die ($db->Error());
        }
        if(!empty($db2)) {
            $db=$db_tmp;
        }
        return $ret_table;
    }

} // end class my_Database

global $database;
$database = new my_Database;	  			

?>

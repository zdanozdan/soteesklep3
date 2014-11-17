<?php
/**
 * Klasa ulatwiajca dostep do bazy danych z poziomu Metabase i wyciagania czesto uzywanych struktur danych
 * Obsluga podstawowych operacji bazodanowych.
 * 
 * VERSION 1.1
 *
 * @author      m@sote.pl based on metabase.inc (rdiak@sote.pl)
 * @version     $Id: MetabaseData.php,v 1.22 2005/03/29 12:20:00 lechu Exp $ 
 * @package     soteesklep
 * @tutorial    CVS->doc->_devel/_metabase
 */

define ("MDB_DATA_MAX_SPLIT",1000);
define ("MDB_DATA_DEBUG",    0   );
define ("MDB_DATA_LAST",   "-2"  );          // wartosc umowna
define ("MDB_DATA_FIRST",  "-1"  );          // wartosc umowna

class MetabaseData { 

    var $db;                  // @var object uchwyt bazy danych Metabase
    var $_error_action="die"; // @var string co sysetm ma robic, w przypadku bledu Metabase

    /**
     * Konstruktor
     *
     * @return none
     */
    function MetabaseData(&$db) {        
        $this->db=&$db;
        return(0);
    } // end MetabaseDataObject()

    /**
     * SELECT: Odczytaj dane z bazy
     * Np. $result=$this->query_select($columns,"main","id=? AND category1=?",array($id=>"int",$category1"=>"text"),"ORDER BY name");
     * 
     * @param  string $columns co selectujemy z tabeli np. "id,name"
     * @param  string $table   nazwa tabeli
     * @param  string $where   opcje WHERE z zapytania SQL np. "id=?, name=?"
     * @param  array  $data    parametry zapytania SQL podstawiane np. do WHERE
     * @param  string $other   pozostala czesc zapytania SQL
     * @return array  $result  dane z bazy danych 
     *
     * @access public
     */
    function query_select($columns,$table,$where=1,$data=array(), $other='') {
        $columns=addslashes($columns);
        $table=addslashes($table);
        $other=addslashes($other);
        $query="SELECT $columns FROM $table WHERE $where $other";                                
        $prepared_query=$this->db->PrepareQuery($query);
        if ($prepared_query) {             
            if (sizeof($data)>0) {                
                $this->_bind($prepared_query,$data);
                $result=$this->db->ExecuteQuery($prepared_query);                
            } else {
                $result=$this->db->Query($query);
            }

            if ($result!=0) {
                $this->num_rows=$this->db->NumberOfRows($result);            
            } else $this->_error();                
        } else die ($this->_error());
            
        return $result;
    } // end query_select()

    /**
     * Odczytaj dane z bazy 1 wiersz, uproszeczenie wywolania $this->query_select() i $this->read()
     * 
     * @param  string $columns co selectujemy z tabeli np. "id,name"
     * @param  string $table   nazwa tabeli
     * @param  string $where   opcje WHERE z zapytania SQL np. "id=?, name=?"
     * @param  array  $data    parametry zapytania SQL podstawiane np. do WHERE
     * @param  string $other   pozostala czesc zapytania SQL
     * @param  string $return  okreslenie rodzaju zwracanych danych [auto|array], dot. 1 rekordu
     *                         w wyniku zapytania, czy dane maja byc zwracane w postaci
     *                         [0]=>array(...dane...), czy array(...dane)
     * @return string|array    string-jesli zapytanie jest o 1 pole 
     *                         i wynikiem jest 1 wiersz, tablica-jesli zwracanych jest wiecej danych    
     *                             
     * @public
     */
    function select($columns,$table,$where=1,$data=array(), $other='',$return="auto") {           
        $result=$this->query_select($columns,$table,$where,$data,$other);
        $this->result=&$result;
        $names=split(",",$columns,MDB_DATA_MAX_SPLIT);
        if (($this->num_rows==1) && ($return=="auto")) {
            $data=$this->read($result,$names,0);
            // jesli zapytanie jest o 1 pole, to zwroc bezposrednia wartosc tego pola jako string
            if (! ereg(",",$columns)) $data=$data[0][$columns];
            else $data=$data[0];
        } elseif ($this->num_rows>=1) {
            $data=array();
            for ($i=0;$i<$this->num_rows;$i++) {
                $read=$this->read($result,$names,$i);
                $data[$i]=$read[$i];
            }
        } else return (0);        

        return $data;
    } // end select()

    /**
     * Pobierz dane z wyniku zapytania SQL
     *
     * @param  array  $result dane z bazy danych 
     * @param  array  $names  nazwy pol z zapytania SQL, ktore beda odczytywane
     * @param  string $rows   ktore wiersze pobrac z bazy danych 1; 1,3,4;  1-3; FIRST; LAST
     * @return array  dane z zadanych wierszy z tabeli np. dla row="1,3" -> $data[1]=array("id"=>"1","name"=>"test"), $data[3]=...
     * 
     * @access public
     */
    function read($result,$names=array(),$rows) {
        $data=array();

        if ($rows==-1) $rows=0;
        if ($rows==-2)  $rows=$this->num_rows-1;

        // $rows: 1
        if (ereg("^[0-9]+$",$rows)) {
            $data[$rows]=$this->_fetch($result,$names,$rows);
        }
        
        // $rows: 2-5
        if (ereg("^[0-9]+-[0-9]+$",$rows)) {
            $trows=split("-",$rows,2);
            $from=$trows[0];$to=$trows[1];
            for ($i=$from;$i<=$to;$i++) {
                $data[$i]=$this->_fetch($result,$names,$rows); 
            }
        }

        // $rows: 1,2,3
        if (ereg("^[0-9,]+$",$rows)) {
            $trows=split(",",$rows,MDB_DATA_MAX_SPLIT);
            reset($trows);
            foreach ($trows as $row) {
                $data[$row]=$this->_fetch($result,$names,$rows);
            }
        }

        return $data;
    } // end read()

    /**
     * Odczytaj dane z wyniku zapytania dla danego wiersza
     *
     * @param  array $result dane z bazy danych 
     * @param  array $names lista column z tabeli
     * @param  int   $row   numwer wiersza wyniku zapytania
     * @return array tablica z danymi z wiersza columna1=>wartosc, columna2=>wartosc (wg $names) itd. 
     *
     * @access private
     */
    function _fetch($result,$names,$row=0) {
        reset($names);
        foreach ($names as $name) {
            $data[$name]=$this->db->FetchResult($result,$row,$name);
        } // end foreach
        return $data;
    } // end _fetch()

    /**
     * Podstaw parametry do zapytania SQL
     *
     * @param  int   $prepared_query id zapytania SQL
     * @param  array $data           tablica z danymi '1,wartosc'=>typ (text,int,float)
     *                               1, oznacza numer parametru, dalej jest 'wartosc' parametru
     * @return none  podstawiane dane sa ustawiane w obiekcie $this->db
     *
     * @access private
     */
    function _bind($prepared_query,$data) {                
        $i=1;
        if (! is_array($data)) return;        
        while (list($val,$type) = each($data)) {
            if (ereg("^[0-9]+,",$val)) {                
                $tab=split(",",$val,2);
                $val=$tab[1];                                
            }
                 
            switch ($type) {
            case "text":
                $this->db->QuerySetText($prepared_query,$i,$val);
            break;
            case "int":
                $this->db->QuerySetInteger($prepared_query,$i,$val);
            break;   
            case "float":
                $this->db->QuerySetFloat($prepared_query,$i,$val);
            break; 
            default: 
                $this->db->QuerySetText($prepared_query,$i,$val);
            break;
            } // end switch

            $i++;          // next bind param
        } // end while 
               
        return(0);
    } // end _bind()

    /**
     * UPDATE: Aktualizuj dane w bazie
     * 
     * @param  string $table   nazwa tabeli
     * @param  array  $set     modyfikowane pola np. "name=", producer=?" wartosc SET zapytania SQL
     * @param  string $where   opcje WHERE z zapytania SQL np. "id=?, name=?"
     * @param  array  $data    parametry zapytania SQL podstawiane np. do WHERE czy SET
     * @return bool   true     dane zaktualizowane, false w p.w.
     *
     * @access public
     */
    function update($table,$set,$where=1,$data=array()) {
        $table=addslashes($table);
        $query="UPDATE $table SET $set WHERE $where";                        
        
        $prepared_query=$this->db->PrepareQuery($query);
        if ($prepared_query) {            
            if (! empty($data)) {
                $this->_bind($prepared_query,$data);
                $result=$this->db->ExecuteQuery($prepared_query);                
            } else $result=$this->db->Query($query);

            if ($result!=0) {
                return true;
            } else $this->_error();                

        } else die ($this->_error());

        return false;
    } // end update()

    /**
     * INSERT: Dodaj wpis do tabeli
     * 
     * @param  string $table   nazwa tabeli
     * @param  string $columns pola do ktorych podstawiamy dane np. "name,producer"
     * @param  string $values  wartosci podstawiane np. "?,?" lub "test,?" itp.
     * @param  array  $data    parametry zapytania SQL podstawiane np. $values
     * @return bool   true     wpis dodany, false w p.w.
     *
     * @access public
     */
    function insert($table,$columns,$values,$data=array()) {        
        $table=addslashes($table);
        $columns=addslashes($columns);
        $query="INSERT INTO $table ($columns) VALUES ($values)";
        $prepared_query=$this->db->PrepareQuery($query);
        if ($prepared_query) {
            if (! empty($data)) {
                $this->_bind($prepared_query,$data);
                $result=$this->db->ExecuteQuery($prepared_query);                
            } else $result=$this->db->Query($query);

            if ($result!=0) {
                return true;
            } else $this->_error();                

        } else die ($this->_error());

        return false;
    } // end insert()

    /**
     * DELETE: Usun dane z tabeli
     * 
     * @param  string $table   nazwa tabeli
     * @param  string $where   opcje WHERE z zapytania SQL np. "id=?, name=?"
     * @param  array  $data    parametry zapytania SQL podstawiane np. do WHERE czy SET
     * @return bool   true     dane zaktualizowane, false w p.w.
     *
     * @access public
     */
    function delete($table,$where=1,$data=array()) {
        $table=addslashes($table);
        $query="DELETE FROM $table WHERE $where";
        $prepared_query=$this->db->PrepareQuery($query);
        if ($prepared_query) {
            if (! empty($data)) {
                $this->_bind($prepared_query,$data);
                $result=$this->db->ExecuteQuery($prepared_query);                
            } else $result=$this->db->Query($query);

            if ($result!=0) {
                return true;
            } else $this->_error();                
            
        } else die ($this->_error());
        
        return false;
    } // end delete()

    /**
     * resetId: Wyzeruj AUTO_INCREMENT dla podanej tabeli
     * 
     * @param  string $table   nazwa tabeli
     * @return bool   true     dane zaktualizowane, false w p.w.
     *
     * @access public
     */
    function resetId($table) {
        $table=addslashes($table);
        $query="ALTER TABLE $table AUTO_INCREMENT=0";
        $prepared_query=$this->db->PrepareQuery($query);
        if ($prepared_query) {
            if (! empty($data)) {
                $this->_bind($prepared_query,$data);
                $result=$this->db->ExecuteQuery($prepared_query);                
            } else $result=$this->db->Query($query);

            if ($result!=0) {
                return true;
            } else $this->_error();                
            
        } else die ($this->_error());
        
        return false;
    } // end resetId()
    
    
    /**
     * Obsluga bledow Metabase (wrapper)
     *
     * @access private
     */
    function _error() {
        if (($this->_error_action=="die") || (MDB_DATA_DEBUG>0)) die ($this->db->Error());
        return (0);
    } // end error()

} // end class MetabaseData

?>
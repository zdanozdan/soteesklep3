<?php
/**
* Klasa g³ówna obslugi importu danych z innych porgramów.
*
* @author  m@sote.pl
* @version $Id: importshop_main.inc.php,v 1.11 2006/01/25 16:49:41 lukasz Exp $
* @package importshop
*/

/**
* ImportShop
*/
require_once ("./include/importshop.inc.php");

/**
* Klasa g³ówna obslugi importu danych z innych porgramów.
* @package importshop
*/
class ImportShopMain {

    /**
    * Skryt wykonuj±cy import danych.
    */
    var $action="import.php";

    /*
    * Zapamiêtane warto¶æi dla danego rekordu
    */
    var $values=array();

    /**
    * Lista tabel do aktualizacji. Informacja.
    */
    function tablesInfo() {
        global $lang;
        print "<p /><font color=\"red\"><b>$lang->importshop_warning_delete</b></font><p />\n";
        print "<p />".$lang->importshop_tables_info."<p />\n";
        reset($this->config);
        foreach ($this->config as $key=>$val) {
            print "<li>$key</li>\n";
        }
        $this->_startForm();
        return;
    } // end _tablesInfo()

    /**
    * Formularz wywo³ania startu importu
    * 
    * @access protected
    */
    function _startForm() {
        global $lang,$_REQUEST;
        print "<p />\n";
        print "<form action=\"$this->action\" method=POST target=\"import\">\n";
        print "<input type=\"hidden\" name=\"item[type]\" value=\"$this->name\">\n";
        print "<input type=\"hidden\" name=\"item[host]\" value=\"".$_REQUEST['item']['host']."\">\n";
        print "<input type=\"hidden\" name=\"item[database]\" value=\"".$_REQUEST['item']['database']."\">\n";
        print "<input type=\"hidden\" name=\"item[port]\" value=\"".$_REQUEST['item']['port']."\">\n";
        print "<input type=\"hidden\" name=\"item[login]\" value=\"".$_REQUEST['item']['login']."\">\n";
        print "<input type=\"hidden\" name=\"item[password]\" value=\"".$_REQUEST['item']['password']."\">\n";
        print "<input type=\"submit\" value=\"$lang->importshop_submit\" onclick=\"window.open('', 'import', 'width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0')\">\n";
        print "</form>\n";
    } // end _startForm()

    /**
    * Ustanów 2 po³±czenie z baz± danych.
    *
    * @return mixed uchwyt bazy danych
    */
    function connectDB2() {
        global $stream,$_REQUEST,$db2,$import_shop;

        $import_shop =& new ImportShop();
        $import_shop->_host=$_REQUEST['item']['host'];
        $import_shop->_port=$_REQUEST['item']['port'];
        $import_shop->_login=$_REQUEST['item']['login'];
        $import_shop->_password=$_REQUEST['item']['password'];
        $import_shop->_dbname=$_REQUEST['item']['database'];
        $import_shop->connectDB();
        $db2=&$import_shop->db2;

        return $db2;
    } // end connectDB2()

    /**
    * Wykonaj import
    */
    function goImport() {
        global $db2;
        $this->db2=&$this->connectDB2();

        reset($this->config);
        foreach ($this->config as $table=>$data) {
            $this->_importTable($table,$data);
        }

        return true;
    } // end goImport()

    /**
    * Importuj dane do wskazanej tabeli.
    *
    * @param string $table nazwa tabeli, do której s± importowane dane
    * @param mixed  $data  dane dot. metody transformacji danych do tabeli
    *
    * @access private
    * @return void
    */
    function _importTable($table,$data) {
        global $db,$db2,$db_copy,$lang;

        $s_key=$data['key'];        // klucz tabeli ¼ród³owej (source key)
        $s_table=$data['table'];    // bazwa tabeli ¼ród³owej
        $s_data=$data['data'];      // opis co robimy z jakimi polami - tablica

        $db_copy=$this->db2;
        $db2=&$this->db2;

        print "<li>$lang->importshop_table_info: $table</li>\n";

        // usuñ rekordy zenowej tabeli
        $query="DELETE FROM $table";
        $result=$db->query($query);
        if ($result!=0) {
            // dane usuniêcie
            // @todo wykonanie kopii
        } else die ($db->error());

        $query2="SELECT * FROM $s_table ORDER BY $s_key";
        $prepared_query2=$db2->prepareQuery($query2);
        if ($prepared_query2) {
            $result2=$db2->executeQuery($prepared_query2);
            if ($result2!=0) {
                $num_rows2=$db2->numberOfRows($result2);
                for ($i=0;$i<$num_rows2;$i++) {
                    $r=$this->_importRecord($result2,$i,$s_key,$s_data,$table);
                }
            } else print $db2->error()."<br />\n";
        } else {
            // prawdopodobnie nie ma wskazanej domeny w wersji programu
            // config moze odwo³ywaæ siê do nowszej wersji
            print $db->error()."<br />\n";
        }

        $this->db2=$db_copy; // wyzerowanie ostatniego zapytania. zwolnienie pamiêcie

        return;
    } // end _importTable()

    /**
    * Importuj dane z 1 rekordu do nowej tabeli.
    *
    * @param mixed  &$result wynik zapytania z bazy danych
    * @param int    $row    numer wiersza z wyniku zapytania
    * @param string $s_key  klucz tabeli ¼ród³owej (source key)
    * @param array  &$s_data opis co robimy z jakimi polami - tablica
    * @param string $table nazwa docelowej tabeli
    *
    * @access private
    * @return array tablica z danymi z danego recordu np. array("key"=>"1","name"=>"Monitor",...)
    */
    function _importRecord(&$result2,$row2,$s_key,&$s_data,$table) {
        global $db2,$stream,$db;

        $db2=&$this->db2;

        $r=array();   // SELECT result ze starej tabeli
        $new=array(); // tablica z danymi przetworzoymi, które bêd± wsatwiane do nowej tabeli array("pole"=>"warto¶æ")
        $r['key']=$db2->fetchResult($result2,$row2,$s_key);
        // odczytaj wszystkie pola ze starej tablicy
        reset($s_data);
        foreach ($s_data as $field=>$f_data) {
            $r[$field]=$db2->fetchResult($result2,$row2,$field);
            $this->values[$field]=$r[$field];

            // sprawd¼ czy warto¶ci± jest tablica czy string
            if (! is_array($s_data[$field])) {
                // przypisanie 1:1 np. "photo"=>"photo"
                $new[$s_data[$field]]=$r[$field];
            } else {
                /**
                 * przypisanie postaci
                 
                  "name"=>array(
				  	            "function"=>"changeFieldName",
				  	            "field"=>"name_L0",
				  		        )
                */

                $func=$s_data[$field]['function'];
                if (! empty($func)) {
                    if (! empty($s_data[$field]['field'])) {
                        $new[$s_data[$field]['field']]=$this->$func($r[$field]);
                    } else {
                        $new[$field]=$this->$func($r[$field]);
                    }
                } else {
                    if (! empty($s_data[$field]['field'])) {
                        $new[$s_data[$field]['field']]=$r[$field];
                    } else {
                        $new[$field]=$r[$field];
                    }

                } // end if (! empty($func))

            }

        }

        // generuj Query INSERT do abzy danych
        $query=$this->_recordQuery($table,$new);
        $result=$db->query($query);
        if ($result!=0) {
            $stream->line_blue();
        } else {
//        	print "<pre>";
//        	print_r ($db);
//        	print "</pre>";
            $stream->line_red();            
            // nie uda³o siê za³adowaæ rekordu
            // @todo logowanie b³êdu
        }

        return $new;
    } // end _importrecord()

    /**
    * Generuj insert do bazy danych na podstawie odczytanych warto¶ci i definicji tabeli
    *
    * @param string $table nazwa tabeli docelowej, do której bêd± dodawane dane
    * @param array  $new
    *
    * @access private
    * @return string SQL
    */
    function _recordQuery($table,$new) {
        $query="INSERT INTO $table (";
        reset($new);
        foreach ($new as $key=>$val) {
            $query.="$key,";
        }
        $query=substr($query,0,strlen($query)-1);
        $query.=") VALUES (";
        reset($new);
        foreach ($new as $key=>$val) {
            $val=addslashes($val);
            $query.="'$val',";
        }
        $query=substr($query,0,strlen($query)-1);
        $query.=")";
        return $query;
    } // end _recordQuery()

    // ---------------------------------- FUNCKJE TRANSFORMUJ¡CE ----------------------

    /**
    * Ustaw warto¶æ pola na 1 lub 0
    */
    function boolSet01($value) {
        if ($value!=1) return 0;
        else return 1;
    } // end boolSet01()

    /**
    * Ustaw warto¶æ pola na 1
    */
    function boolSet1() {
        return 1;
    } // end boolSet1()

    /**
    * Ustaw warto¶æ pola na 0
    */
    function boolSet0() {
        return 0;
    } // end boolSet0()

} // end class ImportShopMain
?>
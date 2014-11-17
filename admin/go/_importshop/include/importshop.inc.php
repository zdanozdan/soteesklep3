<?php
/**
 * Klasa do importow danych z innych systemow sprzedazy
 *
 * @author rdiak@sote.pl
 * @version $Id: importshop.inc.php,v 1.8 2006/01/25 09:53:12 lukasz Exp $
 * @package    admin
 */


/**
 * Klasa ImportShop
 *
 * @package admin_users
 * @subpackage admin
 */

include_once("include/metabase.inc");
class ImportShop {

    var $_type='';				// typ konwersji
    var $_host='';				// host bazy danych
    var $_dbname='';			// nazwa bazy danych
    var $_dbtype='mysql';		// typ bazy danych
    var $_port='';				// port
    var $_login='';				// login uzytkownika
    var $_password='';			// haslo uzytkownika
    var $_db2='';				// polaczenie z druga baza danych
    var $_convert='';			// dostepne systemy konwersji
    var $_struct='';			// plik konfiguracyjny
    var $_tables=array();		// lista tabel w bazie danych z ktorej bedziemy brali dane

    /**
    * Lista plików z ./include/class które mo¿na odcyztywaæ w liscie programów do importu
    */
    var $class_allowed=array("soteesklep30.inc.php","my.inc.php","easyshop.inc.php","soteesklep25.inc.php");

    /**
    * Konstruktor obiektu
    *
    */
    function ImportShop() {
        return true;
    } // end func ImportShop

    /**
    * Wykonaj import
    *
    * @author rdiak@sote.pl m@sote.pl
    * @return bool
    */
    function action() {
        global $lang;
        global $_REQUEST;

        // jesli paramtry sa prawidlowe
        if($this->_getParam()) {
            if($this->connectDb()) {

                require_once ("./include/importshop_main.inc.php");
                $dir=dirname(__FILE__);
                $class_file=$_REQUEST['item']['type'].".inc.php";
                $file_class="$dir/class/$class_file";
                if (file_exists($file_class)) {
                    /**
                    * Obs³uga importu ze wskazanego oprogramowania
                    */                    
                    require_once ("./include/class/$class_file");
                    $isoft =& new $__import_class();
                    $isoft->tablesInfo();
                } else {
                    die ("Unknown class ./include/class/$class_file");
                }

                return true;
            } else {
                return false;
            }
        }
        return false;
    } // end func action()

    /**
    * Zaladuj odpowiedni plik konfiguracji i pokaz tabele ktore wymagaja zmiany
    *
    */
    function _showTables() {
        print "<pre>";
        print_r($this->_tables);
        print "</pre>";
    } // end func _showTables

    /**
    * Pokaz formatke
    *
    */
    function connectDb() {
        global $DOCUMENT_ROOT;
        global $database;

        // nawiaz polaczenie z baza danych
        MetabaseSetupDatabaseObject(array(
        "Host"=>$this->_host,
        "Type"=>$this->_dbtype,
        "User"=>$this->_login,
        "Password"=>$this->_password,
        "Persistent"=>false,
        "IncludePath"=>"$DOCUMENT_ROOT/../lib/Metabase"),$this->db2);

        // ustawa baze danych
        $this->db2->SetDatabase($this->_dbname);
        // odczytaj wszystkie tabele z tej bazy danych
        $query="SHOW TABLES";
        $prepared_query=$this->db2->PrepareQuery($query);
        $ret_table=array();
        if ($prepared_query) {
            $result=$this->db2->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$this->db2->NumberOfRows($result);
                if ($num_rows>0) {
                    for($i=0; $i< $num_rows; $i++) {
                        $code1=$this->db2->FetchResult($result,$i,"Tables_in_".$this->_dbname);
                        array_push ($ret_table, $code1);
                    }
                }
            }
        }
        // jesli tablica jest pusta to zwroc false
        if(empty($ret_table)) {
            return false;
        } else {
            // zapisz liste tablic
            $this->_tables=$ret_table;
            return true;
        }
    } // end func connectDb

    /**
    * Sprawdz parametry ktore przyszly
    *
    */
    function _getParam() {
        global $_REQUEST;
        global $lang;

        $error='';
        // sprawdzamy czy nazwa bazy danych jest prawidlowa
        if(!empty($_REQUEST['item']['host']) && !preg_match("/[\'\,]/",$_REQUEST['item']['host'])) {
            $this->_host=$_REQUEST['item']['host'];
        } else {
            $error=$lang->importshop_error['host'];
        }

        if(!empty($_REQUEST['item']['database']) && !preg_match("/[\'\,\.]/",$_REQUEST['item']['database'])) {
            $this->_dbname=$_REQUEST['item']['database'];
        } else {
            $error=$lang->importshop_error['database'];
        }

        if(!empty($_REQUEST['item']['port']) && preg_match("/^[0-9]{3,5}$/",$_REQUEST['item']['port'])) {
            $this->_port=$_REQUEST['item']['port'];
        } else {
            $error=$lang->importshop_error['port'];
        }

        if(!empty($_REQUEST['item']['login']) && !preg_match("/[\'\,\.]/",$_REQUEST['item']['login'])) {
            $this->_login=$_REQUEST['item']['login'];
        } else {
            $error=$lang->importshop_error['login'];
        }

        $this->_password=$_REQUEST['item']['password'];
        $this->_type=$_REQUEST['item']['type'];

        // jesli byl jakis error to pokaz formatke jeszcze raz
        if(!empty($error)) {
            if($this->_getConvert()) {
                return false;
            }
        }
        return true;
    } // end func _getParam

    /**
    * Pokaz formatke
    *
    */
    function showForms() {
        global $lang;
        if($this->_getConvert()) {
            include_once("./html/importshop.html.php");
        }
    } // end func showForms()

    /**
    * Stworz tablice z dostepnymi konwersjami na postawie plikow konwersji 
    * ktore znajduja sie w katalogu include/class
    *
    */
    function _getConvert() {
        // odczytaj aktualna wersje sklepu
        $fd=fopen("../../../VERSION","r");
        $version=fread($fd,"100");
        $version=preg_replace("/\s+$/","",$version);
        fclose($fd);
        //odczytaj dostepne konwersje
        $dir="./include/class";
        $files=array();
        if ($root=@opendir($dir)){
            while ($file=readdir($root)){
                if($file=="." || $file==".."){continue;}
                $file_copy=$file;
                $file=preg_replace("/\..+$/","",$file);
                if (in_array($file_copy,$this->class_allowed)) {
                    if(! is_dir($dir."/".$file)){
                        $files=$files+array($file=>$file."->".$version);
                    }
                } 
            }
        } else return false;
        $this->_convert=$files;
        return true;
    } // end func _getConvert
} // end class ImportShop
?>

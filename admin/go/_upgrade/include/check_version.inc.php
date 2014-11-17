<?php
/**
* Sprawdzenie wersji sklepu oraz wersji bazy danych
*
* @author  m@sote.pl
* @version $Id: check_version.inc.php,v 1.3 2004/12/20 17:59:11 maroslaw Exp $
* @package    upgrade
*/

/**
* Sprawed¼ wersjê struktury bazy danych
* @package upgrade
*/
class CheckDBVersion {
    
    /**
    * Konstruktor
    * @return none
    */
    function CheckDBVersion() {
        global $db;
        
        // jesli baza zosta³a zbudowana na bazie 2.0 lub 2.5 to posiada tabele order_sessions
        // tabeli tej nie ma w wersji 3.0
        $query="SELECT order_id FROM order_session LIMIT 1";
        $result=$db->Query($query);           
        $error=$db->Error();
        if (empty($error)) {
            $this->_version="2.x";
        } else $this->_version="3.x";
        return;
    } // end CheckDBVersion()
    
    /**
    * Odczytaj numer wersji skruktury bazy danych
    * @return string numer wersji
    */ 
    function getDBVersion() {
        return $this->_version;   
    } // ned getDBVersion()
    
} // end class CheckVersion()
?>

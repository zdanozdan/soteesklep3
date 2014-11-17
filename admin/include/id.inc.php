<?php
/**
* @version    $Id: id.inc.php,v 2.4 2004/12/20 17:59:23 maroslaw Exp $
* @package    admin_include
*/

class IDGen {

    /**
     * Funkcja generujaca kolejny numer id typu CHAR
     * @author piotrek@sote.pl 
     * \@modified_by m@sote.pl
     * @param string $id 
     * @return string kolejny numer id
     */
    function next_id($id="") {
        if (ereg("^[0-9]+$",$id)) {
            $id++;
            return $id;
        }
        $id2=1;        
        if(ereg("[0-9]+$",$id)==true){
            $id1=ereg_replace("[0-9]+$","",$id);
            preg_match("/([0-9]+)$/",$id,$matches);
            $id2=$matches[1];
            $id2++;
            return $id2;
        } else {   
            if (empty($liczba)) $liczba='';
            return $id.$liczba;                                                                                        
        }
    } // end next_id() 

    /**
     * Wygeneruj nowy numer user_id. Po wygenerowaniu sprawdz czy nie wygenerowany zostal numer juz istniejacy.
     * Jesli tak, to ponownie generuj kolejny numer, az dojdziemy do numeru ktory jeszcze nie istnieje.
     * Jesli nie ma zadnych produktow w bazie zwoc user_id=1.
     * @return string nowy numer user_id
     */
    function new_main_user_id() {
        global $db;
        global $config;

        // sprawdz ilosc produktow w bazie
	$maxid=1;

	$query="SELECT max(id) AS maxid FROM main";
	$result=$db->Query($query);
	if ($result!=0) {
	    $num_rows=$db->NumberOfRows($result);
	    if ($num_rows>0) {		
		$maxid=$db->FetchResult($result,0,"maxid");
		$maxid++;
	    }
	} else die ($db->Error());
        
	return $maxid;
    } // end new_main_user_id()
}

$id =& new IDGen;

?>

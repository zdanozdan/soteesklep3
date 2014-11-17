<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec_ceneo.inc.php,v 2.2 2006/08/16 10:20:55 lukasz Exp $
*
* \@global object $result           wynik zapytania SQL o wlasciwosci produktu
* \@global string $_REQUEST['lang'] jêzyk, dla którego jest definiowany opis itp.
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

class RecordData {
    var $data=array();
}

global $rec;
global $id;

$rec =& new RecordData;
$result = $db->Query("Select * From main Where id=$id");
$rec->data['ceneo_export']=$db->FetchResult($result,0,"ceneo_export");
?>

<?php
/*
 * Test sotelib
 *
 */

// definiuj dodatkowe sciezki przeszukiwan include && require
$_LIBS="../..";
$include_path=ini_get("include_path");
ini_set("include_path","$_LIBS:$include_path");

// dodaj obsluge DBEdit
require_once "DBEdit.inc";
// dodaj obsluge MetaBase
require_once "../Metabase/metabase_interface.php";
require_once "../Metabase/metabase_database.php";

$error=MetabaseSetupDatabaseObject(array(
                                         "Host"=>"localhost",
                                         "Type"=>"mysql",
                                         "User"=>"euser",
                                         "Password"=>"qwebody2",
                                         "Persistent"=>false,
                                         "IncludePath"=>"../Metabase"),$db);
                                         
if (! empty($error)) {
    die ("Database setup error:  $error\n");
}

// ustaw baze nazwe bazy danych
$db->SetDatabase("sdevel");


/**
 * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
 * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
 */ 
class RecordRow {
    function record($result,$i) {
        global $db;
        $nazwa=$db->FetchResult($result,$i,"name");
        echo "<tr><td>$i</td><td>$nazwa</td></tr>";
        return;
    }
}

$dbedit = new DBEdit;
$dbedit->dbtype="mysql";
$dbedit->record_list("SELECT * FROM main"); 
?>
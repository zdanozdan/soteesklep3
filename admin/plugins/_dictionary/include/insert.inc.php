<?php
/**
 * Dodaj nowy rekord do tabeli dictionary wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author piotrek@sote.pl
 * \@global string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: insert.inc.php,v 2.4 2004/12/20 17:59:36 maroslaw Exp $
* @package    dictionary
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;
global $config;

// dodaj rekord
// config
$query="INSERT INTO dictionary (wordbase,";
reset($config->languages);$values='';
foreach ($config->languages as $clang) {
    if ($clang!=$config->base_lang) {
        $query.="$clang,";
        $values.="?,";
    }
}
$query=substr($query,0,strlen($query)-1);    // obetnij ostatni znak ","
$values=substr($values,0,strlen($values)-1);    // obetnij ostatni znak ","
$query.=") VALUES (?,$values)";
// end

/*
print "query=$query <BR>";
print  "<pre>";
print_r($this->data);
print "</pre>";
print "id=$this->id <BR>";
*/

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['wordbase']);
    reset($config->languages);
    $i=2;
    foreach ($config->languages as $clang) {
        if ($clang!=$config->base_lang) {
            $db->QuerySetText($prepared_query,$i,@$this->data[$clang]); 
            $i++;
        }
    }
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->dictionary_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());


/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszarku okreslone jako 
// config
... tu edytujemy
// end
 
*/
?>

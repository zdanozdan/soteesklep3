<?php
/**
 * Dodaj nowy rekord do tabeli edit_category wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  m@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.4 2005/12/29 14:10:29 lechu Exp $
 * @return  int $this->id
* @package    edit_category
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;
global $__deep;

// dodaj rekord
// config
$query="INSERT INTO category$__deep (category$__deep, ord_num) VALUES (?, ?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data["category"]);
    $db->QuerySetText($prepared_query,2,$this->data["ord_num"]);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->edit_category_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>

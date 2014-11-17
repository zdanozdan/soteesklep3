<?php
/**
* Dodaj now± grupê newsletter
*
* @author  rdiak@sote.pl
* @version $Id: insert.inc.php,v 2.6 2004/12/20 18:00:14 maroslaw Exp $
* @return int $this->id
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

if (@$this->secure_test!=true) die ("Forbidden");

global $db;

// dodaj rekord
// config
$query="INSERT INTO newsletter_groups (user_id, name) VALUES (?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetInteger($prepared_query,1,$this->data['user_id']);
    $db->QuerySetText($prepared_query,2,$this->data['name']);
    // end
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Error: add record");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());
?>

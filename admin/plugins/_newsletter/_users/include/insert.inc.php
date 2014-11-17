<?php
/**
* Dodaj nowy adres e-mail do bazy.
*
* @author m@sote.pl
* @version $Id: insert.inc.php,v 2.8 2004/12/20 18:00:20 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

if (@$this->secure_test!=true) die ("Forbidden");

global $db;

// dodaj rekord
// config
$query="INSERT INTO newsletter (email, date_add, status, active, md5, groups, lang) VALUES (?,CURRENT_DATE,?,?,?,?,?)";
// end

$email_md5=md5($this->data['email'].$config->salt);

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['email']);
    $db->QuerySetInteger($prepared_query,2,$this->data['status']);
    $db->QuerySetInteger($prepared_query,3,$this->data['active']);
    $db->QuerySetText($prepared_query,4,$email_md5);
    $db->QuerySettext($prepared_query,5,@$this->data['groups']);
    $db->QuerySettext($prepared_query,6,@$this->data['lang']);
    
    // end
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM newsletter";
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

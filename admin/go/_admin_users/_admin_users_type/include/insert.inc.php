<?php
/**
* Dodaj nowy rekord do tabeli admin_users_type wykonaj komende SQL dodanie rekordu do bazy
*
* @author m@sote.pl
* @version $Id: insert.inc.php,v 2.4 2004/12/20 17:57:47 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

/**
* \@global string $table nazwa tabeli do ktorej dodajemy rekord 
* \@return int $this->id
*/

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;
global $config;

// dodaj rekord
// config
$query="INSERT INTO admin_users_type (type";
foreach ($config->admin_perm as $perm) {
    $query.=",p_$perm";
}
$query.=") VALUES (?";
foreach ($config->admin_perm as $perm) {
    $query.=",?";
}
$query.=")";
// end


$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['type']);
    $i=2;
    foreach ($config->admin_perm as $perm) {
        $db->QuerySetText($prepared_query,$i,@$this->data["p_$perm"]);
        $i++;
    }
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->admin_users_type_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());

?>

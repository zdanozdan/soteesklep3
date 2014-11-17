<?php
/**
* Dodaj nowy rekord do tabeli newsedit_groups wykonaj komende SQL dodanie rekordu do bazy
*
* @author  m@sote.pl
* \@global  string $table nazwa tabeli do ktorej dodajemy rekord
* \@global  int $this->id
* \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
* @version $Id: insert.inc.php,v 1.7 2004/12/20 18:00:07 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db;

// dodaj rekord
// config
$query="INSERT INTO newsedit_groups (name,template_info,template_row,multi) VALUES (?,?,?,?)";
// end

if (empty($this->data['template_row'])) $this->data['template_row']=0;
if (empty($this->data['template_info'])) $this->data['template_info']=0;

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetInteger($prepared_query,2,@$this->data['template_row']);
    $db->QuerySetInteger($prepared_query,3,@$this->data['template_info']);
    if (empty($this->data['multi'])) $this->data['multi']=0;
    $db->QuerySetInteger($prepared_query,4,$this->data['multi']);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->newsedit_groups_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());
?>

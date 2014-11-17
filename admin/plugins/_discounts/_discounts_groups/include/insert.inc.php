<?php
/**
 * PHP Template:
 * Dodaj nowy rekord do tabeli discounts_groups wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author m@sote.pl
 * \@global string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.1 2003/03/13 11:28:51 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.7 2005/03/29 15:21:14 lechu Exp $
 * @return int $this->id
* @package    discounts
* @subpackage discounts_groups
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db, $mdbd;

if (ereg("Happy hour",$this->data['group_name'])) {
    $res = $mdbd->select("user_id", "discounts_groups", "group_name='Happy hour'", array(), '', 'array');
    if($mdbd->num_rows > 0) {
        die($lang->discounts_groups_happyhour_override_error);
    }
}
// dodaj rekord
// config
$query="INSERT INTO discounts_groups (user_id,group_name,default_discount,public,photo,group_amount,calculate_period,start_date,end_date) VALUES (?,?,?,?,?,?,?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['user_id']);
    $db->QuerySetText($prepared_query,2,$this->data['group_name']);
    $db->QuerySetText($prepared_query,3,$this->data['default_discount']);
    $db->QuerySetText($prepared_query,4,@$this->data['public']);
    $db->QuerySetText($prepared_query,5,@$this->data['photo']);
    $db->QuerySetText($prepared_query,6,@$this->data['group_amount']);
    $db->QuerySetText($prepared_query,7,@$this->data['calculate_period']);
    // end
    
    // start happy hour
    $db->QuerySetText($prepared_query,8,@$this->data['start_date']);
    $db->QuerySetText($prepared_query,9,@$this->data['end_date']);
    // end happy hour
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->discounts_groups_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ($db->error());
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());

global $__edit;
$__edit="edit";
?>

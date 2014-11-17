<?php
/**
* Dodaj nowego newsa.
*
* \@global int $global_id
*
* @author  m@sote.pl
* @version $Id: insert_newsedit.inc.php,v 2.7 2004/12/27 15:44:32 lechu Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

if ($global_secure_test!=true) die ("Bledne wywolanie");

if(empty($rec->data['ordercol'])){
    $rec->data['ordercol']=0;
}

// dodaj newsa do tabeli rec->data
$query="INSERT INTO newsedit
                 (date_add,active,ordercol,subject,category,short_description,description,photo_small,photo1,photo2,
                  photo3,photo4,photo5,photo6,photo7,photo8,id_newsedit_groups,url,group1,group2,group3,lang,rss) 
               VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

if (@$rec->data['active']!=1) {
    $rec->data['active']=0;
}
if (@$rec->data['rss']!=1) {
    $rec->data['rss']=0;
}

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$rec->data['date_add']);
    $db->QuerySetText($prepared_query,2,$rec->data['active']);
    $db->QuerySetInteger($prepared_query,3,$rec->data['ordercol']);
    $db->QuerySetText($prepared_query,4,$rec->data['subject']);
    $db->QuerySetText($prepared_query,5,$rec->data['category']);
    $db->QuerySetText($prepared_query,6,$rec->data['short_description']);
    $db->QuerySetText($prepared_query,7,$rec->data['description']);
    $db->QuerySetText($prepared_query,8,my(@$rec->data['photo_small']));
    $db->QuerySetText($prepared_query,9,my(@$rec->data['photo1']));
    $db->QuerySetText($prepared_query,10,my(@$rec->data['photo2']));
    $db->QuerySetText($prepared_query,11,my(@$rec->data['photo3']));
    $db->QuerySetText($prepared_query,12,my(@$rec->data['photo4']));
    $db->QuerySetText($prepared_query,13,my(@$rec->data['photo5']));
    $db->QuerySetText($prepared_query,14,my(@$rec->data['photo6']));
    $db->QuerySetText($prepared_query,15,my(@$rec->data['photo7']));
    $db->QuerySetText($prepared_query,16,my(@$rec->data['photo8']));
    $db->QuerySetText($prepared_query,17,my(@$rec->data['id_newsedit_groups']));
    $db->QuerySetText($prepared_query,18,my(@$rec->data['url']));
    $db->QuerySetText($prepared_query,19,my(@$rec->data['group1']));
    $db->QuerySetText($prepared_query,20,my(@$rec->data['group2']));
    $db->QuerySetText($prepared_query,21,my(@$rec->data['group3']));
    $db->QuerySetText($prepared_query,22,$rec->data['lang']);
    $db->QuerySetText($prepared_query,23,$rec->data['rss']);
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM newsedit";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $global_id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Error: add product");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());

?>

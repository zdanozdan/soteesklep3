<?php
/**
* Aktualizacja danych newsa
*
* \@global int $id ID newsa
*
* @author rdiak@sote.pl m@sote.pl
* @version $Id: update_newsedit.inc.php,v 2.7 2006/03/06 09:06:59 lechu Exp $
* @package    newsedit
*/

if ($global_secure_test!=true) die ("Bledne wywolanie");

// aktualizuj newsa
$query="UPDATE newsedit SET active=?,ordercol=?,subject=?,category=?,short_description=?,description=?,photo_small=?,photo1=?,photo2=?,photo3=?,photo4=?,photo5=?,photo6=?,photo7=?,photo8=?,
id_newsedit_groups=?,url=?, group1=?, group2=?, group3=?, rss=?,
date_add=?
        WHERE id=?";

if (@$rec->data['active']!=1) {
    $rec->data['active']=0;
}

if (@$rec->data['rss']!=1) {
    $rec->data['rss']=0;
}


$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$rec->data['active']);
    $db->QuerySetText($prepared_query,2,$rec->data['ordercol']);
    $db->QuerySetText($prepared_query,3,$rec->data['subject']);
    $db->QuerySetText($prepared_query,4,$rec->data['category']);
    $db->QuerySetText($prepared_query,5,$rec->data['short_description']);
    $db->QuerySetText($prepared_query,6,$rec->data['description']);
    $db->QuerySetText($prepared_query,7,my(@$rec->data['photo_small']));
    $db->QuerySetText($prepared_query,8,my(@$rec->data['photo1']));
    $db->QuerySetText($prepared_query,9,my(@$rec->data['photo2']));
    $db->QuerySetText($prepared_query,10,my(@$rec->data['photo3']));
    $db->QuerySetText($prepared_query,11,my(@$rec->data['photo4']));
    $db->QuerySetText($prepared_query,12,my(@$rec->data['photo5']));
    $db->QuerySetText($prepared_query,13,my(@$rec->data['photo6']));
    $db->QuerySetText($prepared_query,14,my(@$rec->data['photo7']));
    $db->QuerySetText($prepared_query,15,my(@$rec->data['photo8']));
    $db->QuerySetText($prepared_query,16,my(@$rec->data['id_newsedit_groups']));
    $db->QuerySetText($prepared_query,17,my(@$rec->data['url']));
    
    if (empty($rec->data['group1'])) $rec->data['group1']=0;
    if (empty($rec->data['group2'])) $rec->data['group2']=0;
    if (empty($rec->data['group3'])) $rec->data['group3']=0;
    $db->QuerySetText($prepared_query,18,@$rec->data['group1']);
    $db->QuerySetText($prepared_query,19,@$rec->data['group2']);
    $db->QuerySetText($prepared_query,20,@$rec->data['group3']);
    $db->QuerySetText($prepared_query,21,@$rec->data['rss']);
    $db->QuerySetText($prepared_query,22,@$rec->data['date_add']);
    
    $db->QuerySetInteger($prepared_query,23,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else  die ($db->Error());
} else  die ($db->Error());

?>

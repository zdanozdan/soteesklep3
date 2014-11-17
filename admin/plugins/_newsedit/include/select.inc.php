<?php
/**
* Odczytaj wla¶ciwosci newsa.
*
* @author  m@sote.pl
* @version $Id: select.inc.php,v 2.5 2004/12/27 15:44:32 lechu Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

if (@$__secure_test!=true) die ("Forbidden");

$rec->data['id']=$db->FetchResult($result,0,"id");
$rec->data['date_add']=$db->FetchResult($result,0,"date_add");
$rec->data['active']=$db->FetchResult($result,0,"active");
$rec->data['rss']=$db->FetchResult($result,0,"rss");
$rec->data['ordercol']=$db->FetchResult($result,0,"ordercol");
$rec->data['subject']=$db->FetchResult($result,0,"subject");
$rec->data['category']=$db->FetchResult($result,0,"category");
$rec->data['short_description']=$db->FetchResult($result,0,"short_description");
$rec->data['description']=$db->FetchResult($result,0,"description");
$rec->data['photo_small']=$db->FetchResult($result,0,"photo_small");
$rec->data['photo1']=$db->FetchResult($result,0,"photo1");
$rec->data['photo2']=$db->FetchResult($result,0,"photo2");
$rec->data['photo3']=$db->FetchResult($result,0,"photo3");
$rec->data['photo4']=$db->FetchResult($result,0,"photo4");
$rec->data['photo5']=$db->FetchResult($result,0,"photo5");
$rec->data['photo6']=$db->FetchResult($result,0,"photo6");
$rec->data['photo7']=$db->FetchResult($result,0,"photo7");
$rec->data['photo8']=$db->FetchResult($result,0,"photo8");
$rec->data['id_newsedit_groups']=$db->FetchResult($result,0,"id_newsedit_groups");
$rec->data['url']=$db->FetchResult($result,0,"url");
$rec->data['group1']=$db->FetchResult($result,0,"group1");
$rec->data['group2']=$db->FetchResult($result,0,"group2");
$rec->data['group3']=$db->FetchResult($result,0,"group3");
?>

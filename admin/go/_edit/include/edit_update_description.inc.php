<?php
/**
 * Aktualizaja opisów produktu
 *
 *
 * @author  m@sote.pl
 * @version $Id: edit_update_description.inc.php,v 2.8 2005/06/24 11:33:51 lechu Exp $
 * @package admin
 * @subpackage edit
 *
 * @global int   $id   id aktualizowanego rekordu
 * @global array $item tablica z danymi produktu (id, opis, ...)
 * \@lang
 */

if ($global_secure_test!=true) {
    die ("Forbidden");
}

global $config;

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
    $item=&$_REQUEST['item'];
} else {
    die ("Forbidden: Unknown item");
}

// jesli zalaczono pliki opisu, to ignoruj dane z formularza z elementu <textarea>
if (! empty($item_upload['xml_description'])) {
    $item['xml_description']=&$item_upload['xml_description'];
}
if (! empty($item_upload['xml_short_description'])) {
    $item['xml_short_description']=&$item_upload['xml_short_description'];
}

// odczytaj odpowiednie werje jêzykowe nazwy i opisu
$lang_id=0;
if (isset($item['lang_id'])) {
    $rec->data['lang_id']=$item['lang_id'];
    $lang_id=$rec->data['lang_id'];
} else $lang_id = 0;
if ($rec->data['lang_id']==0) $lang_id=0;

$res = $mdbd->select('id', 'main_lang', "main_user_id=?", array($user_id => "string"), '', 'array');
if($mdbd->num_rows == 0) {
    $mdbd->insert('main_lang', 'main_user_id', "'$user_id'");
}

/*
$query="UPDATE main,main_lang SET
        main.name_L" . $lang_id . "=?,
        main.xml_description_L" . $lang_id . "=?,
        main.xml_short_description_L" . $lang_id . "=?,
        main_lang.name_" . $config->langs_symbols[$lang_id] . "=?,
        main_lang.xml_description_" . $config->langs_symbols[$lang_id] . "=?,
        main_lang.xml_short_description_" . $config->langs_symbols[$lang_id] . "=?
        WHERE main.id=? AND main_lang.main_user_id=main.user_id";
*/

$query="UPDATE main SET
        name_L" . $lang_id . "=?,
        xml_description_L" . $lang_id . "=?,
        xml_short_description_L" . $lang_id . "=?
        WHERE id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$item['name']);
    $db->QuerySetText($prepared_query,2,$item['xml_description']);
    $db->QuerySetText($prepared_query,3,$item['xml_short_description']);    
    $db->QuerySetText($prepared_query,4,$id);

    $result=$db->ExecuteQuery($prepared_query);
    if ($result==0) {
        die ($db->Error());
    } 
} else {
    die ($db->Error());
}

$query="UPDATE main_lang SET
        name_" . $config->langs_symbols[$lang_id] . "=?,
        xml_description_" . $config->langs_symbols[$lang_id] . "=?,
        xml_short_description_" . $config->langs_symbols[$lang_id] . "=?
        WHERE main_user_id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$item['name']);
    $db->QuerySetText($prepared_query,2,$item['xml_description']);
    $db->QuerySetText($prepared_query,3,$item['xml_short_description']);    
    $db->QuerySetText($prepared_query,4,$user_id);

    $result=$db->ExecuteQuery($prepared_query);
    if ($result==0) {
        die ($db->Error());
    } 
} else {
    die ($db->Error());
}


?>
<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli dictionary
 * 
 * @author piotrek@sote.pl
 * \@template_version Id: update.inc.php,v 1.3 2003/02/06 11:55:16 maroslaw Exp
 * @version $Id: update.inc.php,v 2.6 2005/03/14 14:05:33 lechu Exp $
* @package    dictionary
* \@lang
 */

global $db;
if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $config;

// config
$query="UPDATE dictionary SET wordbase=?,";
reset($config->languages);
reset($config->langs_symbols);
//foreach ($config->langs_symbols as $clang) {
while (list($clang, $ls) = each($config->langs_symbols)) {
    if ($clang!=$config->lang_id)
        $query.="$ls=?,";
}
$query=substr($query,0,strlen($query)-1);   // obetnij znak ","
$query.=" WHERE id=?";
// end

/*
print "query=$query <BR>";
print  "<pre>";
print_r($this->data);
print "</pre>";
print "id=$this->id <P>";
*/

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['wordbase']);
    reset($config->languages);
    $i=2;
    reset($config->langs_symbols);
    while (list($clang, $ls) = each($config->langs_symbols)) {
//    foreach ($config->languages as $clang) {
        if ($clang!=$config->lang_id) {
            $db->QuerySetText($prepared_query,$i,$this->data[$ls]); 
            $i++;
        }
    }
    $db->QuerySetText($prepared_query,$i,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $my_date=date("Y-m-d H:i:s");
        $update_info=$lang->dictionary_edit_update_ok." $my_date";
    } else die ($db->Error());
} else die ($db->Error());


?>

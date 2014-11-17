<?php
/**
 * \@global array $__dictionarydata tablica z wartosciami z tablicy dictionary
 * \@global string $__query zapytanie sql - odczytanie wybranych wartosci z tabeli
 * 
 * @author piotrek@sote.pl
 * @version $Id: select.inc.php,v 2.6 2005/03/14 14:05:33 lechu Exp $
* @package    dictionary
* \@lang
 */

global $__secure_test; 
if (@$__secure_test!=true) die ("Forbidden");

global $db;
global $theme;
global $lang;
global $_POST;
global $config;

$__dictionary_data=array();

if (empty($__query)) {
    $query="SELECT * FROM $table WHERE id=?";
} else $query=$__query;

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    if (empty($__query)) {
        $db->QuerySetText($prepared_query,1,$this->id);
    }
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if (empty($__query)) {
            $max=0;
        } else $max=$num_rows;;

        if ($num_rows>0) {
            // config
            $this->data['id']=$db->FetchResult($result,0,"id");
            $this->data['wordbase']=$db->FetchResult($result,0,"wordbase");
            reset($config->languages);
            reset($config->langs_symbols);
            while (list($clang, $ls) = each($config->langs_symbols)) {
//            foreach ($config->languages as $clang) {
                $this->data[$ls]=$db->FetchResult($result,0,$ls);
            }
            // end
        } else {
            $theme->back();
            if (empty($__query)) {
                die ("Brak rekordu o id=$id");        
            }
        }

        
    } else die ($db->Error());
} else die ($db->Error());

?>

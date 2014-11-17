<?php
/**
 * Klasa prezentacji wiersza rekordu z tabeli dictionary
 * 
 * @author piotrek@sote.pl
 * @version $Id: row.inc.php,v 2.5 2005/03/14 14:05:33 lechu Exp $
* @package    dictionary
* \@lang
 */

class Rec {
    var $data=array();
}

class ModTableRow {

    function record($result,$i) {
        global $db;
        global $theme;
        global $config;

        $rec = new Rec;

        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['wordbase']=$db->FetchResult($result,$i,"wordbase");
        reset($config->languages);
        reset($config->langs_symbols);
        while (list($clang, $ls) = each($config->langs_symbols)) {
//        foreach ($config->languages as $clang) {
            if($config->langs_active[$clang] == 1)
                $rec->data[$ls]=$db->FetchResult($result,$i,$ls);
        }
        // end
        
        include ("./html/row.html.php");
		
        return;
    } // end record()
    
} // end class Row
?>

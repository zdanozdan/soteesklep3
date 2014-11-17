<?php
/**
* @version    $Id: edit_text.inc.php,v 2.4 2004/12/20 17:59:07 maroslaw Exp $
* @package    text
*/

/**
 * Funckje edycji plikow
 */
class EditText {
    
    function files($files,$my_lang) {
        global $theme;

        print "<ul>";
        foreach ($files as $key=>$file) {
            $key_coded=urlencode($key);   // kodowanie tlumaczenia nazwy pliku
            print "<li><a href=edit.php?file=$file&file_name=$key_coded&lang_name=$my_lang $theme->onclick target=window>$key</a>";
        }
        print "</ul>";
        return;
    } // end files
} // end class EditText
?>

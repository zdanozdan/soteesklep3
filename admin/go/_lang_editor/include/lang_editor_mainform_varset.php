<?php
/**
* Edycja wersji jêzykowych - odfiltrowanie i ustalenie typu zmiennych
*
* @author  lech@sote.pl
* @version $Id: lang_editor_mainform_varset.php,v 1.8 2004/12/20 17:58:18 maroslaw Exp $
* @package    lang_editor
*/

while(list($key, $val) = each($editor->currentVars)){
    $vtype = $editor->filterVariable($_REQUEST, $key); // sprawd¼ typ zmiennej
    if($vtype == 'array')
/**
* Formularz zmiennej tablicowej.
*/
        include("./html/lang_editor_form_array_var.html.php"); // wy¶wietl formularz tablicy
    if($vtype == 'simple')
/**
* Formularz zmiennej prostej.
*/
        include("./html/lang_editor_form_simple_var.html.php");  // wy¶wietl formularz zmiennej prostej
}
?>

<?php
/**
 * PHP Template:
 * Formularz edycji rekordu
 *
 * @author piotrek@sote.pl 
 * @version $Id: edit.html.php,v 2.11 2005/03/14 14:05:14 lechu Exp $
* @package    dictionary
* \@lang
 */
 
include_once ("include/forms.inc.php");
$forms =& new Forms;

global $config;
global $lang;
global $_REQUEST;

// slowo przekazane do dodania do slownika, z inengo elementu sklepu (z inengo modulu, np. dostawcy)
if (! empty($_REQUEST['word'])) {
    $rec->data['wordbase']=$_REQUEST['word'];
}

$forms->open($action,@$this->id);
reset($config->languages_names);
$forms->text("wordbase",@$rec->data['wordbase'],$config->langs_names[$config->lang_id]);
while (list($clang,$lang_name) = each ($config->langs_names)) {
//    if($config->langs_active[$clang] == 1) {
        if ($clang!=$config->lang_id)
            $forms->text($config->langs_symbols[$clang],@$rec->data[$config->langs_symbols[$clang]],$lang_name);
//    }
}
$forms->submit("submit_update",$lang->dictionary_edit_submit);
$forms->close();

print "<p />";
print $lang->dictionary_export_info;
?>

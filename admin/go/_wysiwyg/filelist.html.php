<?php
/**
* @version    $Id: filelist.html.php,v 1.8 2005/03/31 12:08:16 lechu Exp $
* @package    wysiwyg
* \@lang
*/
$str_selected = array();
@$str_selected[$chosen_lang] = 'selected';
echo "$lang->files2edit: <br>";
if (in_array("multi_lang",$config->plugins)) {
    echo"
	<form name='MyForm' method='post' action='index.php'>
	<select onchange='javascript:document.MyForm.submit();' name='chosen_lang'>";
    for($i = 0; $i < count($config->langs_symbols); $i++) {
        if($config->langs_active[$i]) {
            $lang_symbol = $config->langs_symbols[$i];
            $lang_name = $config->langs_names[$i];
            $str_sel = @$str_selected[$lang_symbol];
            echo "<option value='$lang_symbol' $str_sel>$lang_name</option>";
        }
    }
    echo "
	</select>
</form>
<ol>";
}
if (is_array(@$config->wysiwyg_files[$chosen_lang])) {
    while (list($file, $info) = each($config->wysiwyg_files[$chosen_lang])){
    	$caption = $info['text'];
    	if($info['editing'] == 'classic')
    		$editor = 'edit_classic.php';
    	if($info['editing'] == 'wysiwyg')
    		$editor = 'edit.php';
    	echo "<li><a href='javascript:void(0)'; onclick='window.open(\"$editor?file=$file&chosen_lang=$chosen_lang\", \"edytor\", \"width=800, height=600\");'>$caption</a></li>";
    }
}
echo "</ol>";

?>

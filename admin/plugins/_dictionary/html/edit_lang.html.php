<?php
/**
* \@lang
* \@encoding
*/

$disabled = '';
$current_flag = "<i>" . $lang->dictionary_new_lang_no_file . "</i>";
if($_REQUEST['action'] == 'edit') {
    $disabled = 'disabled=1';
    $lang_name = $config->langs_names[$_REQUEST['lang_id']];
    $lang_symbol = $config->langs_symbols[$_REQUEST['lang_id']];
    $lang_encoding = $config->langs_encoding[$_REQUEST['lang_id']];
    $lang_encoding_selected[$lang_encoding] = "selected";
    if(!empty($config_flags->files[$lang_symbol])) {
        $current_flag = "<img src='http://" . $config->www . "/themes/base/base_theme/_flags/" . $config_flags->files[$lang_symbol] . "'>";
    }
}
?>
<br><br>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#aaaaaa">
<form action="edit_lang.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo $_REQUEST['action']; ?>">
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="lang_id" value="<?php echo @$_REQUEST['lang_id']; ?>">
    <tr>
        <td bgcolor="White"><?php echo $lang->dictionary_new_lang_name; ?></td>
        <td bgcolor="White"><input type="text" name="lang_name" value="<? echo @$lang_name; ?>"></td>
    </tr>
    <tr>
        <td bgcolor="White"><?php echo $lang->dictionary_new_lang_symbol; ?></td>
        <td bgcolor="White"><input type="text" name="lang_symbol" value="<? echo @$lang_symbol; ?>" size="2" maxlength="2" <?php echo $disabled; ?>></td>
    </tr>
    <tr>
        <td bgcolor="White"><?php echo $lang->dictionary_new_lang_flag; ?></td>
        <td bgcolor="White"><input type=hidden MAX_FILE_SIZE=20000><input type="file" name="lang_flag"></td>
    </tr>
    <tr>
        <td bgcolor="White"><?php echo $lang->dictionary_new_lang_current_flag; ?></td>
        <td bgcolor="White"><?php echo $current_flag; ?></td>
    </tr>
    <tr>
    <tr>
        <td bgcolor="White" colspan="100%">
            <?php echo @$lang->dictionary_new_lang_encoding; ?>:<br>
            <select name="lang_encoding">
            <?php
            reset($config->supported_encoding);
            while(list($key_1, $val_1) = each($config->supported_encoding)) {
                if (is_array($val_1)) {
                    echo "<optgroup label='$key_1'>";
                	while (list($key_2, $val_2) = each($val_1)) {
                		echo "<option value='$val_2' " . @$lang_encoding_selected[$val_2] . ">$key_2</option>\n";
                	}
                    echo "</optgroup>";
                }
                else {
                    echo "<option value='$val_1' " . @$lang_encoding_selected[$val_1] . ">$key_1</option>\n";
                }
            }
            ?>
            </select>
        </td>
    </tr>
        <td bgcolor="White" colspan="100%" align="center">
            <br>
            <input type="submit" value="<?php echo $lang->update; ?>">
        </td>
    </tr>
</form>
</table>
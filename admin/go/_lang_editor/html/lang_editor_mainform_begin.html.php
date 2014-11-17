<?php
/**
* Edycja wersji jêzykowych - nag³ówek formularzy edycji zmiennych
*
* @author  lech@sote.pl
* @version $Id: lang_editor_mainform_begin.html.php,v 1.3 2005/04/28 12:01:45 lechu Exp $
* @package    lang_editor
* \@encoding
*/

global $config, $lang, $NewEncoding;
?>
<table cellspacing="1" bgcolor="#aaaaaa" cellpadding="4">
    <tr>
        <td bgcolor="White">
            <b><?php echo $lang->_lang_editor_col_var_name; ?></b>
        </td>
        <td bgcolor="White">
            <B><?php echo $lang->_lang_editor_col_var_group; ?></B>
        </td>
<?php   for($ll = 0; $ll < count($editor->languages); $ll++){ ?>
        <td bgcolor="White"><B><?php echo $NewEncoding->Convert($lang->_lang_editor_col_var_val, $config->langs_encoding[$config->lang_id], "utf-8", 0); ?> <?php echo $editor->languages[$ll]; ?></B>
        </td><?php } ?>
        <td bgcolor="White">
            &nbsp;
        </td>
    </tr>

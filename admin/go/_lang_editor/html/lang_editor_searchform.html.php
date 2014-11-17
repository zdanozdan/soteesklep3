<?php
/**
* Edycja wersji jêzykowych - formularz wyszukiwania zmiennych
*
* Plik wy¶wietla formularz wyszukiwania zmiennych. Do formularza mo¿na wpisaæ nazwê
* zmiennej lub jej fragment, warto¶æ zmiennej (w dowolnej wersji jêzykowej) lub jej fragment,
* modu³, z którego pochodzi zmienna oraz mo¿na wybraæ ten jêzyk, dla którego wyszukiwane
* zmienne nie s± zdefiniowane - umo¿liwia to skrócenie wy¶wietlanej pó¼niej listy znalezionych
* zmiennych do warto¶ci, które nie s± zdefiniowane dla danego jêzyka.
*
* @author  lech@sote.pl
* @version $Id: lang_editor_searchform.html.php,v 1.7 2005/11/07 09:47:23 lechu Exp $
* @package    lang_editor
*/
    $group_selected[@$_REQUEST['group_name']] = 'selected';
    $untranslated_lang_selected[@$_REQUEST['untranslated_lang']] = 'selected';
    $noempty_checked = '';
    if(@$_REQUEST['noempty'] == 'on')
        $noempty_checked = 'checked';
    $part_checked[$__part] = 'checked';
//    print_r($_SESSION);
?>
<br>
<?php echo $lang->_lang_editor_main_info; ?>
<br>
<br>
<?php
for($r = 0; $r < count($editor->languages); $r++){
    if($editor->languages[$r] != 'pl') {
        echo "<a href='/go/_lang_editor/index.php?lang_editor_action=search&report_lang=" . $editor->languages[$r] . "'>
        Generuj raport " . $editor->languages[$r] . "</a><br>";
    }

}
?>
<br>
<table>
<form name=part_form id=part_form action='index.php' method=post>
    <tr>
        <td colspan="2">
            <?php echo $lang->_lang_editor_var_htdocs; ?><input name="__part" type="radio" value="htdocs" <?php echo @$part_checked['htdocs']; ?> onclick="part_form.submit();">&nbsp;&nbsp;
            <?php echo $lang->_lang_editor_var_admin; ?><input name="__part" type="radio" value="admin"  <?php echo @$part_checked['admin']; ?> onclick="part_form.submit();">
        </td>
    </tr>
</form>
<form name=lang_searchform action='index.php?lang_editor_action=search' method=post>
    <tr>
        <td>
            <?php echo $lang->_lang_editor_var_text; ?>
        </td>
        <td>
            <input name=var_value value='<?php echo @$_REQUEST['var_value'] ?>' type="text">
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $lang->_lang_editor_var_name; ?>
        </td>
        <td>
            <input name=var_name value='<?php echo @$_REQUEST['var_name'] ?>' type="text">
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $lang->_lang_editor_var_group; ?>
        </td>
        <td>
            <select name="group_name">
                <option value=''> -- <?php echo $lang->_lang_editor_all_groups; ?> -- </option>
                <option value='main'<?php echo @$group_selected['main'] ?> ><?php echo $lang->_lang_editor_main_group; ?></option>
        <?PHP
            for($i = 0; $i < count($editor->groups); $i++){ ?>
                <option value="<?php echo $editor->groups[$i] ?>" <?php echo @$group_selected[$editor->groups[$i]] ?> ><?php echo $editor->groups[$i] ?></option>
        <?PHP
            }
        ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $lang->_lang_editor_untranslated; ?>
        </td>
        <td>
            <select name="untranslated_lang">
                <option value=''> -- </option>
        <?PHP
            for($i = 0; $i < count($editor->languages); $i++){ ?>
                <option value="<?php echo $editor->languages[$i] ?>" <?php echo @$untranslated_lang_selected[$editor->languages[$i]] ?> ><?php echo $editor->languages[$i] ?></option>
        <?PHP
            }
        ?>
            </select>
        </td>
    </tr>
    <?php
    if(ini_get('error_reporting') == E_ALL) {
    ?>
    <tr>
        <td>
            <?php echo $lang->_lang_editor_noempty; ?>
        </td>
        <td>
            <input type=checkbox name="noempty" <?php echo $noempty_checked; ?>>
        </td>
    </tr>
    <?php
    }
    ?>
    <tr>
        <td>
            &nbsp;
        </td>
        <td align="right">
            <input type=submit value="<?php echo $lang->search; ?>">
        </td>
    </tr>
</form>
</table>

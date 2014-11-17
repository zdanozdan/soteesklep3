<?php
global $config;

$show_unavailable_checked = '';
if ($config->depository['show_unavailable'] == 1) {
    $show_unavailable_checked = 'checked';
}


$return_on_cancel_checked = '';
if ($config->depository['return_on_cancel'] == 1) {
    $return_on_cancel_checked = 'checked';
}
$available_type_to_hide_selected[@$config->depository['available_type_to_hide']] = 'selected';
$update_num_on_action_checked[$config->depository['update_num_on_action']] = 'checked';
?>
<br>
<form action="configure.php" method="POST">
<input type="hidden" name="form[noempty]" value="1">
<table>
    <tr>
        <td><?php echo $lang->show_unavailable; ?>: </td>
        <td><input type="checkbox" name="form[show_unavailable]" value="1" <?php echo $show_unavailable_checked; ?>></td>
    </tr>
    <tr>
        <td><?php echo $lang->available_type_to_hide; ?>: </td>
        <td>
            <select name="form[available_type_to_hide]" >
            <?php
            global $available_res;
            for ($a = 0; $a < count($available_res); $a++) {
                echo "
                <option value='" . $available_res[$a]['user_id'] . "' " . @$available_type_to_hide_selected[$available_res[$a]['user_id']] . ">" . $available_res[$a]['name'] . "</option>";
            }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php echo $lang->general_min_num; ?>: </td>
        <td><input type="text" size="3" name="form[general_min_num]" value="<?php echo $config->depository['general_min_num']; ?>"></td>
    </tr>
    <tr>
        <td valign="top">
            <br>
            <?php echo $lang->update_num_on_action['title']; ?>:
        </td>
        <td valign="top">
            <br>
            <input type="radio" name="form[update_num_on_action]" <?php echo @$update_num_on_action_checked['on_take_order']; ?> value="on_take_order"> <?php echo $lang->update_num_on_action['on_take_order']; ?><br>
            <input type="radio" name="form[update_num_on_action]" <?php echo @$update_num_on_action_checked['on_confirm']; ?> value="on_confirm"> <?php echo $lang->update_num_on_action['on_confirm']; ?><br>
            <input type="radio" name="form[update_num_on_action]" <?php echo @$update_num_on_action_checked['on_paid']; ?> value="on_paid"> <?php echo $lang->update_num_on_action['on_paid']; ?><br>
        </td>
    </tr>
    <tr>
        <td><?php echo $lang->return_on_cancel; ?>: </td>
        <td><input type="checkbox" name="form[return_on_cancel]" value="1" <?php echo $return_on_cancel_checked; ?>></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="<?php echo $lang->confirm; ?>"></td>
    </tr>
</table>

</form>
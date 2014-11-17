<?php
global $config;

$display_availability_checked = '';
if (@$config->depository['display_availability'] == 1) {
    $display_availability_checked = 'checked';
}


?>
<br>
<form action="configure.php" method="POST">
<input type="hidden" name="form[noempty]" value="1">
<table>
    <tr>
        <td><?php echo $lang->display_availability; ?>: </td>
        <td><input type="checkbox" name="form[display_availability]" value="1" <?php echo $display_availability_checked; ?>></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="<?php echo $lang->confirm_conf; ?>"></td>
    </tr>
</table>

</form>
<?php
echo $lang->desc2;
global $config;
$ranking2_checked = '';
if($config->ranking2_enabled == 1) {
    $ranking2_checked = 'checked';
}
?>
<br>
<br>
<table cellpadding="5">
	<tr>
		<td valign="top"><?php echo $lang->gen2_desc; ?></td>
	</tr>
	<tr>
		<td valign="top">
			<form action="gen2.php" method="POST" target="window">
                <button type="button" onclick="window.open('', 'window', 'width=520, height=300, scrollbars=0, status=0, toolbar=0, resizable=0'); this.form.submit();"><?php echo $lang->gen2_button; ?></button>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<br>
			<form action="index2.php" method="POST">
				<input type="hidden" name="action" value="conf2">
				<input type="text" name="ranking2_max_length" size="2" value="<?php echo $config->ranking2_max_length; ?>"> <?php echo $lang->conf2_desc; ?><br>
				<input type="checkbox" name="ranking2_enabled" value="1" <?php echo $ranking2_checked; ?>> <?php echo $lang->conf2_enabled; ?><br>
				<input type="submit" value="<?php echo $lang->conf2_button; ?>">
			</form>
		</td>
	</tr>
</table>
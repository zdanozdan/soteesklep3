<?php
echo $lang->desc1;
global $config;
$ranking1_checked = '';
if($config->ranking1_enabled == 1) {
    $ranking1_checked = 'checked';
}
?>
<br>
<br>
<table cellpadding="5">
	<tr>
		<td valign="top"><?php echo $lang->gen1_desc; ?></td>
	</tr>
	<tr>
		<td valign="top">
			<form action="gen1.php" method="POST" target="window">
				<button type="button" onclick="window.open('', 'window', 'width=520, height=300, scrollbars=0, status=0, toolbar=0, resizable=0'); this.form.submit();"><?php echo $lang->gen1_button; ?></button>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<br>
			<form action="index.php" method="POST">
				<input type="hidden" name="action" value="conf1">
				<input type="text" name="ranking1_max_length" size="2" value="<?php echo $config->ranking1_max_length; ?>"> <?php echo $lang->conf1_desc; ?><br>
				<input type="checkbox" name="ranking1_enabled" value="1" <?php echo $ranking1_checked; ?>> <?php echo $lang->conf1_enabled; ?><br>
				<input type="submit" value="<?php echo $lang->conf1_button; ?>">
			</form>
		</td>
	</tr>
</table>
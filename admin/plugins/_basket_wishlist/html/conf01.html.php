<?php
global $config;
$prod_ext_info_checked = '';
if($config->basket_wishlist['prod_ext_info'] == 1) {
    $prod_ext_info_checked = 'checked';
}
?>
<br>
<br>
<table cellpadding="5">
	<tr>
		<td valign="top"><?php echo $lang->conf01_desc; ?></td>
	</tr>
	<tr>
		<td valign="top">
			<form action="index.php" method="POST">
				<input type="hidden" name="action" value="conf01">
				<input type="checkbox" name="prod_ext_info" value="1" <?php echo $prod_ext_info_checked; ?>> <?php echo $lang->prod_ext_info; ?><br>
				<input type="submit" value="<?php echo $lang->conf01_button; ?>">
			</form>
		</td>
	</tr>
</table>
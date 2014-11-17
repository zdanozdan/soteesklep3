<br><br>
<form action="/plugins/_themes/action_add_delete.php" method="POST">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="confirm" value="1">
<input type="hidden" name="new_theme_name" value="<?php echo $new_theme_name; ?>">
<b><?php echo $new_theme_name; ?></b> - <?php echo $lang->themes_sure_to_erase; ?>
<br>
<input type="submit" value="<?php echo $lang->delete; ?>">
</center>
</form>

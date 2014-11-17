<?php
/**
* @version    $Id: action_add.html.php,v 1.3 2004/12/20 18:00:56 maroslaw Exp $
* @package    themes
*/
?>
<br><br>
<form action="/plugins/_themes/action_add_delete.php" method="POST">
<input type="hidden" name="action" value="add">
<?php echo $lang->themes_enter_name; ?>:<br>
<center>
<input type=text name='new_theme_name' value="<?php echo @$new_theme_name; ?>"><br><br>
<?php echo $lang->themes_set_as_default; ?>:
<input type="checkbox" name="new_theme_default" value="1" <?php echo @$new_theme_defaulf_checked; ?>><br><br>
<input type="submit" value="<?php echo $lang->add; ?>">
</center>
</form>

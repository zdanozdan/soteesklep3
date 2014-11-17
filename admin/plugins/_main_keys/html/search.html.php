<?php
/**
* @version    $Id: search.html.php,v 1.3 2004/12/20 18:00:01 maroslaw Exp $
* @package    main_keys
*/
?>
<p>
<center>

<?php print $lang->main_keys_search_info;?>
<p>

<form action=search2.php name=SearchForm>
<table>
<tr>
  <td align=right><?php print $lang->main_keys_cols['user_id_main'];?></td><td><input type=text name=user_id_main size=16></td>
</tr>
<tr>
  <td align=right><?php print $lang->main_keys_cols['main_key'];?></td><td><input type=text name=main_key size=32></td>
</tr>
<tr>
  <td align=right><?php print $lang->main_keys_cols['order_id'];?></td><td><input type=text name=order_id size=8></td>
</tr>
</table>
<?php
global $buttons;
$buttons->button($lang->search,"javascript:document.SearchForm.submit();");
?>
</form>
</center>

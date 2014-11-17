<?php
/**
* @version    $Id: users_search.html.php,v 1.3 2004/12/20 17:59:15 maroslaw Exp $
* @package    users
*/
global $my_date;
require_once ("HTML/Form.php");
?>

<p>

<center>
<?php print $lang->search_date;?><input type=checkbox name=form[search_date] value=1>
</center>
<table align=center>
<tr>
  <td><?php print $lang->search_from;?></td>
  <td><?php print $my_date->days("from");?></td>
  <td><?php print $my_date->months("from");?></td>
  <td><?php print $my_date->years("from");?></td>
  <td><?php print $lang->search_to;?></td>
  <td><?php print $my_date->days("to");?></td>
  <td><?php print $my_date->months("to");?></td>
  <td><?php print $my_date->years("to");?></td>
</tr>
</table>

<table align=center>
<tr>
  <td><?php print $lang->users['login'];?></td><td><input type=text size=20 name=form[login]></td>
</tr>
<tr>
  <td><?php print $lang->users['name'];?></td><td><input type=text size=20 name=form[name]></td>
</tr>
<tr>
  <td><?php print $lang->users['surname'];?></td><td><input type=text size=20 name=form[surname]></td>
</tr>
<tr>
  <td><?php print $lang->users['email'];?></td><td><input type=text size=20 name=form[email]></td>
</tr>
  <td></td>
  <td>
    <?php print $lang->and;?><input type=radio name=form[and] value=1 checked>
    <?php print $lang->or;?><input type=radio name=form[and] value=0>
  </td>
<tr>
  <td><?php print $lang->users_search_unregister;?></td>
  <td>
    <?php
    HTML_Form::displayCheckbox("form[order_data]",false,1);
    ?>
  </td>
</tr>
</table>

<center><input type=submit value='<?php print $lang->search_submit;?>'></center>
  
<p><br>

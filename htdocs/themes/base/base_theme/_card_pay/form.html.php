<?php 
global $my_form_check,$card_form;

$this->theme_file("cardpay_info.html");
?>

<form action="/go/_register/register3.php" method="post">
<input type="hidden" name="submit_cardpay" value="true"><br>
<table cellpadding="0" cellspacing="3">
	<tr>
		<td>
		<?php print $lang->cardpay['card_number'];
		 ?>
		</td>
		<td>
		<input type="text" size="20" maxlength="19" name="card[card_id]" value="<?php print @$card_form['card_id'];?>"><br>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		<font style="color: red;"><?php print @$my_form_check->errors_found['card_id'] ?></font>
		</td>
	</tr>
	<tr>
		<td>
		<?php print $lang->cardpay['cvv'];?>
		</td>
		<td>
		<input type="text" size="3" name="card[cvv]" maxlength="3" value="<?php print @$card_form['cvv'];?>"><br>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		<font style="color: red;"><?php print @$my_form_check->errors_found['cvv'] ?></font>
		</td>
	</tr>
	<tr>
		<td>
		<?php print $lang->cardpay['exp_year']; ?>
		</td>
		<td>
		<input type="text" name="card[exp_year]" size="4" maxlength="4" value="<?php print @$card_form['exp_year'];?>"><br>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		<font style="color: red;"><?php print @$my_form_check->errors_found['exp_year'] ?></font>
		</td>
	</tr>
	<tr>
		<td>
		<?php print $lang->cardpay['exp_month']; ?>
		</td>
		<td>
		<input type="text" name="card[exp_month]" size="2" maxlength="2" value="<?php print @$card_form['exp_month'];?>"><br>
		</td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
		<font style="color: red;"><?php print @$my_form_check->errors_found['exp_month'] ?></font>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-top: 5px;"align="center">
		<input type="submit" value="OK" value="submit"><br>
		</td>
	</tr>
</table>
</form>
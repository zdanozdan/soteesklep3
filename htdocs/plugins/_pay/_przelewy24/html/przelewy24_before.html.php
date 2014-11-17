<center>
<table width=70%>
<tr>
  <td width="50%"  valign="top">
    <img src=/themes/base/base_theme/_img/przelewy24.jpg><br />
  </td>
  <td width="50%" valign="top">
    <p />
    <?php print $lang->przelewy24_info;?><br />
  </td>
</tr>
</table>
</center>

<form action="https://secure.przelewy24.pl/index.php" method="post">
<input type=hidden name="p24_session_id" value="<?php print $_SESSION['order_session'];?>">
<input type=hidden name="p24_id_sprzedawcy" value="<?php print $przelewy24_config->posid;?>">
<input type=hidden name="p24_kwota" value="<?php print $__amount;?>">
<!--<input type=hidden name="p24_opis" value="TEST_OK">-->
<input type=hidden name="p24_opis" value="<?php 
if ($przelewy24_config->status=='1') {
		print $basket->orderDescription();
}	else print "TEST_OK";
	?>">
<input type=hidden name="p24_return_url_ok" value="http://<?php print $_SERVER['HTTP_HOST']."/plugins/_pay/_przelewy24/confirm_check.php?sess_id=".$_SESSION['order_session'];?>">
<input type=hidden name="p24_return_url_error" value="http://<?php print $_SERVER['HTTP_HOST']."/plugins/_pay/_przelewy24/error.php?sess_id=".$_SESSION['order_session'];?>">

<?php
/*
2004-10-19 rozszerzenie opcji zwi±zanych z pe³niejsz± weryfikacj± PolCard
Dodatkowe parametry:

p24_klient - imiê i nazwisko odbiorcy zamówienia. 
p24_adres - ulica i numer odbiorcy. 
p24_kod - kod pocztowy odbiorcy. 
p24_miasto - miejscowo¶æ odbiorcy. 
p24_kraj - kraj odbiorcy (kod kraju np:PL,DE,itp lub nazwa). 
p24_email - e-mail kupuj±cego.
*/
?>

<input type=hidden name=p24_klient value='<?php print Przelewy24::getInfo('p24_klient');?>'>
<input type=hidden name=p24_adres value='<?php print Przelewy24::getInfo('p24_adres');?>'>
<input type=hidden name=p24_miasto value='<?php print Przelewy24::getInfo('p24_miasto');?>'>
<input type=hidden name=p24_kraj value='<?php print Przelewy24::getInfo('p24_kraj');?>'>
<input type=hidden name=p24_email value='<?php print Przelewy24::getInfo('p24_email');?>'>

<?php
/**
2004-03-16 dodatkowe pola zwi±zane z pe³na implementacj± obs³ugi przelewy24
*/
?>
<input type=hidden name=p24_kod value='<?php print Przelewy24::getInfo('p24_kod');?>'>
<input type=hidden name=p24_language value='<?php print Przelewy24::getInfo('p24_language');?>'>

<?php 
if ($przelewy24_config->active==1) {
?>
<input type=submit name="submit_end" value="<?php print $lang->przelewy24_next;?>">
<?php 
}
?>
</form>

<?php
/**
* @version    $Id: login.html.php,v 2.2 2004/12/20 18:02:36 maroslaw Exp $
* @package    market
*/
?>
<center>
<p>

<form action=login.php method=POST>
<?php $this->bar("Logowanie: edycja ogloszenia",300);?>
<table bgcolor=<?php print $config->market_info_color;?> width=300>
<tr>
    <td>Login</td><td><input type=text size=16 name=item[login]></td>
</tr>
<tr>
    <td>Haslo</td><td><input type=password size=16 name=item[password]></td>
</tr>
<tr>
    <td></td>
    <td><input type=submit value='zaloguj sie'></td>
</tr>
</table>

</center>

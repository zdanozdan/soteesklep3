<?php
/**
* @version    $Id: search_form.html.php,v 2.2 2004/12/20 18:02:37 maroslaw Exp $
* @package    market
*/
?>
<p>

<center>
<?php $this->bar("Wyszukiwanie ogloszen",350);?>
<form action=search.php method=POST>
<input type=hidden name=update value=true>
<table align=center bgcolor=<?php print $config->market_info_color;?> width=350>
<tr>
    <td>Szukaj wyrazenia</td>
    <td><input type=text size=20 name=item[query]></td>
</tr>
<tr>
    <td>Kategoria</td>
    <td><?php market_category("","all");?></td>
</tr>
<tr>
    <td>Ze zdjeciem</td>
    <td><input type=checkbox name=item[photo]></td>
</tr>
<tr>
    <td> </td>
    <td><input type=submit value='Wyszukaj ogloszenia'></td>
</tr>
</table>
</form>
</center>

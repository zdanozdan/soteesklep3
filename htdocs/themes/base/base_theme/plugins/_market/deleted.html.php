<?php
/**
* @version    $Id: deleted.html.php,v 2.2 2004/12/20 18:02:36 maroslaw Exp $
* @package    market
*/
?>
<p>

<center>
<?php $this->bar("Ogloszenie zostalo skasowane",300);?>
<table bgcolor="<?php print $config->market_info_color;?>" width=300>
<tr>
<td align=center> 
  <form action=index.php method=post>
  <input type=submit value='Przejdz do listy ogloszen'>
</form>
</td>
</tr>
</table>

</center>

<?php
/**
* @version    $Id: polcard_before.html.php,v 2.7 2005/02/10 14:09:38 lechu Exp $
* @package    polcard
*/
?>
<center>
<p>
<?php
print $lang->bar_title['polcard'];
echo "<br><br>
<table><tr><td style='vertical-align: top;'>
<img src='"; $this->img("_img/_polcard/3d_visa.gif"); echo "' border=0></td>
";
echo "<td style='vertical-align: top;'>
<img src='"; $this->img("_img/_polcard/baner_polcard.gif"); echo "' border=0></td>
";
echo "<td style='vertical-align: top;'>
<img src='"; $this->img("_img/_polcard/3d _mastercard.gif"); echo "' border=0></td>
</tr></table>
<br>";
?>

<br />
<?php print $lang->register_polcard_cards;
print "<br><br>";
global $polcard;
if (! empty($polcard)) {
   print $polcard->form();
} 
?> 

<p>
</center>

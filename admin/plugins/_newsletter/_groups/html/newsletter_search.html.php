<?php
/**
* Formularz wyszukiwania grupy newslettera.
* 
* @author  rdiak@sote.pl
* @version $Id: newsletter_search.html.php,v 2.6 2004/12/20 18:00:14 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

?>
<form action=<?php print $action;?> method=POST>
<input type=hidden name=search value=true>
<p>

<center>
<?php $theme->desktop_open("400"); ?>

<table align=center>
<tr>
   <td><?php print $lang->newsletter_cols['string']?></td>
   <td><input type=text size=30 name=item[string]><br>
   </td>
</tr>
<tr>
 <td></td><td align=center><input type=submit value="<?php print $lang->newsletter_search;?>">
</tr>
</table>
<?php $theme->desktop_close(); ?>

</center>
</form>

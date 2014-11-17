<?php
/**
 * Strona pobierania kategorii wp.
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_close.html.php,v 1.3 2004/12/20 18:00:35 maroslaw Exp $
 *
* @package    pasaz.wp.pl
 */
?>
<p>
<center>
<?php
global $buttons,$lang;
?>
<table><tr><td>
<?php $buttons->button($lang->close,"javascript:window.close();"); ?>
</td>
</tr>
</table>
</center>

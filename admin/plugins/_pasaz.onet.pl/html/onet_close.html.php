<?php
/**
 * Okienko z buttonem zamykaj±cym je onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_close.html.php,v 1.3 2004/12/20 18:00:30 maroslaw Exp $
* @package    pasaz.onet.pl
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

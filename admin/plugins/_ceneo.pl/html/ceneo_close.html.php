<?php
/**
 * Okienko z buttonem zamykaj±cym je onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_close.html.php,v 1.4 2006/08/16 10:41:41 lukasz Exp $
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

<?php
/**
* Strona z informacjami o wykonaniu ³adowania offline
*
* @author  rdiak@sote.pl
* @version $Id: status.html.php,v 2.5 2004/12/20 17:58:29 maroslaw Exp $
* @package    offline
* @subpackage main
*/
?>

<?php global $lang ;?>
<p>
<table align=center width=95%>
<tr>
<td>

<B><?php print $lang->offline_update_errors;?></B><P>

<?php $error2file->error_log();?>

</td>
</tr>
</table>

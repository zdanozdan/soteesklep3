<?php
/**
 * Strona g³ówna modu³u onet pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_pasaz.html.php,v 1.4 2004/12/20 18:00:31 maroslaw Exp $
 *
* @package    pasaz.onet.pl
 */
?>
<table align=center width=95%><tr><td>

&nbsp;<?php print $lang->onet_pasaz['title']; ?> 
<p>
<ul>
 <li> <?php print $lang->onet_pasaz['config']; ?> <a href=/plugins/_pasaz.onet.pl/config.php><u><?php print $lang->onet_options["config"]; ?></u></a>
 <li> <?php print $lang->onet_pasaz['export']; ?> <a href=/plugins/_pasaz.onet.pl/export.php><u><?php print $lang->onet_options["export"]; ?></u></a>
 <li> <?php print $lang->onet_pasaz['category']; ?> <a href=/plugins/_pasaz.onet.pl/category.php><u><?php print $lang->onet_options["category"]; ?></u></a>
 <li> <?php print $lang->onet_pasaz['transaction']; ?> <a href=/plugins/_pasaz.onet.pl/transaction.php><u><?php print $lang->onet_options["trans"]; ?></u></a>

<p>
</td></tr></table>

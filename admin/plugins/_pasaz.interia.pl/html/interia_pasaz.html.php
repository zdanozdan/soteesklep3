<?php
/**
 * Strona g³owna modu³u.
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_pasaz.html.php,v 1.1 2005/03/29 15:13:59 scalak Exp $
 *
* @package    pasaz.interia.pl
 */
?>
<table align=center width=95%><tr><td>

&nbsp;<?php print $lang->interia_pasaz['title']; ?> 
<p>
<ul>
 <li> <?php print $lang->interia_pasaz['config']; ?> <a href=/plugins/_pasaz.interia.pl/config.php><u><?php print $lang->interia_options["config"]; ?></u></a>
 <li> <?php print $lang->interia_pasaz['export']; ?> <a href=/plugins/_pasaz.interia.pl/export.php><u><?php print $lang->interia_options["export"]; ?></u></a>
 <li> <?php print $lang->interia_pasaz['category']; ?> <a href=/plugins/_pasaz.interia.pl/category.php><u><?php print $lang->interia_options["category"]; ?></u></a>
 <li> <?php print $lang->interia_pasaz['transaction']; ?> <a href=/plugins/_pasaz.interia.pl/transaction.php><u><?php print $lang->interia_options["trans"]; ?></u></a>

<p>
</td></tr></table>

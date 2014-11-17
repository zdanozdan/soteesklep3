<?php
/**
 * Strona g³owna modu³u.
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_pasaz.html.php,v 1.3 2004/12/20 18:00:35 maroslaw Exp $
 *
* @package    pasaz.wp.pl
 */
?>
<table align=center width=95%><tr><td>

&nbsp;<?php print $lang->wp_pasaz['title']; ?> 
<p>
<ul>
 <li> <?php print $lang->wp_pasaz['config']; ?> <a href=/plugins/_pasaz.wp.pl/config.php><u><?php print $lang->wp_options["config"]; ?></u></a>
 <li> <?php print $lang->wp_pasaz['export']; ?> <a href=/plugins/_pasaz.wp.pl/export.php><u><?php print $lang->wp_options["export"]; ?></u></a>
 <li> <?php print $lang->wp_pasaz['category']; ?> <a href=/plugins/_pasaz.wp.pl/category.php><u><?php print $lang->wp_options["category"]; ?></u></a>
 <li> <?php print $lang->wp_pasaz['transaction']; ?> <a href=/plugins/_pasaz.wp.pl/transaction.php><u><?php print $lang->wp_options["trans"]; ?></u></a>

<p>
</td></tr></table>
